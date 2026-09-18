<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Services\ExportEmployeeBuilder;
use App\Services\AssessmentScoreCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminCycleController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && (Auth::user()->role ?? '') === 'admin', 403);
    }

    private function nextAutoCode(): string
    {
        $max = 0;
        $codes = Cycle::query()->pluck('code');

        foreach ($codes as $code) {
            $code = (string)$code;
            if (preg_match('/Q(\d+)$/', $code, $m)) {
                $n = (int)$m[1];
                if ($n > $max) $max = $n;
            }
        }

        $next = $max + 1;

        while (Cycle::query()->where('code', 'CodeQ' . $next)->exists()) {
            $next++;
        }

        return 'CodeQ' . $next;
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();
        $cycles = Cycle::query()->orderByDesc('id')->paginate(20);
        return view('cycle', compact('cycles'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $request->validate([
            'name'       => ['required','string','max:120'],
            'start_date' => ['nullable','date'],
            'end_date'   => ['nullable','date'],
            'note'       => ['nullable','string'],
        ]);

        $cycle = new Cycle();
        $cycle->name       = (string)$request->input('name');
        $cycle->code       = $this->nextAutoCode();
        $cycle->start_date = $request->input('start_date');
        $cycle->end_date   = $request->input('end_date');
        $cycle->note       = $request->input('note');
        $cycle->status     = Cycle::STATUS_CLOSED;
        $cycle->is_active  = false;
        $cycle->opened_at  = null;
        $cycle->closed_at  = null;
        $cycle->save();

        return redirect()->route('admin.cycles')->with('ok', app()->getLocale()==='en' ? 'Cycle created.' : 'สร้างรอบสำเร็จ');
    }

    public function activate(Cycle $cycle, ExportEmployeeBuilder $builder, AssessmentScoreCalculator $calculator)
    {
        $this->ensureAdmin();

        DB::transaction(function () use ($cycle, $builder, $calculator) {
            $prev = Cycle::query()
                ->where('is_active', true)
                ->where('id', '!=', $cycle->id)
                ->lockForUpdate()
                ->get();

            foreach ($prev as $p) {
                $builder->archiveCycleToHistory((int)$p->id);
                $p->is_active = false;
                $p->status = Cycle::STATUS_CLOSED;
                $p->closed_at = now();
                $p->save();
            }

            $cycle->is_active = true;
            $cycle->status = Cycle::STATUS_OPEN;
            $cycle->opened_at = now();
            $cycle->closed_at = null;
            $cycle->save();

            $this->resetEmployeesAssessmentStatusOnOpen();

            if (method_exists($builder, 'syncAllEmployeesInCycle')) {
                $builder->syncAllEmployeesInCycle((int)$cycle->id, true);
            } elseif (method_exists($builder, 'syncAndComputeAllEmployeesInCycle')) {
                $builder->syncAndComputeAllEmployeesInCycle((int)$cycle->id, true);
            }

            if (Schema::hasTable('export_employees')) {
                $calculator->computeAllInCycle((int)$cycle->id);
                $this->syncExportEmployeeSupervisorLinkLAOnOpen((int)$cycle->id);
            }

            $this->resetExportEmployeesAssessmentStatusOnOpen((int)$cycle->id);
        });

        return back()->with('ok', app()->getLocale()==='en' ? 'Cycle opened.' : 'เปิดรอบสำเร็จ');
    }

    public function enableReadMode(Cycle $cycle)
    {
        $this->ensureAdmin();

        if (!Schema::hasColumn('cycles', 'is_read_mode')) {
            return back()->withErrors([
                'read_mode' => app()->getLocale() === 'en'
                    ? 'Column is_read_mode not found on cycles table.'
                    : 'ไม่พบคอลัมน์ is_read_mode ในตาราง cycles',
            ]);
        }

        $cycle->is_read_mode = !((bool)($cycle->is_read_mode ?? false));
        $cycle->save();

        if ($cycle->is_read_mode) {
            return back()->with('ok', app()->getLocale() === 'en' ? 'Read mode enabled.' : 'เปิดโหมด Read แล้ว');
        }

        return back()->with('ok', app()->getLocale() === 'en' ? 'Read mode disabled.' : 'ปิดโหมด Read แล้ว');
    }

    public function close(Cycle $cycle, ExportEmployeeBuilder $builder, AssessmentScoreCalculator $calculator)
    {
        $this->ensureAdmin();

        DB::transaction(function () use ($cycle, $builder, $calculator) {
            if (Schema::hasTable('export_employees')) {
                $calculator->computeAllInCycle((int)$cycle->id);
                $this->syncExportEmployeeSupervisorLinkLAOnOpen((int)$cycle->id);
                $this->resetExportEmployeesAssessmentStatusOnOpen((int)$cycle->id);
            }

            $builder->archiveCycleToHistory((int)$cycle->id);

            $cycle->is_active = false;
            $cycle->status = Cycle::STATUS_CLOSED;
            $cycle->closed_at = now();
            $cycle->save();

            $builder->clearExportForCycle((int)$cycle->id);
        });

        return back()->with('ok', app()->getLocale()==='en' ? 'Cycle closed.' : 'ปิดรอบสำเร็จ');
    }

    public function destroy(Cycle $cycle)
    {
        $this->ensureAdmin();

        if ($cycle->is_active) {
            return back()->withErrors(['delete' => app()->getLocale()==='en' ? 'Cannot delete an active cycle.' : 'ห้ามลบรอบที่กำลัง ACTIVE']);
        }

        if (!empty($cycle->opened_at)) {
            return back()->withErrors(['delete' => app()->getLocale()==='en' ? 'Cannot delete a cycle that has been opened before.' : 'ห้ามลบรอบที่เคยเปิดแล้ว']);
        }

        $cycle->delete();
        return back()->with('ok', app()->getLocale()==='en' ? 'Deleted.' : 'ลบสำเร็จ');
    }

    private function resetEmployeesAssessmentStatusOnOpen(): void
    {
        if (!Schema::hasTable('employees')) return;
        if (!Schema::hasColumn('employees', 'assessment_status')) return;

        $hasPosLevel = Schema::hasColumn('employees', 'position_level');
        $hasPos      = Schema::hasColumn('employees', 'position');
        $hasSup      = Schema::hasColumn('employees', 'sup_id');
        $hasDiv      = Schema::hasColumn('employees', 'div_mgr_id');
        $hasUpdated  = Schema::hasColumn('employees', 'updated_at');

        $select = ['employee_code', 'assessment_status'];
        if ($hasPosLevel) $select[] = 'position_level';
        if ($hasPos)      $select[] = 'position';
        if ($hasSup)      $select[] = 'sup_id';
        if ($hasDiv)      $select[] = 'div_mgr_id';

        $now = now();

        DB::table('employees')
            ->orderBy('employee_code')
            ->select($select)
            ->chunk(800, function ($rows) use ($hasPosLevel, $hasPos, $hasSup, $hasDiv, $hasUpdated, $now) {
                $up = [];

                foreach ($rows as $r) {
                    $code = (string)($r->employee_code ?? '');
                    if ($code === '') continue;

                    $lvl = null;
                    if ($hasPosLevel && isset($r->position_level) && $r->position_level !== null && $r->position_level !== '') {
                        $lvl = (int)$r->position_level;
                    } elseif ($hasPos) {
                        $pos = $this->cleanText($r->position ?? '');
                        if ($pos !== '') $lvl = $this->detectPositionLevel($pos);
                    }

                    if ($lvl !== null && $lvl >= 6) {
                        $status = '0/0';
                    } else {
                        $sup = $hasSup ? (string)($r->sup_id ?? '') : '';
                        $div = $hasDiv ? (string)($r->div_mgr_id ?? '') : '';

                        $supCode = $this->digitsOnly($sup);
                        $divCode = $this->digitsOnly($div);

                        $required = 0;
                        if ($supCode !== '') $required++;
                        if ($divCode !== '' && $divCode !== $supCode) $required++;
                        if ($required <= 0) $required = 1;

                        $status = '0/' . $required;
                    }

                    $row = [
                        'employee_code' => $code,
                        'assessment_status' => $status,
                    ];

                    if ($hasUpdated) $row['updated_at'] = $now;

                    $up[] = $row;
                }

                if ($up) {
                    $updateCols = ['assessment_status'];
                    if ($hasUpdated) $updateCols[] = 'updated_at';

                    DB::table('employees')->upsert($up, ['employee_code'], $updateCols);
                }
            });
    }

    private function syncExportEmployeeSupervisorLinkLAOnOpen(int $cycleId): void
    {
        if ($cycleId <= 0) return;
        if (!Schema::hasTable('export_employees')) return;

        $hasSL = Schema::hasColumn('export_employees', 'score_leadership');
        $hasSA = Schema::hasColumn('export_employees', 'score_attitude');
        $hasSupSL = Schema::hasColumn('export_employees', 'supervisor_score_leadership');
        $hasSupSA = Schema::hasColumn('export_employees', 'supervisor_score_attitude');

        if (!$hasSL || !$hasSA || !$hasSupSL || !$hasSupSA) return;

        DB::table('export_employees')
            ->where('cycle_id', $cycleId)
            ->whereNull('supervisor_score_leadership')
            ->whereNotNull('score_leadership')
            ->update(['supervisor_score_leadership' => DB::raw('score_leadership')]);

        DB::table('export_employees')
            ->where('cycle_id', $cycleId)
            ->whereNull('score_leadership')
            ->whereNotNull('supervisor_score_leadership')
            ->update(['score_leadership' => DB::raw('supervisor_score_leadership')]);

        DB::table('export_employees')
            ->where('cycle_id', $cycleId)
            ->whereNull('supervisor_score_attitude')
            ->whereNotNull('score_attitude')
            ->update(['supervisor_score_attitude' => DB::raw('score_attitude')]);

        DB::table('export_employees')
            ->where('cycle_id', $cycleId)
            ->whereNull('score_attitude')
            ->whereNotNull('supervisor_score_attitude')
            ->update(['score_attitude' => DB::raw('supervisor_score_attitude')]);
    }

    private function resetExportEmployeesAssessmentStatusOnOpen(int $cycleId): void
    {
        if ($cycleId <= 0) return;
        if (!Schema::hasTable('export_employees')) return;
        if (!Schema::hasColumn('export_employees', 'assessment_status')) return;
        if (!Schema::hasColumn('export_employees', 'id')) return;

        $hasPosLevel = Schema::hasColumn('export_employees', 'position_level');
        $hasPos      = Schema::hasColumn('export_employees', 'position');
        $hasSup      = Schema::hasColumn('export_employees', 'sup_id');
        $hasDiv      = Schema::hasColumn('export_employees', 'div_mgr_id');
        $hasUpdated  = Schema::hasColumn('export_employees', 'updated_at');

        $hasSL = Schema::hasColumn('export_employees', 'score_leadership');
        $hasSA = Schema::hasColumn('export_employees', 'score_attitude');
        $hasSupSL = Schema::hasColumn('export_employees', 'supervisor_score_leadership');
        $hasSupSA = Schema::hasColumn('export_employees', 'supervisor_score_attitude');
        $hasDivSL = Schema::hasColumn('export_employees', 'division_score_leadership');
        $hasDivSA = Schema::hasColumn('export_employees', 'division_score_attitude');

        $select = ['id'];
        if ($hasPosLevel) $select[] = 'position_level';
        if ($hasPos)      $select[] = 'position';
        if ($hasSup)      $select[] = 'sup_id';
        if ($hasDiv)      $select[] = 'div_mgr_id';

        if ($hasSL) $select[] = 'score_leadership';
        if ($hasSA) $select[] = 'score_attitude';
        if ($hasSupSL) $select[] = 'supervisor_score_leadership';
        if ($hasSupSA) $select[] = 'supervisor_score_attitude';
        if ($hasDivSL) $select[] = 'division_score_leadership';
        if ($hasDivSA) $select[] = 'division_score_attitude';

        $now = now();
        $nowStr = $now->toDateTimeString();

        DB::table('export_employees')
            ->where('cycle_id', $cycleId)
            ->orderBy('id')
            ->select($select)
            ->chunk(800, function ($rows) use ($hasPosLevel, $hasPos, $hasSup, $hasDiv, $hasUpdated, $hasSL, $hasSA, $hasSupSL, $hasSupSA, $hasDivSL, $hasDivSA, $nowStr) {
                $statusById = [];

                foreach ($rows as $r) {
                    $id = (int)($r->id ?? 0);
                    if ($id <= 0) continue;

                    $lvl = null;
                    if ($hasPosLevel && isset($r->position_level) && $r->position_level !== null && $r->position_level !== '') {
                        $lvl = (int)$r->position_level;
                    } elseif ($hasPos) {
                        $pos = $this->cleanText($r->position ?? '');
                        if ($pos !== '') $lvl = $this->detectPositionLevel($pos);
                    }

                    if ($lvl !== null && $lvl >= 6) {
                        $statusById[$id] = '0/0';
                        continue;
                    }

                    $sup = $hasSup ? (string)($r->sup_id ?? '') : '';
                    $div = $hasDiv ? (string)($r->div_mgr_id ?? '') : '';

                    $supCode = $this->digitsOnly($sup);
                    $divCode = $this->digitsOnly($div);

                    $required = 0;
                    $needSup = false;
                    $needDiv = false;

                    if ($supCode !== '') {
                        $required++;
                        $needSup = true;
                    }

                    if ($divCode !== '' && $divCode !== $supCode) {
                        $required++;
                        $needDiv = true;
                    } elseif ($divCode !== '' && $divCode === $supCode) {
                        $needDiv = true;
                    }

                    if ($required <= 0) {
                        $required = 1;
                        $needSup = true;
                    }

                    $sameAssessor = ($supCode !== '' && $divCode !== '' && $supCode === $divCode);

                    $sLead = null;
                    $sAtt = null;

                    if ($hasSL && isset($r->score_leadership)) $sLead = $this->numOrNull($r->score_leadership);
                    if ($sLead === null && $hasSupSL && isset($r->supervisor_score_leadership)) $sLead = $this->numOrNull($r->supervisor_score_leadership);

                    if ($hasSA && isset($r->score_attitude)) $sAtt = $this->numOrNull($r->score_attitude);
                    if ($sAtt === null && $hasSupSA && isset($r->supervisor_score_attitude)) $sAtt = $this->numOrNull($r->supervisor_score_attitude);

                    $supervisorDone = ($sLead !== null && $sAtt !== null);

                    $dLead = null;
                    $dAtt = null;

                    if ($hasDivSL && isset($r->division_score_leadership)) $dLead = $this->numOrNull($r->division_score_leadership);
                    if ($hasDivSA && isset($r->division_score_attitude)) $dAtt = $this->numOrNull($r->division_score_attitude);

                    $divisionDone = ($dLead !== null && $dAtt !== null);

                    $done = 0;

                    if ($required === 1 && $sameAssessor) {
                        $done = ($supervisorDone || $divisionDone) ? 1 : 0;
                    } else {
                        if ($needSup && $supervisorDone) $done++;
                        if ($needDiv && !$sameAssessor && $divisionDone) $done++;
                        if ($needDiv && $sameAssessor && $divisionDone && !$supervisorDone && $required === 1) $done = 1;
                    }

                    if ($done > $required) $done = $required;

                    $statusById[$id] = $done . '/' . $required;
                }

                if (!$statusById) return;

                $ids = array_keys($statusById);
                sort($ids);

                $whenParts = [];
                $bindings = [];

                foreach ($ids as $id) {
                    $whenParts[] = "WHEN {$id} THEN ?";
                    $bindings[] = $statusById[$id];
                }

                $sql = "UPDATE export_employees SET assessment_status = CASE id " . implode(' ', $whenParts) . " ELSE assessment_status END";
                if ($hasUpdated) {
                    $sql .= ", updated_at = ?";
                    $bindings[] = $nowStr;
                }
                $sql .= " WHERE id IN (" . implode(',', $ids) . ")";

                DB::update($sql, $bindings);
            });
    }

    private function digitsOnly($v): string
    {
        $s = (string)($v ?? '');
        $s = preg_replace('/\D/', '', $s);
        return $s ?: '';
    }

    private function numOrNull($v): ?float
    {
        if ($v === null) return null;
        if (is_int($v) || is_float($v)) return (float)$v;

        $s = trim((string)$v);
        if ($s === '') return null;

        $k = strtolower($s);
        $k = preg_replace('/\s+/', '', $k) ?? $k;
        if (in_array($k, ['na','n/a','n\\a','-','--','–','—'], true)) return null;

        $s = str_replace([',',' '], '', $s);
        if (!is_numeric($s)) return null;

        return (float)$s;
    }

    private function detectPositionLevel(string $position): ?int
    {
        $p = trim(mb_strtolower($position, 'UTF-8'));
        if ($p === '') return null;

        $p = preg_replace('/\s+/u', ' ', $p);
        $p = str_replace(['.', ',', '(', ')', '/', '\\'], ' ', $p);
        $p = preg_replace('/\s+/u', ' ', $p);
        $p = trim($p);

        $map = [
            1 => ['cooking','driver','maid','operator','senior operator','support mat','tp man'],
            2 => ['foreman','leader','senior staff','senior technician','staff','technician'],
            3 => ['engineer','senior engineer','supervisor'],
            4 => ['assist manager','assistant manager','manager'],
            5 => ['deputy general manager','general manager','gm'],
            6 => ['chief financial officer','cfo'],
            7 => ['chief executive officer','ceo'],
            8 => ['president'],
        ];

        foreach ($map as $lvl => $keys) {
            foreach ($keys as $k) {
                if ($p === $k) return $lvl;
                if (str_contains($p, $k)) return $lvl;
            }
        }

        return null;
    }

    private function cleanText($v): string
    {
        $s = trim((string) $v);
        if ($s === '') return '';
        return trim(html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }
}

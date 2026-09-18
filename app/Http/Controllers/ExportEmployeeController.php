<?php

namespace App\Http\Controllers;

use App\Exports\ExportEmployeesHistoryExport;
use App\Models\Cycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class ExportEmployeeController extends Controller
{
    public function export(Request $request)
    {
        $cycleId = (int) $request->query('cycle_id', 0);
        $targetId = $cycleId > 0 ? $cycleId : (int) (Cycle::activeId() ?? 0);

        $cycleCode = '';
        if ($targetId > 0 && Schema::hasTable('cycles')) {
            $c = Cycle::query()->where('id', $targetId)->first();
            $cycleCode = trim((string) ($c->code ?? ''));
        }
        if ($cycleCode === '') $cycleCode = $targetId > 0 ? ('CYCLE_' . $targetId) : 'ACTIVE';

        $fileName = 'employee_assessments_' . $cycleCode . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new ExportEmployeesHistoryExport($targetId > 0 ? $targetId : null), $fileName);
    }
}

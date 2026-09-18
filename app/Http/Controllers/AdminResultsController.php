<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminResultsController extends Controller
{
    private function ensureCanDownload(): void
    {
        abort_unless(Auth::check(), 403);

        $u = Auth::user();
        $code = trim((string)($u->username ?? ''));

 
        $allViewCodes = ['60002','60003','60004','65049'];

        $ok = (($u->role ?? null) === 'admin') || in_array($code, $allViewCodes, true);

        if (!$ok && method_exists($u, 'canViewEmployeesEvaluation')) {
            $ok = (bool)$u->canViewEmployeesEvaluation();
        }

        abort_unless($ok, 403);
    }

    public function index(Request $request)
    {
        $this->ensureCanDownload();

        $cycles = Cycle::query()
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->query());

        return view('download', [
            'cycles' => $cycles,
        ]);
    }

    public function download(Cycle $cycle)
    {
        $this->ensureCanDownload();

        return redirect()->route('export_employees.excel', [
            'cycle_id' => $cycle->id,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

class EmployeeImportTemplateController extends Controller
{
    public function download()
    {
        $candidates = [
            public_path('templates/assessment_import_template.xlsx'),
            public_path('templates/assessment_import_template.xls'),
            public_path('templates/assessment_import_template.csv'),
            public_path('templates/ฟอร์ม import ตารางประเมินคะแนน.xlsx'),
            public_path('templates/ฟอร์ม import ตารางประเมินคะแนน.xls'),
            public_path('templates/ฟอร์ม import ตารางประเมินคะแนน.csv'),
        ];

        $path = null;
        foreach ($candidates as $p) {
            if (is_file($p)) {
                $path = $p;
                break;
            }
        }

        if (!$path) {
            abort(404);
        }

        $ext = strtolower((string) pathinfo($path, PATHINFO_EXTENSION));
        $downloadName = 'ดาวน์โหลดโครงสร้างการประเมิน (แบบฟอร์ม excel).' . ($ext !== '' ? $ext : 'xlsx');

        $mime = match ($ext) {
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xls'  => 'application/vnd.ms-excel',
            'csv'  => 'text/csv',
            default => 'application/octet-stream',
        };

        return response()->download($path, $downloadName, ['Content-Type' => $mime]);
    }
}

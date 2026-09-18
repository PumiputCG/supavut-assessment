<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{

    private function toArabicDigits(string $s): string
    {
        $map = [
            '๐' => '0','๑' => '1','๒' => '2','๓' => '3','๔' => '4',
            '๕' => '5','๖' => '6','๗' => '7','๘' => '8','๙' => '9',
            '໐' => '0','໑' => '1','໒' => '2','໓' => '3','໔' => '4',
            '໕' => '5','໖' => '6','໗' => '7','໘' => '8','໙' => '9',
        ];
        return strtr($s, $map);
    }

 
    private function normalizeCitizenId(?string $id): ?string
    {
        if ($id === null) return null;
        $id = $this->toArabicDigits($id);
        $id = preg_replace('/\D+/', '', $id); // เอาเฉพาะ 0-9
        $id = trim((string) $id);
        return $id === '' ? null : $id;
    }

    private function getEmployeeCitizenId(Employee $emp): ?string
    {
        $raw =
            $emp->getAttribute('citizen_id')
            ?? $emp->getAttribute('id_card')
            ?? $emp->getAttribute('national_id')
            ?? $emp->getAttribute('id_no')
            ?? $emp->getAttribute('personal_id');

        return $this->normalizeCitizenId(is_string($raw) ? $raw : null);
    }

    public function showForm()
    {
        /** @var AppUser|null $user */
        $user = Auth::user();
        if (! $user) {
            abort(403, 'กรุณาเข้าสู่ระบบ');
        }

        return view('auth.reset_password_plain', [
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        /** @var AppUser|null $user */
        $user = Auth::user();
        if (! $user) {
            abort(403, 'กรุณาเข้าสู่ระบบ');
        }

        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'citizen_id'       => ['required', 'string'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'กรุณากรอกรหัสผ่านเดิม',
            'citizen_id.required'       => 'กรุณากรอกรหัสบัตรประชาชน',
            'password.required'         => 'กรุณากรอกรหัสผ่านใหม่',
            'password.min'              => 'รหัสผ่านใหม่ต้องมีอย่างน้อย 8 ตัวอักษร',
            'password.confirmed'        => 'ยืนยันรหัสผ่านใหม่ไม่ตรงกัน',
        ]);

        // 1) ตรวจรหัสผ่านเก่า
        if (! Hash::check($data['current_password'], (string) $user->password)) {
            return back()
                ->withErrors(['current_password' => 'รหัสผ่านเดิมไม่ถูกต้อง'])
                ->withInput($request->except(['current_password', 'password', 'password_confirmation']));
        }

        // 2) ตรวจเลขบัตรประชาชน 
        $emp = Employee::where('employee_code', $user->username)->first();
        if (! $emp) {
            return back()->withErrors(['citizen_id' => 'ไม่พบข้อมูลพนักงานในระบบ'])->withInput();
        }

        $inputCid = $this->normalizeCitizenId($data['citizen_id']);
        if (! $inputCid || strlen($inputCid) !== 13) {
            return back()->withErrors(['citizen_id' => 'เลขบัตรประชาชนต้องเป็น 13 หลัก'])->withInput();
        }

        $dbCid = $this->getEmployeeCitizenId($emp);

   
        if (! $dbCid) {
            return back()
                ->withErrors(['citizen_id' => 'ระบบยังไม่มีเลขบัตรประชาชนของคุณ (กรุณาแจ้งผู้ดูแลระบบ)'])
                ->withInput();
        }

        if ($dbCid !== $inputCid) {
            return back()
                ->withErrors(['citizen_id' => 'เลขบัตรประชาชนไม่ถูกต้อง'])
                ->withInput($request->except(['current_password', 'password', 'password_confirmation']));
        }

        // 3) กันรหัสผ่านซ้ำเดิม
        if (Hash::check($data['password'], (string) $user->password)) {
            return back()
                ->withErrors(['password' => 'ไม่สามารถใช้รหัสผ่านเดิมได้ กรุณาตั้งรหัสผ่านใหม่ที่แตกต่างจากเดิม'])
                ->withInput($request->except(['current_password', 'password', 'password_confirmation']));
        }

        // 4) บันทึกรหัสผ่านใหม่
        $user->password = Hash::make($data['password']);
        $user->save();

        return back()->with('success', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
    }
}

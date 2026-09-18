<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AppUser;
use App\Models\Employee;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
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

    private function stripWeirdSpaces(string $s): string
    {
        $s = preg_replace('/[\h\p{Zs}\x{00A0}\x{200B}\x{FEFF}]+/u', '', $s);
        return trim((string)$s);
    }

    private function isLegacyBcrypt(?string $hashed): bool
    {
        if (!is_string($hashed) || $hashed === '') return false;
        return (bool) preg_match('/^\$2[aby]\$/', $hashed);
    }

    private function normalizeLoginId(?string $raw): ?string
    {
        if ($raw === null) return null;

        $raw = $this->toArabicDigits((string)$raw);
        $raw = $this->stripWeirdSpaces($raw);
        if ($raw === '') return null;

        if (preg_match('/^[0-9]+$/', $raw)) {
            $raw = substr($raw, 0, 10);
            return $raw === '' ? null : $raw;
        }

        $raw = substr($raw, 0, 50);
        return $raw === '' ? null : $raw;
    }

    private function normalizeEmployeeCode(?string $code): ?string
    {
        if ($code === null) return null;

        $code = $this->toArabicDigits((string)$code);
        $code = $this->stripWeirdSpaces($code);

        $code = preg_replace('/\D+/', '', $code ?? '');
        $code = substr($code, 0, 10);

        return $code === '' ? null : $code;
    }

    private function normalizeCitizenId(?string $s): ?string
    {
        if ($s === null) return null;
        $s = $this->toArabicDigits((string)$s);
        $s = preg_replace('/\D+/', '', $s);
        $s = substr($s, 0, 13);
        return $s === '' ? null : $s;
    }

    private function normalizePasswordInput(?string $s): ?string
    {
        if ($s === null) return null;
        $s = $this->toArabicDigits((string)$s);
        $s = $this->stripWeirdSpaces($s);
        return $s === '' ? null : $s;
    }

    private function passwordMatchesPlain(?string $input, ?string $storedPassword): bool
    {
        if (empty($storedPassword)) return false;
        if ($this->isLegacyBcrypt($storedPassword)) return false;

        $raw = $this->normalizePasswordInput($input);
        $cid = $this->normalizeCitizenId($input);

        $candidates = array_values(array_unique(array_filter(
            [$raw, $cid],
            fn ($v) => $v !== null && $v !== ''
        )));

        foreach ($candidates as $cand) {
            if (hash_equals((string)$storedPassword, (string)$cand)) return true;
        }

        return false;
    }

    private function buildPreviewPayload(string $code, ?Employee $emp, ?AppUser $user): array
    {
        $isEn = app()->getLocale() === 'en';

        $name = null;
        if ($emp) {
            $name = $isEn
                ? ($emp->full_name_en ?: $emp->full_name_th)
                : ($emp->full_name_th ?: $emp->full_name_en);
        }

        $profileUrl = null;
        if ($user && !empty($user->profile_picture)) {
            $profileUrl = Storage::disk('public')->url($user->profile_picture);
        }

        return [
            'found' => true,
            'code' => $code,
            'name' => $name ?: ($code ?: 'Unknown'),
            'position' => $emp->position ?? null,
            'department' => $emp->department ?? null,
            'has_profile_picture' => (bool) ($user && !empty($user->profile_picture)),
            'profile_picture_url' => $profileUrl,
        ];
    }

    private function getCitizenIdFromEmployee(string $employeeCode): ?string
    {
        $emp = Employee::select(['citizen_id'])
            ->where('employee_code', $employeeCode)
            ->first();

        if (!$emp) return null;

        $cid = $this->normalizeCitizenId($emp->citizen_id ?? null);
        return $cid ?: null;
    }

    private function findOrCreateUserForEmployeeCode(string $code): ?AppUser
    {
        $user = AppUser::where('username', $code)->first();
        if ($user) return $user;

        $trashed = null;
        try {
            $trashed = AppUser::withTrashed()->where('username', $code)->first();
        } catch (\Throwable $e) {
            $trashed = null;
        }

        if ($trashed && method_exists($trashed, 'trashed') && $trashed->trashed()) {
            $trashed->restore();
            return $trashed;
        }

        return AppUser::create([
            'username'      => $code,
            'role'          => 'user',
            'password'      => null,
            'id_thai_hash'  => null,
            'is_registered' => false,
            'registered_at' => null,
        ]);
    }

    private function setCitizenAsInitialPassword(AppUser $user, string $citizen): void
    {
        $user->password = $citizen;

        if (Schema::hasColumn('app_users', 'id_thai_hash')) {
            $user->id_thai_hash = $citizen;
        }
        if (Schema::hasColumn('app_users', 'is_registered')) {
            $user->is_registered = true;
        }
        if (Schema::hasColumn('app_users', 'registered_at')) {
            $user->registered_at = now();
        }

        $user->save();
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('profile');
        }
        return view('welcome');
    }

    public function employeePreview(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
        ]);

        $loginId = $this->normalizeLoginId($request->input('username'));

        if (!$loginId) {
            return response()->json([
                'found' => false,
                'message' => 'กรุณากรอกชื่อผู้ใช้',
            ], 422);
        }

        $user = AppUser::where('username', $loginId)->first();

        if (!$user) {
            $codeMaybe = $this->normalizeEmployeeCode($loginId);
            if ($codeMaybe) {
                $emp = Employee::where('employee_code', $codeMaybe)->first();
                if ($emp) {
                    $payload = $this->buildPreviewPayload($codeMaybe, $emp, null);
                    return response()->json(array_merge($payload, [
                        'has_account' => false,
                        'message' => 'ยังไม่มีบัญชี ระบบจะสร้างให้เมื่อกดเข้าสู่ระบบ',
                    ]), 200);
                }
            }

            return response()->json([
                'found' => false,
                'message' => 'ไม่พบชื่อผู้ใช้นี้',
            ], 404);
        }

        $emp = null;
        $codeMaybe = $this->normalizeEmployeeCode($loginId);
        if ($codeMaybe) {
            $emp = Employee::where('employee_code', $codeMaybe)->first();
        } else {
            $codeFromUser = $this->normalizeEmployeeCode($user->username);
            if ($codeFromUser) {
                $emp = Employee::where('employee_code', $codeFromUser)->first();
            }
        }

        $displayCode = $codeMaybe ?: ($user->username ?: $loginId);

        return response()->json(
            array_merge($this->buildPreviewPayload($displayCode, $emp, $user), [
                'has_account' => true,
            ]),
            200
        );
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        $loginId = $this->normalizeLoginId($request->input('username'));
        $pwdRaw  = $this->normalizePasswordInput($request->input('password'));

        if (!$loginId) return $this->jsonOrRedirectError($request, 'กรุณากรอกชื่อผู้ใช้');
        if (!$pwdRaw)  return $this->jsonOrRedirectError($request, 'กรุณากรอกรหัสผ่าน');

        $invalidEmployeeCodeMessage = 'รหัสพนักงานไม่ถูกต้อง';
        $invalidPasswordMessage = 'รหัสผ่านไม่ถูกต้อง';

        $user = AppUser::where('username', $loginId)->first();

        if (!$user) {
            $codeMaybe = $this->normalizeEmployeeCode($loginId);
            if ($codeMaybe) {
                $emp = Employee::where('employee_code', $codeMaybe)->first();
                if ($emp) {
                    $user = $this->findOrCreateUserForEmployeeCode($codeMaybe);
                }
            }
        }

        if (!$user) {
            return $this->jsonOrRedirectError($request, $invalidEmployeeCodeMessage, 404);
        }

        $isAdmin = strtolower((string)($user->role ?? '')) === 'admin';

        if ($isAdmin) {
            $ok = false;

            if (!empty($user->password)) {
                if ($this->isLegacyBcrypt($user->password)) {
                    $ok = Hash::check((string)$pwdRaw, (string)$user->password);
                } else {
                    $ok = $this->passwordMatchesPlain($request->input('password'), $user->password);
                }
            }

            if (!$ok) {
                return $this->jsonOrRedirectError($request, $invalidPasswordMessage, 401);
            }

            if (Schema::hasColumn('app_users', 'is_registered')) {
                if ((int)($user->is_registered ?? 0) !== 1) {
                    $user->is_registered = true;

                    if (Schema::hasColumn('app_users', 'registered_at') && empty($user->registered_at)) {
                        $user->registered_at = now();
                    }

                    $user->save();
                }
            }

            Auth::login($user);
            $request->session()->regenerate();

            $payload = $this->buildPreviewPayload((string)($user->username ?: $loginId), null, $user);

            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'ok' => true,
                    'needs_picture' => empty($user->profile_picture),
                    'employee' => $payload,
                    'redirect' => route('profile'),
                ], 200);
            }

            return redirect()->route('profile');
        }

        $empCode  = $this->normalizeEmployeeCode($user->username);
        $inputCid = $this->normalizeCitizenId($request->input('password'));

        if (!empty($user->password)) {
            if ($this->isLegacyBcrypt($user->password)) {
                if (!$empCode) {
                    return $this->jsonOrRedirectError($request, 'บัญชีนี้ยังไม่พร้อมใช้งาน', 401);
                }

                if (!$inputCid || strlen($inputCid) !== 13) {
                    return $this->jsonOrRedirectError($request, 'กรุณากรอกเลขบัตรประชาชน 13 หลัก', 422);
                }

                $dbCid = $this->getCitizenIdFromEmployee($empCode);

                if (!$dbCid) {
                    return $this->jsonOrRedirectError($request, 'ยังไม่มีเลขบัตรในระบบ (ให้หัวหน้าเพิ่มข้อมูลก่อน)', 403);
                }

                if (!hash_equals($dbCid, $inputCid)) {
                    return $this->jsonOrRedirectError($request, $invalidPasswordMessage, 401);
                }

                $this->setCitizenAsInitialPassword($user, $inputCid);
            } else {
                if (!$this->passwordMatchesPlain($request->input('password'), $user->password)) {
                    return $this->jsonOrRedirectError($request, $invalidPasswordMessage, 401);
                }

                if (Schema::hasColumn('app_users', 'id_thai_hash') && empty($user->id_thai_hash) && $empCode) {
                    $dbCid = $this->getCitizenIdFromEmployee($empCode);
                    if ($dbCid) {
                        $user->id_thai_hash = $dbCid;
                        $user->save();
                    }
                }
            }
        } else {
            if (!$empCode) {
                return $this->jsonOrRedirectError($request, 'บัญชีนี้ยังไม่พร้อมใช้งาน', 401);
            }

            if (!$inputCid || strlen($inputCid) !== 13) {
                return $this->jsonOrRedirectError($request, 'กรุณากรอกเลขบัตรประชาชน 13 หลัก', 422);
            }

            $dbCid = $this->getCitizenIdFromEmployee($empCode);

            if (!$dbCid) {
                return $this->jsonOrRedirectError($request, 'ยังไม่มีเลขบัตรในระบบ (ให้หัวหน้าเพิ่มข้อมูลก่อน)', 403);
            }

            if (!hash_equals($dbCid, $inputCid)) {
                return $this->jsonOrRedirectError($request, $invalidPasswordMessage, 401);
            }

            $this->setCitizenAsInitialPassword($user, $inputCid);
        }

        if (Schema::hasColumn('app_users', 'is_registered')) {
            if ((int)($user->is_registered ?? 0) !== 1) {
                $user->is_registered = true;

                if (Schema::hasColumn('app_users', 'registered_at') && empty($user->registered_at)) {
                    $user->registered_at = now();
                }

                $user->save();
            }
        }

        Auth::login($user);
        $request->session()->regenerate();

        $emp = null;
        $codeMaybe = $this->normalizeEmployeeCode($user->username) ?: $this->normalizeEmployeeCode($loginId);
        if ($codeMaybe) {
            $emp = Employee::where('employee_code', $codeMaybe)->first();
        }
        $payload = $this->buildPreviewPayload($codeMaybe ?: ($user->username ?: $loginId), $emp, $user);

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'ok' => true,
                'needs_picture' => empty($user->profile_picture),
                'employee' => $payload,
                'redirect' => route('profile'),
            ], 200);
        }

        return redirect()->route('profile');
    }

    public function firstPicture(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'ok' => false,
                'message' => 'กรุณาเข้าสู่ระบบใหม่',
            ], 401);
        }

        $request->validate([
            'profile_picture' => ['required', 'image', 'max:10240'],
        ], [
            'profile_picture.required' => 'กรุณาเลือกรูปโปรไฟล์',
            'profile_picture.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'profile_picture.max' => 'ไฟล์ต้องมีขนาดไม่เกิน 10MB',
        ]);

        try {
            if (!empty($user->profile_picture) && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
            $user->save();

            return response()->json([
                'ok' => true,
                'redirect' => route('profile'),
            ], 200);

        } catch (\Throwable $e) {
            Log::error('firstPicture upload error: '.$e->getMessage(), [
                'user_id' => $user->id ?? null,
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'อัปโหลดไม่สำเร็จ กรุณาลองใหม่',
            ], 500);
        }
    }

    private function jsonOrRedirectError(Request $request, string $message, int $status = 422)
    {
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'ok' => false,
                'message' => $message,
            ], $status);
        }

        return back()
            ->withErrors(['username' => $message])
            ->withInput();
    }

    public function forgotVerify(Request $request)
    {
        $request->validate([
            'employee_code' => ['required', 'string'],
            'citizen_id'    => ['required', 'string'],
        ], [
            'employee_code.required' => 'กรุณากรอกรหัสพนักงาน',
            'citizen_id.required'    => 'กรุณากรอกเลขบัตรประชาชน',
        ]);

        $code = $this->normalizeEmployeeCode($request->input('employee_code'));
        $cid  = $this->normalizeCitizenId($request->input('citizen_id'));

        if (!$code) {
            return response()->json(['ok' => false, 'message' => 'กรุณากรอกรหัสพนักงานให้ถูกต้อง'], 422);
        }
        if (!$cid || strlen($cid) !== 13) {
            return response()->json(['ok' => false, 'message' => 'กรุณากรอกเลขบัตรประชาชน 13 หลักให้ถูกต้อง'], 422);
        }

        $emp = Employee::where('employee_code', $code)->first();
        if (!$emp) {
            return response()->json(['ok' => false, 'message' => 'ไม่พบรหัสพนักงานนี้ในระบบ'], 404);
        }

        $dbCid = $this->getCitizenIdFromEmployee($code);
        if (!$dbCid) {
            return response()->json(['ok' => false, 'message' => 'ยังไม่มีเลขบัตรในระบบ (ให้หัวหน้าเพิ่มข้อมูลก่อน)'], 403);
        }
        if (!hash_equals($dbCid, $cid)) {
            return response()->json(['ok' => false, 'message' => 'เลขบัตรประชาชนไม่ถูกต้อง'], 401);
        }

        $user = $this->findOrCreateUserForEmployeeCode($code);

        if ($user && Schema::hasColumn('app_users', 'id_thai_hash')) {
            $user->id_thai_hash = $cid;
            $user->save();
        }

        $resetKey = bin2hex(random_bytes(16));
        session([
            'pwd_reset_code' => $code,
            'pwd_reset_key'  => $resetKey,
            'pwd_reset_at'   => time(),
        ]);

        $payload = $this->buildPreviewPayload($code, $emp, $user);

        return response()->json([
            'ok' => true,
            'reset_key' => $resetKey,
            'employee'  => $payload,
            'message'   => 'ตรวจสอบสำเร็จ กรุณาตั้งรหัสผ่านใหม่',
        ], 200);
    }

    public function forgotReset(Request $request)
    {
        $request->validate([
            'employee_code' => ['required', 'string'],
            'reset_key'     => ['required', 'string'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'employee_code.required' => 'กรุณากรอกรหัสพนักงาน',
            'reset_key.required'     => 'Session ตรวจสอบไม่ถูกต้อง กรุณาตรวจสอบใหม่',
            'password.required'      => 'กรุณากรอกรหัสผ่านใหม่',
            'password.min'           => 'รหัสผ่านใหม่ต้องมีอย่างน้อย 8 ตัวอักษร',
            'password.confirmed'     => 'การยืนยันรหัสผ่านใหม่ไม่ตรงกัน',
        ]);

        $code = $this->normalizeEmployeeCode($request->input('employee_code'));
        $key  = (string)$request->input('reset_key');

        if (!$code) {
            return response()->json(['ok' => false, 'message' => 'รหัสพนักงานไม่ถูกต้อง'], 422);
        }

        $sessCode = (string) session('pwd_reset_code', '');
        $sessKey  = (string) session('pwd_reset_key', '');
        $sessAt   = (int) session('pwd_reset_at', 0);

        $expired = (!$sessAt) || (time() - $sessAt > 10 * 60);

        if ($expired || !$sessCode || !$sessKey || !hash_equals($sessCode, $code) || !hash_equals($sessKey, $key)) {
            return response()->json([
                'ok' => false,
                'message' => 'การตรวจสอบหมดอายุ/ไม่ถูกต้อง กรุณากดตรวจสอบใหม่อีกครั้ง',
            ], 419);
        }

        $emp = Employee::where('employee_code', $code)->first();
        if (!$emp) {
            return response()->json(['ok' => false, 'message' => 'ไม่พบรหัสพนักงานนี้ในระบบ'], 404);
        }

        $dbCid = $this->getCitizenIdFromEmployee($code);
        if (!$dbCid) {
            return response()->json(['ok' => false, 'message' => 'ยังไม่มีเลขบัตรในระบบ (ให้หัวหน้าเพิ่มข้อมูลก่อน)'], 403);
        }

        $user = $this->findOrCreateUserForEmployeeCode($code);
        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'ไม่สามารถสร้างบัญชีได้ กรุณาติดต่อผู้ดูแล'], 500);
        }

        if (Schema::hasColumn('app_users', 'id_thai_hash')) {
            $user->id_thai_hash = $dbCid;
        }

        $newPassword = (string)$request->input('password');

        if (!empty($user->password) && !$this->isLegacyBcrypt($user->password) && hash_equals((string)$user->password, (string)$newPassword)) {
            return response()->json([
                'ok' => false,
                'message' => 'ไม่สามารถใช้รหัสผ่านเดิมได้ กรุณาตั้งรหัสผ่านใหม่ที่แตกต่างจากเดิม',
            ], 422);
        }

        if (!empty($user->password) && $this->isLegacyBcrypt($user->password) && hash_equals((string)$dbCid, (string)$newPassword)) {
            return response()->json([
                'ok' => false,
                'message' => 'ไม่สามารถใช้รหัสผ่านเดิมได้ กรุณาตั้งรหัสผ่านใหม่ที่แตกต่างจากเดิม',
            ], 422);
        }

        $user->password = $newPassword;

        if (Schema::hasColumn('app_users', 'is_registered')) {
            $user->is_registered = true;
        }
        if (Schema::hasColumn('app_users', 'registered_at')) {
            $user->registered_at = now();
        }

        $user->save();

        session()->forget(['pwd_reset_code', 'pwd_reset_key', 'pwd_reset_at']);

        return response()->json([
            'ok' => true,
            'message' => 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',
        ], 200);
    }

    public function profile()
    {
        $user = Auth::user();
        if (! $user) return redirect()->route('login');

        $emp = null;
        $code = $this->normalizeEmployeeCode($user->username);
        if ($code) {
            $emp = Employee::where('employee_code', $code)->first();
        }

        return view('profile', [
            'user' => $user,
            'employee' => $emp,
        ]);
    }

    public function showEditProfile()
    {
        $user = Auth::user();
        if (! $user) return redirect()->route('login');

        return view('profile_edit', ['user' => $user]);
    }

    public function updateProfilePicture(Request $request)
    {
        $user = Auth::user();
        if (! $user) return redirect()->route('login');

        $request->validate([
            'profile_picture' => ['required', 'image', 'max:10240'],
        ], [
            'profile_picture.required' => 'กรุณาเลือกรูปโปรไฟล์',
            'profile_picture.image'    => 'ไฟล์รูปโปรไฟล์ต้องเป็นรูปภาพ',
            'profile_picture.max'      => 'ไฟล์รูปโปรไฟล์ต้องมีขนาดไม่เกิน 10MB',
        ]);

        if (! $request->hasFile('profile_picture')) {
            return back()->withErrors(['profile_picture' => 'ไม่พบไฟล์รูปที่อัปโหลด']);
        }

        try {
            if (!empty($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $newPath = $request->file('profile_picture')->store('profile_pictures', 'public');

            $user->profile_picture = $newPath;
            $user->save();

            return back()->with('success', 'อัปเดตรูปโปรไฟล์เรียบร้อยแล้ว');
        } catch (\Throwable $e) {
            Log::error('Update profile picture error: '.$e->getMessage(), [
                'user_id' => $user->id ?? null,
            ]);

            return back()->withErrors(['profile_picture' => 'อัปโหลดรูปไม่สำเร็จ กรุณาลองใหม่อีกครั้ง']);
        }
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (! $user) return redirect()->route('login');

        $request->validate([
            'citizen_id_password' => ['required', 'string'],
            'password'            => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'citizen_id_password.required' => 'กรุณากรอกเลขบัตรประชาชนเพื่อยืนยัน',
            'password.required'            => 'กรุณากรอกรหัสผ่านใหม่',
            'password.min'                 => 'รหัสผ่านใหม่ต้องมีอย่างน้อย 8 ตัวอักษร',
            'password.confirmed'           => 'การยืนยันรหัสผ่านใหม่ไม่ตรงกัน',
        ]);

        $cid = $this->normalizeCitizenId($request->input('citizen_id_password'));
        if (!$cid || strlen($cid) !== 13) {
            return back()
                ->withErrors(['citizen_id_password' => 'กรุณากรอกเลขบัตรประชาชน 13 หลักให้ถูกต้อง'])
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        $ok = false;

        if (!empty($user->id_thai_hash) && !$this->isLegacyBcrypt($user->id_thai_hash)) {
            $ok = hash_equals((string)$user->id_thai_hash, (string)$cid);
        } else {
            $empCode = $this->normalizeEmployeeCode($user->username);
            if ($empCode) {
                $dbCid = $this->getCitizenIdFromEmployee($empCode);
                if ($dbCid && hash_equals($dbCid, $cid)) {
                    $ok = true;

                    if (Schema::hasColumn('app_users', 'id_thai_hash')) {
                        $user->id_thai_hash = $cid;
                        $user->save();
                    }
                }
            }
        }

        if (!$ok) {
            return back()
                ->withErrors(['citizen_id_password' => 'เลขบัตรประชาชนไม่ถูกต้อง'])
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        $newPassword = (string)$request->input('password');

        if (!empty($user->password) && !$this->isLegacyBcrypt($user->password) && hash_equals((string)$user->password, (string)$newPassword)) {
            return back()
                ->withErrors(['password' => 'ไม่สามารถใช้รหัสผ่านเดิมได้ กรุณาตั้งรหัสผ่านใหม่ที่แตกต่างจากเดิม'])
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        $user->password = $newPassword;
        $user->save();

        return back()->with('success', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

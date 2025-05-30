<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $totalAttendances = Attendance::count();
        // Pastikan hanya admin yang bisa akses
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $attendances = Attendance::with('employee.user')
            ->orderBy('date', 'desc')
            ->orderBy('clock_in', 'desc')
            ->paginate(5);

        return view('admin.attendances.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::with('user')->get();
        return view('admin.attendances.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,cuti,alpha',
            'clock_in' => 'nullable|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'notes' => 'nullable|string',
        ]);

        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'status' => $request->status,
            'clock_in' => $request->clock_in,
            'clock_out' => $request->clock_out,
            'notes' => $request->notes,
        ]);

        return redirect()->route('attendances.index')
            ->with('success', 'Data absensi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attendance = Attendance::with('employee.user')->findOrFail($id);
        return view('admin.attendances.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = Employee::with('user')->get();
        return view('admin.attendances.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,cuti,alpha',
            'clock_in' => 'nullable|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'notes' => 'nullable|string',
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'status' => $request->status,
            'clock_in' => $request->clock_in,
            'clock_out' => $request->clock_out,
            'notes' => $request->notes,
        ]);

        return redirect()->route('attendances.index')
            ->with('success', 'Data absensi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('attendances.index')
            ->with('success', 'Data absensi berhasil dihapus');
    }

    /**
     * Clock in for employee.
     */
    public function clockIn()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan');
        }

        // Gunakan timezone Asia/Jakarta secara eksplisit
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString(); // tanggal hari ini dalam YYYY-MM-DD

        // Jam masuk standar (08:00)
        $standardStart = Carbon::createFromTime(8, 0, 0, 'Asia/Jakarta');

        // Cek apakah sudah absen hari ini
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        $status = $now->gt($standardStart) ? 'terlambat' : 'hadir';

        if ($attendance) {
            if ($attendance->clock_in) {
                return redirect()->back()->with('error', 'Anda sudah melakukan presensi masuk hari ini');
            }

            $attendance->update([
                'clock_in' => $now->toTimeString(),
                'status' => $status
            ]);
        } else {
            Attendance::create([
                'employee_id' => $employee->id,
                'date' => $today,
                'clock_in' => $now->toTimeString(),
                'status' => $status
            ]);
        }

        return redirect()->back()->with('success', 'Presensi masuk berhasil. Waktu: ' . $now->format('H:i:s'));
    }



    /**
     * Clock out for employee.
     */
    public function clockOut()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan');
        }

        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('H:i:s');

        // Check if attendance record for today exists
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Anda belum melakukan presensi masuk hari ini');
        }

        if (!$attendance->clock_in) {
            return redirect()->back()->with('error', 'Anda belum melakukan presensi masuk hari ini');
        }

        if ($attendance->clock_out) {
            return redirect()->back()->with('error', 'Anda sudah melakukan presensi pulang hari ini');
        }

        $attendance->update([
            'clock_out' => $now
        ]);

        return redirect()->back()->with('success', 'Presensi pulang berhasil. Waktu: ' . $now);
    }

    /**
     * Employee attendance history.
     */
    public function history()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan');
        }

        $attendances = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->paginate(10);

        // Hitung total hari kerja (misal diasumsikan bulan ini 23 hari kerja)
        $totalWorkDays = 23;

        // Hitung hari hadir (status 'hadir')
        $presentDays = Attendance::where('employee_id', $employee->id)
            ->where('status', 'hadir')
            ->count();

        // Hitung keterlambatan (status 'terlambat' atau sesuai status laten)
        $lateCount = Attendance::where('employee_id', $employee->id)
            ->where('status', 'terlambat')
            ->count();

        $overtimeHours = 0;
        // Hitung jam lembur, asumsi ada kolom 'overtime_hours' di table attendances
        $overtimeHours = Attendance::where('employee_id', $employee->id)
            ->sum('overtime_hours');

        // Data jam lembur bulan lalu, misalnya hardcode dulu
        $lastMonthOvertime = 3.5;

        return view('employee.attendances.history', compact(
            'attendances',
            'totalWorkDays',
            'presentDays',
            'lateCount',
            'overtimeHours',
            'lastMonthOvertime'
        ));
    }
}

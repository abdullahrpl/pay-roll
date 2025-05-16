<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Salary;
use Carbon\Carbon;


class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */

    public function adminDashboard()
    {
        // Cek role admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $totalEmployees = Employee::count();
        $today = Carbon::today()->toDateString();

        $todayAttendance = Attendance::whereDate('date', $today)
            ->whereIn('status', ['hadir', 'terlambat']) // hanya hitung yang valid hadir
            ->count();

        $totalSalaries = Salary::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_salary');

        $recentAttendances = Attendance::with('employee.user')
            ->orderBy('date', 'desc')
            ->orderBy('clock_in', 'desc')
            ->take(5)
            ->get();

        // Generate data chart ringkasan kehadiran per hari di bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $daysInMonth = Carbon::now()->daysInMonth;

        $labels = [];
        $values = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $startOfMonth->copy()->addDays($day - 1)->toDateString();
            $labels[] = $startOfMonth->copy()->addDays($day - 1)->format('d M');

            $count = Attendance::whereDate('date', $date)
                ->whereIn('status', ['hadir', 'terlambat'])
                ->count();

            $values[] = $count;
        }

        $attendanceData = [
            'labels' => $labels,
            'values' => $values,
        ];

        return view('admin.dashboard', compact(
            'totalEmployees',
            'todayAttendance',
            'totalSalaries',
            'recentAttendances',
            'attendanceData'
        ));
    }


    /**
     * Show employee dashboard
     */
    public function employeeDashboard()
    {
        // Check if user is employee
        if (Auth::user()->role !== 'employee') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->route('login')->with('error', 'Data karyawan tidak ditemukan');
        }

        $today = Carbon::today()->format('Y-m-d');

        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        $recentAttendances = Attendance::where('employee_id', $employee->id)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        $thisMonthSalary = Salary::where('employee_id', $employee->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->first();

        return view('employee.dashboard', compact(
            'employee',
            'todayAttendance',
            'recentAttendances',
            'thisMonthSalary'
        ));
    }
}

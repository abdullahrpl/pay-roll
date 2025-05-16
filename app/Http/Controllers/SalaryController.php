<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Pastikan hanya admin yang bisa akses
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        // Ambil data gaji beserta relasi
        $salaries = Salary::with('employee.user')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->paginate(10);

        // Total semua gaji bersih
        $totalSalary = Salary::sum('total_salary');
        $averageSalary = Salary::avg('total_salary');

        // Jumlah data yang sudah diproses
        $processedCount = Salary::where('is_paid', true)->count();

        // Total semua data
        $totalCount = Salary::count();

        // Pertumbuhan gaji bulan ini dibanding bulan sebelumnya (berdasarkan data paling baru)
        $latest = Salary::orderBy('year', 'desc')->orderBy('month', 'desc')->first();
        $growth = 'N/A';

        if ($latest) {
            $currentMonth = sprintf('%02d', $latest->month);
            $currentYear = $latest->year;

            $prevMonth = $latest->month - 1;
            $prevYear = $latest->year;

            if ($prevMonth <= 0) {
                $prevMonth = 12;
                $prevYear -= 1;
            }

            $currentTotal = Salary::where('month', $latest->month)
                ->where('year', $latest->year)
                ->sum('total_salary');

            $previousTotal = Salary::where('month', $prevMonth)
                ->where('year', $prevYear)
                ->sum('total_salary');

            if ($previousTotal > 0) {
                $growth = number_format((($currentTotal - $previousTotal) / $previousTotal) * 100, 2) . '%';
            }
        }
        $selectedMonth = now()->format('F');
        return view('admin.salaries.index', compact(
            'salaries',
            'totalSalary',
            'averageSalary',
            'processedCount',
            'totalCount',
            'growth',
            'selectedMonth'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::with('user')->get();
        $months = $this->getMonthOptions();

        $currentYear = Carbon::now()->year;
        $years = range($currentYear - 2, $currentYear + 1);

        return view('admin.salaries.create', compact('employees', 'months', 'years'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|string',
            'year' => 'required|integer',
            'bonus' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Check if salary for this employee and period already exists
        $exists = Salary::where('employee_id', $request->employee_id)
            ->where('month', $request->month)
            ->where('year', $request->year)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Gaji untuk karyawan ini pada periode yang dipilih sudah ada')
                ->withInput();
        }

        $employee = Employee::findOrFail($request->employee_id);
        $basicSalary = $employee->basic_salary;

        // Calculate attendance and absence for the month
        $startDate = Carbon::createFromDate($request->year, $request->month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($request->year, $request->month, 1)->endOfMonth();

        $attendanceCount = Attendance::where('employee_id', $request->employee_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', 'hadir')
            ->count();

        $absenceCount = Attendance::where('employee_id', $request->employee_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', 'alpha')
            ->count();

        // Calculate working days in the month (excluding weekends)
        $workingDays = 0;
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if (!$date->isWeekend()) {
                $workingDays++;
            }
        }

        // Calculate deduction (per day absence = basic salary / working days)
        $perDayDeduction = $workingDays > 0 ? $basicSalary / $workingDays : 0;
        $deduction = $absenceCount * $perDayDeduction;

        // Calculate total salary
        $bonus = $request->bonus ?? 0;
        $totalSalary = $basicSalary - $deduction + $bonus;

        Salary::create([
            'employee_id' => $request->employee_id,
            'month' => $request->month,
            'year' => $request->year,
            'basic_salary' => $basicSalary,
            'attendance_count' => $attendanceCount,
            'absence_count' => $absenceCount,
            'deduction' => $deduction,
            'bonus' => $bonus,
            'total_salary' => $totalSalary,
            'notes' => $request->notes,
        ]);

        return redirect()->route('salaries.index')
            ->with('success', 'Data gaji berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $salary = Salary::with('employee.user')->findOrFail($id);
        return view('admin.salaries.show', compact('salary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $salary = Salary::with('employee.user')->findOrFail($id);
        $employees = Employee::with('user')->get();
        $months = $this->getMonthOptions();

        $currentYear = Carbon::now()->year;
        $years = range($currentYear - 2, $currentYear + 1);

        return view('admin.salaries.edit', compact('salary', 'employees', 'months', 'years'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $salary = Salary::findOrFail($id);

        $request->validate([
            'bonus' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'is_paid' => 'nullable|boolean',
        ]);

        $bonus = $request->bonus ?? 0;
        $totalSalary = $salary->basic_salary - $salary->deduction + $bonus;

        $updateData = [
            'bonus' => $bonus,
            'total_salary' => $totalSalary,
            'notes' => $request->notes,
        ];

        if ($request->has('is_paid')) {
            $updateData['is_paid'] = $request->is_paid;
            if ($request->is_paid) {
                $updateData['paid_at'] = Carbon::now();
            } else {
                $updateData['paid_at'] = null;
            }
        }

        $salary->update($updateData);

        return redirect()->route('salaries.index')
            ->with('success', 'Data gaji berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $salary = Salary::findOrFail($id);
        $salary->delete();

        return redirect()->route('salaries.index')
            ->with('success', 'Data gaji berhasil dihapus');
    }

    /**
     * Generate PDF payslip
     */
    public function generatePayslip(string $id)
    {
        $salary = Salary::with('employee.user')->findOrFail($id);

        $pdf = Pdf::loadView('admin.salaries.payslip', compact('salary'));

        return $pdf->download('slip-gaji-' . $salary->employee->nip . '-' .
            $salary->month . '-' . $salary->year . '.pdf');
    }

    /**
     * Employee salary history
     */
    public function history()
    {
        $user = Auth::user();
        $employee = $user->employee;

        $presentDays = Attendance::where('employee_id', $employee->id)
            ->where('status', 'hadir')
            ->count();

        if (!$employee) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan');
        }

        $salaries = Salary::where('employee_id', $employee->id)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->paginate(10);

        return view('employee.salaries.history', compact('salaries', 'presentDays'));
    }

    /**
     * Get month options for the form
     */
    private function getMonthOptions()
    {
        return [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }

    public function markPending($id)
    {
        $salary = Salary::findOrFail($id);

        $salary->update([
            'is_paid' => false,
            'paid_at' => null,
        ]);

        return redirect()->back()->with('success', 'Status pembayaran diubah menjadi Pending.');
    }

    public function markPaid($id)
    {
        $salary = Salary::findOrFail($id);

        $salary->update([
            'is_paid' => true,
            'paid_at' => Carbon::now(), // isi tanggal dibayar
        ]);

        return redirect()->back()->with('success', 'Status pembayaran diubah menjadi Lunas.');
    }

    public function sendNotification($id)
    {
        $salary = Salary::findOrFail($id);
        // Logic untuk kirim notifikasi email atau lainnya
        // Contoh sederhana:
        // Mail::to($salary->employee->user->email)->send(new SalaryNotificationMail($salary));

        return redirect()->back()->with('success', 'Notifikasi slip gaji telah dikirim.');
    }
}

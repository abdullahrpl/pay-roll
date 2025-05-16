<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Salary;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create Admin User
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Sample Employee User
        $employeeUser = User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@example.com',
            'password' => Hash::make('karyawan123'),
            'role' => 'employee',
        ]);

        // Create Sample Employee Data
        $employee = Employee::create([
            'user_id' => $employeeUser->id,
            'nip' => 'NIP00001',
            'position' => 'Staff IT',
            'department' => 'IT',
            'phone_number' => '081234567890',
            'address' => 'Jl. Sample No. 123, Jakarta',
            'join_date' => '2023-01-01',
            'basic_salary' => 5000000,
        ]);

        // Create Sample Attendance Records
        $today = Carbon::today();

        // Today's attendance
        Attendance::create([
            'employee_id' => $employee->id,
            'date' => $today->format('Y-m-d'),
            'clock_in' => $today->copy()->setTime(8, 0, 0)->format('H:i:s'),
            'clock_out' => $today->copy()->setTime(17, 0, 0)->format('H:i:s'),
            'status' => 'hadir',
        ]);

        // Create Sample Salary
        $now = Carbon::now();
        Salary::create([
            'employee_id' => $employee->id,
            'month' => $now->format('m'),
            'year' => $now->format('Y'),
            'basic_salary' => 5000000,
            'attendance_count' => 20,
            'absence_count' => 0,
            'deduction' => 0,
            'bonus' => 500000,
            'total_salary' => 5500000,
            'notes' => 'Gaji bulan ' . $now->format('F Y'),
            'is_paid' => true,
            'paid_at' => $now,
        ]);
    }
}

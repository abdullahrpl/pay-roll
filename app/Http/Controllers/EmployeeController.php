<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
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

        $employees = Employee::with('user')->latest()->paginate(10);
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pastikan hanya admin yang bisa akses
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return view('admin.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nip' => 'required|string|max:20|unique:employees',
            'position' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string',
            'join_date' => 'required|date',
            'basic_salary' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'employee',
            ]);

            Employee::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'position' => $request->position,
                'department' => $request->department,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'join_date' => $request->join_date,
                'basic_salary' => $request->basic_salary,
            ]);

            DB::commit();
            return redirect()->route('employees.index')
                ->with('success', 'Karyawan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with('user')->findOrFail($id);
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::with('user')->findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($employee->user_id),
            ],
            'nip' => [
                'required',
                'string',
                'max:20',
                Rule::unique('employees')->ignore($id),
            ],
            'position' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string',
            'join_date' => 'required|date',
            'basic_salary' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $employee->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $employee->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $employee->update([
                'nip' => $request->nip,
                'position' => $request->position,
                'department' => $request->department,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'join_date' => $request->join_date,
                'basic_salary' => $request->basic_salary,
            ]);

            DB::commit();
            return redirect()->route('employees.index')
                ->with('success', 'Data karyawan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);

        DB::beginTransaction();
        try {
            $user = $employee->user;
            $employee->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('employees.index')
                ->with('success', 'Karyawan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

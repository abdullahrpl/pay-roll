@extends('layouts.app')

@section('title', 'Detail Penggajian')

@section('content')
    <main class="flex-1 overflow-y-auto p-6">
        <div class="flex justify-between items-center mb-6 no-print">
            <div class="flex items-center gap-2">
                <a href="{{ route('salaries.index') }}" class="p-2 bg-white border rounded-md text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold">Salary Details</h1>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('salaries.edit', $salary->id) }}"
                    class="px-4 py-2 bg-white border rounded-md text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>

                <a href="{{ route('salaries.payslip', $salary->id) }}" class="btn btn-primary" target="_blank">
                    <i class="fas fa-file-pdf"></i> Slip Gaji
                </a>
            </div>
        </div>

        <!-- Payslip Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden max-w-3xl mx-auto payslip-container">
            <div class="p-6 text-center border-b">
                <h2 class="text-2xl font-bold">Salary detail for {{ $salary->employee->user->name }}</h2>
                <p class="text-gray-500">Employee Payslip for
                    {{ \Carbon\Carbon::parse($salary->payment_date)->format('F Y') }}</p>
            </div>

            <div class="p-6 space-y-6">
                <!-- Employee Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <p class="text-sm text-gray-500">Employee Name</p>
                        <p class="font-medium">{{ $salary->employee->user->name }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-500">Employee ID</p>
                        <p class="font-medium">{{ $salary->employee->employee_id }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-500">Department</p>
                        <p class="font-medium">{{ $salary->employee->department }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-500">Position</p>
                        <p class="font-medium">{{ $salary->employee->position }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-500">Payment Date</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($salary->payment_date)->format('F d, Y') }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-500">Payment Method</p>
                        <p class="font-medium">{{ $salary->payment_method }}</p>
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- Earnings -->
                <div class="space-y-4">
                    <h3 class="font-semibold">Earnings</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Basic Salary</span>
                            <span>${{ number_format($salary->basic_salary, 2) }}</span>
                        </div>
                        {{-- <div class="flex justify-between">
                            <span>Housing Allowance</span>
                            <span>${{ number_format($salary->housing_allowance, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Transport Allowance</span>
                            <span>${{ number_format($salary->transport_allowance, 2) }}</span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between font-medium">
                            <span>Total Earnings</span>
                            <span>${{ number_format($salary->total_earnings, 2) }}</span>
                        </div> --}}
                    </div>
                </div>

                <!-- Deductions -->
                <div class="space-y-4">
                    <h3 class="font-semibold">Bonus</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Bonus</span>
                            <span>${{ number_format($salary->bonus, 2) }}</span>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- Net Salary -->
                <div class="flex justify-between text-lg font-bold">
                    <span>Total Salary</span>
                    <span>${{ number_format($salary->total_salary, 2) }}</span>
                </div>

                <!-- Attendance Summary -->
                {{-- <div class="space-y-4">
                    <h3 class="font-semibold">Attendance Summary</h3>
                    <div class="grid grid-cols-4 gap-4 text-center">
                        <div class="p-3 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-500">Working Days</p>
                            <p class="font-medium">{{ $salary->employee->working_days }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-500">Present</p>
                            <p class="font-medium">{{ $salary->present_days }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-500">Absent</p>
                            <p class="font-medium">{{ $salary->absent_days }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-500">Late</p>
                            <p class="font-medium">{{ $salary->late_days }}</p>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="p-4 bg-gray-50 border-t text-center text-sm text-gray-500">
                <p>This is a computer-generated document. No signature required.</p>
                <p class="mt-1">For any queries regarding this payslip, please contact HR department.</p>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="mt-6 max-w-3xl mx-auto no-print">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-medium">Actions</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium">Payment Status</h3>
                            <p class="text-sm text-gray-500">Current status:
                                <span
                                    class="font-medium {{ $salary->is_paid == 'paid' ? 'text-green-500' : 'text-yellow-600' }}">
                                    @if (ucfirst($salary->is_paid))
                                        Paid
                                    @else
                                        Pending
                                    @endif
                                </span>
                            </p>
                        </div>
                        <div>
                            @if ($salary->is_paid == 'paid')
                                <form action="{{ route('salaries.markPending', $salary->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                        Mark as Pending
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('salaries.markPaid', $salary->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                        Mark as Paid
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <hr class="border-gray-200">

                </div>
            </div>
        </div>
    </main>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
@endsection

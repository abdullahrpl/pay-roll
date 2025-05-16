@extends('layouts.app')

@section('title', 'Histori Penggajian')

@section('content')
    <main class="flex-1 overflow-y-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Histori Penggajian</h1>
        </div>

        <!-- Salary Records Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b">
                <h2 class="text-lg font-medium">Daftar Penggajian</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Gaji Pokok</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Kehadiran</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Potongan</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Bonus</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Total Gaji</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($salaries as $key => $salary)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $salaries->firstItem() + $key }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $salary->period }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp
                                    {{ number_format($salary->basic_salary, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $presentDays }} hari</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp
                                    {{ number_format($salary->deduction, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($salary->bonus, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $salary->formatted_total_salary }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($salary->is_paid)
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Dibayar</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Belum
                                            Dibayar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('salaries.payslip', $salary->id) }}"
                                        class="text-primary-600 hover:text-primary-900 flex items-center space-x-1"
                                        target="_blank" title="Slip Gaji">
                                        <i class="fas fa-file-pdf"></i><span>Slip Gaji</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center px-6 py-4 text-gray-500">Belum ada data penggajian
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                <div class="flex justify-center">
                    {{ $salaries->links() }}
                </div>
            </div>
        </div>
    </main>

@endsection

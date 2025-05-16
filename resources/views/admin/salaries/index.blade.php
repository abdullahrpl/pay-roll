@extends('layouts.app')

@section('title', 'Manajemen Penggajian')

@section('content')
    <main class="flex-1 overflow-y-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">Manajemen Penggajian</h1>
                <p class="text-sm text-gray-500">Kelola data penggajian karyawan.</p>
            </div>
            <div>
                <a href="{{ route('salaries.create') }}"
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                    <i class="fas fa-plus mr-2"></i> Tambah Gaji
                </a>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="p-6">
                <form method="GET" action="{{ route('salaries.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                        <select name="month" class="w-full p-2 border rounded-md">
                            <option value="">Semua Bulan</option>
                            <option value="05-2025">Mei 2025</option>
                            <option value="04-2025">April 2025</option>
                            <option value="03-2025">Maret 2025</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Departemen</label>
                        <select name="department" class="w-full p-2 border rounded-md">
                            <option value="">Semua Departemen</option>
                            <option value="engineering">Engineering</option>
                            <option value="marketing">Marketing</option>
                            <option value="hr">HR</option>
                            <option value="finance">Finance</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full p-2 border rounded-md">
                            <option value="">Semua Status</option>
                            <option value="paid">Paid</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 w-full">
                            <i class="fas fa-search mr-2"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Ringkasan Gaji -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Gaji</h3>
                    <i class="fas fa-money-bill-wave text-gray-400"></i>
                </div>
                <p class="text-2xl font-bold">{{ number_format($totalSalary, 2, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1">Untuk bulan {{ $selectedMonth }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Sudah Diproses</h3>
                    <i class="fas fa-check-circle text-gray-400"></i>
                </div>
                <p class="text-2xl font-bold">{{ $processedCount }} / {{ $totalCount }}</p>
                <p class="text-xs text-gray-500 mt-1">Karyawan diproses</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Rata-rata Gaji</h3>
                    <i class="fas fa-chart-line text-gray-400"></i>
                </div>
                <p class="text-2xl font-bold">{{ number_format($averageSalary, 2, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $growth }} dari bulan lalu</p>
            </div>
        </div>

        <!-- Tabel Gaji -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-lg font-medium">Data Penggajian</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar penggajian karyawan</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Karyawan</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Departemen</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Gaji Pokok</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Bonus</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Potongan</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Gaji Bersih
                            </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($salaries as $salary)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 mr-3">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($salary->employee->user->name) }}&background=random" class="rounded-circle">
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $salary->employee->user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $salary->employee->department }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">{{ $salary->month }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    Rp{{ number_format($salary->basic_salary, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    Rp{{ number_format($salary->bonus, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    Rp{{ number_format($salary->deduction, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">
                                    Rp{{ number_format($salary->total_salary, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap"> 
                                    @if ($salary->is_paid == 'paid')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('salaries.show', $salary->id) }}"
                                            class="text-primary-600 hover:text-primary-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('salaries.edit', $salary->id) }}"
                                            class="text-yellow-600 hover:text-yellow-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Menampilkan {{ $salaries->firstItem() }} - {{ $salaries->lastItem() }} dari {{ $salaries->total() }}
                    data
                </div>
                <div>
                    {{ $salaries->links() }}
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

@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
    <main class="flex-1 overflow-y-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Riwayat Absensi</h1>
                <p class="text-gray-600">Daftar riwayat absensi Anda.</p>
            </div>
        </div>

        <!-- Attendance Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ \Carbon\Carbon::now()->format('F Y') }}
                </h2>
            </div>

            <!-- Stats Cards (Opsional, sesuaikan datanya) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6 border-b">
                <div class="bg-white border rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Hari Hadir</h3>
                    <p class="text-2xl font-bold">{{ $presentDays }}/{{ $totalWorkDays }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $totalWorkDays > 0 ? number_format(($presentDays / $totalWorkDays) * 100, 1) : 0 }}% tingkat
                        kehadiran
                    </p>
                </div>
                <div class="bg-white border rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Terlambat</h3>
                    <p class="text-2xl font-bold">{{ $lateCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $totalWorkDays > 0 ? number_format(($lateCount / $totalWorkDays) * 100, 1) : 0 }}% dari hari kerja
                    </p>
                </div>
                <div class="bg-white border rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Jam Lembur</h3>
                    <p class="text-2xl font-bold">{{ number_format($overtimeHours, 1) }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $overtimeHours - $lastMonthOvertime >= 0 ? '+' : '' }}
                        {{ number_format($overtimeHours - $lastMonthOvertime, 1) }} dari bulan lalu
                    </p>
                </div>
            </div>


            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam
                                Masuk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam
                                Pulang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($attendances as $key => $attendance)
                            @php
                                $badgeColors = [
                                    'hadir' => 'bg-green-100 text-green-800',
                                    'izin' => 'bg-blue-100 text-blue-800',
                                    'sakit' => 'bg-yellow-100 text-yellow-800',
                                    'cuti' => 'bg-indigo-100 text-indigo-800',
                                    'alpha' => 'bg-red-100 text-red-800',
                                ];
                                $colorClass = $badgeColors[$attendance->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $attendances->firstItem() + $key }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }} capitalize">
                                        {{ $attendance->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->notes }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">Belum ada data absensi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex justify-center p-6 bg-gray-50 border-t">
                {{ $attendances->links() }}
            </div>
        </div>
    </main>

@endsection

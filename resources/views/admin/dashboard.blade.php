@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <main class="flex-1 overflow-y-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Dashboard</h1>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Karyawan</h3>
                    <i class="fa fa-users text-gray-400"></i>
                </div>
                <p class="text-2xl font-bold">{{ $totalEmployees }}</p>
                <p class="text-xs text-gray-500 mt-1">+{{ $totalEmployees }} dari bulan lalu</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Kehadiran Hari Ini</h3>
                    <i class="fa fa-clock text-gray-400"></i>
                </div>
                <p class="text-2xl font-bold">{{ $todayAttendance }}</p>
                <p class="text-xs text-gray-500 mt-1">93% tingkat kehadiran</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Gaji Bulan Ini</h3>
                    <i class="fa fa-dollar text-gray-400"></i>
                </div>
                <p class="text-2xl font-bold">Rp {{ number_format($totalSalaries, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1">+2.5% dari bulan lalu</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Pengajuan Menunggu</h3>
                    <i class="fa fa-calendar text-gray-400"></i>
                </div>
                <p class="text-2xl font-bold">{{ $pendingApprovals ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-1">Izin & permintaan cuti</p>
            </div>
        </div>

        <!-- Attendance Overview and Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-7 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-sm lg:col-span-4">
                <h3 class="font-medium mb-1">Ringkasan Kehadiran</h3>
                <p class="text-sm text-gray-500 mb-4">Kehadiran harian bulan ini</p>
                <div class="h-64 flex items-center justify-center bg-gray-100 rounded-md">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm lg:col-span-3">
                <h3 class="font-medium mb-1">Aktivitas Terbaru</h3>
                <p class="text-sm text-gray-500 mb-4">Aktivitas karyawan terakhir</p>
                <div class="space-y-4">
                    @forelse ($recentAttendances as $attendance)
                        <div class="flex items-center">
                            <div
                                class="w-2 h-2 rounded-full {{ $attendance->status === 'hadir' ? 'bg-green-500' : ($attendance->status === 'sakit' ? 'bg-yellow-500' : ($attendance->status === 'cuti' ? 'bg-blue-500' : 'bg-red-500')) }} mr-3">
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $attendance->employee->user->name }} clock in</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($attendance->clock_in)->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada aktivitas terbaru</p>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($attendanceData['labels']),
                datasets: [{
                    label: 'Jumlah Kehadiran',
                    data: @json($attendanceData['values']),
                    fill: true,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection

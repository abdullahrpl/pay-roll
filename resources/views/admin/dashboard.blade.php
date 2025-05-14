@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold">Dashboard Admin</h2>
        <p class="text-muted">Selamat datang di panel admin sistem penggajian karyawan.</p>
    </div>

    <div class="row g-4">
        <!-- Total Karyawan -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 bg-primary text-white hover-effect same-height-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-6">Total Karyawan</div>
                        <div class="fs-3 fw-bold">{{ $totalEmployees }}</div>
                    </div>
                    <div class="fs-2"><i class="fas fa-users"></i></div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('employees.index') }}" class="text-white text-decoration-underline small">Lihat Detail <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <!-- Kehadiran Hari Ini -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 bg-info text-white hover-effect same-height-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-6">Kehadiran Hari Ini</div>
                        <div class="fs-3 fw-bold">{{ $todayAttendance }}</div>
                    </div>
                    <div class="fs-2"><i class="fas fa-clipboard-check"></i></div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('attendances.index') }}" class="text-white text-decoration-underline small">Lihat Detail <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <!-- Total Gaji Bulan Ini -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 bg-warning text-dark hover-effect same-height-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fs-6">Total Gaji Bulan Ini</div>
                        <div class="fs-5 fw-bold">Rp {{ number_format($totalSalaries, 0, ',', '.') }}</div>
                    </div>
                    <div class="fs-2"><i class="fas fa-money-bill-wave"></i></div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('salaries.index') }}" class="text-dark text-decoration-underline small">Lihat Detail <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Absensi Terbaru -->
    <div class="mt-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                <h5 class="mb-0 fw-bold">Absensi Terbaru</h5>
                <a href="{{ route('attendances.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Karyawan</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentAttendances as $attendance)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($attendance->employee->user->name) }}&background=random"
                                                class="rounded-circle me-2" width="36" height="36">
                                            <div>
                                                <strong>{{ $attendance->employee->user->name }}</strong>
                                                <div class="text-muted small">{{ $attendance->employee->position }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                    <td>{{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '-' }}</td>
                                    <td>{{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '-' }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'hadir' => 'success',
                                                'izin' => 'info',
                                                'sakit' => 'warning',
                                                'cuti' => 'primary',
                                                'alpha' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$attendance->status] ?? 'secondary' }}">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada data absensi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

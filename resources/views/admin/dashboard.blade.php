@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3">Dashboard Admin</h1>
                <p class="text-muted">Selamat datang di panel admin sistem penggajian karyawan.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="text-muted mb-2">Total Karyawan</h5>
                                <h2 class="mb-0">{{ $totalEmployees }}</h2>
                            </div>
                            <div class="col-4 text-end">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('employees.index') }}" class="text-decoration-none">
                            <small class="text-muted">Lihat Detail <i class="fas fa-arrow-right ms-1"></i></small>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="text-muted mb-2">Kehadiran Hari Ini</h5>
                                <h2 class="mb-0">{{ $todayAttendance }}</h2>
                            </div>
                            <div class="col-4 text-end">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('attendances.index') }}" class="text-decoration-none">
                            <small class="text-muted">Lihat Detail <i class="fas fa-arrow-right ms-1"></i></small>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="text-muted mb-2">Total Gaji Bulan Ini</h5>
                                <h2 class="mb-0">Rp {{ number_format($totalSalaries, 0, ',', '.') }}</h2>
                            </div>
                            <div class="col-4 text-end">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('salaries.index') }}" class="text-decoration-none">
                            <small class="text-muted">Lihat Detail <i class="fas fa-arrow-right ms-1"></i></small>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Absensi Terbaru</h5>
                        <a href="{{ route('attendances.index') }}" class="btn btn-sm btn-primary">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Karyawan</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentAttendances as $attendance)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($attendance->employee->user->name) }}&background=random"
                                                        class="rounded-circle me-2" width="32" height="32">
                                                    <div>
                                                        <span class="fw-bold">{{ $attendance->employee->user->name }}</span>
                                                        <small
                                                            class="d-block text-muted">{{ $attendance->employee->position }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                            <td>{{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '-' }}
                                            </td>
                                            <td>{{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '-' }}
                                            </td>
                                            <td>
                                                @if ($attendance->status == 'hadir')
                                                    <span class="badge bg-success">Hadir</span>
                                                @elseif($attendance->status == 'izin')
                                                    <span class="badge bg-info">Izin</span>
                                                @elseif($attendance->status == 'sakit')
                                                    <span class="badge bg-warning">Sakit</span>
                                                @elseif($attendance->status == 'cuti')
                                                    <span class="badge bg-primary">Cuti</span>
                                                @else
                                                    <span class="badge bg-danger">Alpha</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($recentAttendances->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center py-3">Belum ada data absensi</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

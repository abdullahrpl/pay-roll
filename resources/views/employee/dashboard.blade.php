@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3">Dashboard Karyawan</h1>
                <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Attendance Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Absensi Hari Ini</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h2 id="clock" class="display-4 mb-3">{{ now()->format('H:i:s') }}</h2>
                            <p class="mb-1">{{ now()->format('l, d F Y') }}</p>
                        </div>

                        <div class="row justify-content-center">
                            @if (!$todayAttendance || !$todayAttendance->clock_in)
                                <div class="col-md-6 mb-3">
                                    <form action="{{ route('attendance.clockIn') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100 py-3">
                                            <i class="fas fa-sign-in-alt me-2"></i> Presensi Masuk
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="col-md-6 mb-3">
                                    <button type="button" class="btn btn-outline-success w-100 py-3" disabled>
                                        <i class="fas fa-check-circle me-2"></i> Presensi Masuk:
                                        {{ \Carbon\Carbon::parse($todayAttendance->clock_in)->format('H:i') }}
                                    </button>
                                </div>
                            @endif

                            @if ($todayAttendance && $todayAttendance->clock_in && !$todayAttendance->clock_out)
                                <div class="col-md-6 mb-3">
                                    <form action="{{ route('attendance.clockOut') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100 py-3">
                                            <i class="fas fa-sign-out-alt me-2"></i> Presensi Pulang
                                        </button>
                                    </form>
                                </div>
                            @elseif($todayAttendance && $todayAttendance->clock_out)
                                <div class="col-md-6 mb-3">
                                    <button type="button" class="btn btn-outline-danger w-100 py-3" disabled>
                                        <i class="fas fa-check-circle me-2"></i> Presensi Pulang:
                                        {{ \Carbon\Carbon::parse($todayAttendance->clock_out)->format('H:i') }}
                                    </button>
                                </div>
                            @else
                                <div class="col-md-6 mb-3">
                                    <button type="button" class="btn btn-outline-danger w-100 py-3" disabled>
                                        <i class="fas fa-sign-out-alt me-2"></i> Presensi Pulang
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Attendance -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Riwayat Absensi Terakhir</h5>
                        <a href="{{ route('employee.attendance.history') }}" class="btn btn-sm btn-primary">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentAttendances as $attendance)
                                        <tr>
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
                                            <td colspan="4" class="text-center py-3">Belum ada data absensi</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Profile Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Profil Karyawan</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random&size=128"
                            alt="Profile" class="rounded-circle img-fluid mb-3" style="width: 100px; height: 100px;">
                        <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-1">{{ $employee->position }}</p>
                        <p class="small text-muted mb-3">{{ $employee->department }}</p>

                        <hr>

                        <div class="mb-2">
                            <p class="mb-1 fw-bold text-muted small">NIP</p>
                            <p>{{ $employee->nip }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="mb-1 fw-bold text-muted small">Email</p>
                            <p>{{ auth()->user()->email }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="mb-1 fw-bold text-muted small">Telepon</p>
                            <p>{{ $employee->phone_number }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="mb-1 fw-bold text-muted small">Alamat</p>
                            <p>{{ $employee->address }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="mb-1 fw-bold text-muted small">Tanggal Bergabung</p>
                            <p>{{ \Carbon\Carbon::parse($employee->join_date)->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Salary Info -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informasi Gaji</h5>
                        <a href="{{ route('employee.salary.history') }}" class="btn btn-sm btn-primary">
                            Riwayat Gaji
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($thisMonthSalary)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold">Periode</span>
                                    <span>{{ $thisMonthSalary->period }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold">Gaji Pokok</span>
                                    <span>Rp {{ number_format($thisMonthSalary->basic_salary, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold">Potongan</span>
                                    <span>Rp {{ number_format($thisMonthSalary->deduction, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold">Bonus</span>
                                    <span>Rp {{ number_format($thisMonthSalary->bonus, 0, ',', '.') }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold h5">Total</span>
                                    <span class="fw-bold h5 text-primary">Rp
                                        {{ number_format($thisMonthSalary->total_salary, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="badge bg-{{ $thisMonthSalary->is_paid ? 'success' : 'warning' }} mb-2">
                                    {{ $thisMonthSalary->is_paid ? 'Sudah Dibayar' : 'Belum Dibayar' }}
                                </div>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <p class="mb-0">Belum ada data gaji bulan ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Update clock every second
        function updateClock() {
            var now = new Date();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            document.getElementById('clock').textContent = hours + ':' + minutes + ':' + seconds;
        }

        setInterval(updateClock, 1000);
    </script>
@endsection

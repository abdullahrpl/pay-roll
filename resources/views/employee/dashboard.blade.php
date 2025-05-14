@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4 mt-4">
            <div class="col-12">
                <h1 class="h3 fw-bold text-dark">Dashboard Karyawan</h1>
                <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>
            </div>
        </div>

        <div class="row space-y-2">
            <div class="card shadow-sm mb-5 hover-effect border-0 h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="fw-semibold mb-0">Absensi Hari Ini</h5>
                </div>
                <div class="card-body text-center">
                    <h2 id="clock" class="display-5 fw-bold text-primary mb-2">{{ now()->format('H:i:s') }}</h2>
                    <p class="text-muted mb-4">{{ now()->format('l, d F Y') }}</p>

                    <div class="row justify-content-center">
                        @if (!$todayAttendance || !$todayAttendance->clock_in)
                            <div class="col-md-6 mb-2">
                                <form action="{{ route('attendance.clockIn') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100 py-3 rounded-pill shadow-sm">
                                        <i class="fas fa-sign-in-alt me-2"></i> Presensi Masuk
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="col-md-6 mb-2">
                                <button class="btn btn-outline-success w-100 py-3 rounded-pill" disabled>
                                    <i class="fas fa-check-circle me-2"></i> Masuk:
                                    {{ \Carbon\Carbon::parse($todayAttendance->clock_in)->format('H:i') }}
                                </button>
                            </div>
                        @endif

                        @if ($todayAttendance && $todayAttendance->clock_in && !$todayAttendance->clock_out)
                            <div class="col-md-6">
                                <form action="{{ route('attendance.clockOut') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100 py-3 rounded-pill shadow-sm">
                                        <i class="fas fa-sign-out-alt me-2"></i> Presensi Pulang
                                    </button>
                                </form>
                            </div>
                        @elseif($todayAttendance && $todayAttendance->clock_out)
                            <div class="col-md-6">
                                <button class="btn btn-outline-danger w-100 py-3 rounded-pill" disabled>
                                    <i class="fas fa-check-circle me-2"></i> Pulang:
                                    {{ \Carbon\Carbon::parse($todayAttendance->clock_out)->format('H:i') }}
                                </button>
                            </div>
                        @else
                            <div class="col-md-6">
                                <button class="btn btn-outline-danger w-100 py-3 rounded-pill" disabled>
                                    <i class="fas fa-sign-out-alt me-2"></i> Presensi Pulang
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-5 hover-effect border-0">
                <!-- Profile Card -->
                <div class="card shadow-sm hover-effect border-0">
                    <div class="card-body text-center">
                        <div class="mb-3 position-relative">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random&size=128"
                                alt="Profile" class="rounded-circle shadow"
                                style="width: 110px; height: 110px; object-fit: cover; border: 4px solid #f1f1f1;">
                        </div>

                        <h5 class="fw-semibold mb-0">{{ auth()->user()->name }}</h5>
                        <div class="text-muted small">{{ $employee->position }} — {{ $employee->department }}</div>

                        <hr class="my-4">

                        <ul class="list-group list-group-flush text-start">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-semibold text-muted small">NIP</span>
                                <span>{{ $employee->nip }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-semibold text-muted small">Email</span>
                                <span>{{ auth()->user()->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-semibold text-muted small">Telepon</span>
                                <span>{{ $employee->phone_number }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-semibold text-muted small">Alamat</span>
                                <span class="text-end">{{ $employee->address }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="fw-semibold text-muted small">Tanggal Bergabung</span>
                                <span>{{ \Carbon\Carbon::parse($employee->join_date)->format('d M Y') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-5 hover-effect border-0">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-semibold mb-0">Riwayat Absensi Terakhir</h5>
                    <a href="{{ route('employee.attendance.history') }}"
                        class="btn btn-sm btn-outline-primary rounded-pill">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Masuk</th>
                                    <th>Pulang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentAttendances as $attendance)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                        <td>{{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '-' }}
                                        </td>
                                        <td>{{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '-' }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge rounded-pill bg-{{ [
                                                    'hadir' => 'success',
                                                    'izin' => 'info',
                                                    'sakit' => 'warning',
                                                    'cuti' => 'primary',
                                                ][$attendance->status] ?? 'danger' }}">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Belum ada data absensi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-5 hover-effect border-0">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-semibold mb-0">Informasi Gaji</h5>
                    <a href="{{ route('employee.salary.history') }}"
                        class="btn btn-sm btn-outline-primary rounded-pill">Riwayat Gaji</a>
                </div>
                <div class="card-body">
                    @if ($thisMonthSalary)
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Periode</span>
                                <span class="fw-semibold">{{ $thisMonthSalary->period }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Gaji Pokok</span>
                                <span>Rp {{ number_format($thisMonthSalary->basic_salary, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Potongan</span>
                                <span>Rp {{ number_format($thisMonthSalary->deduction, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Bonus</span>
                                <span>Rp {{ number_format($thisMonthSalary->bonus, 0, ',', '.') }}</span>
                            </li>
                        </ul>
                        <div class="text-center mt-3">
                            <h5 class="fw-bold text-primary">Total: Rp
                                {{ number_format($thisMonthSalary->total_salary, 0, ',', '.') }}</h5>
                            <div
                                class="badge bg-{{ $thisMonthSalary->is_paid ? 'success' : 'warning' }} rounded-pill mt-2">
                                {{ $thisMonthSalary->is_paid ? 'Sudah Dibayar' : 'Belum Dibayar' }}
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-3">
                            <p class="mb-0">Belum ada data gaji bulan ini</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@section('styles')
    <style>
        .hover-effect {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-effect:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
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

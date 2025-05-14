@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold fs-3 mb-1">📄 Detail Karyawan</h1>
                <p class="text-secondary">Informasi lengkap tentang karyawan.</p>
            </div>
            <div>
                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary me-2 px-3">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary px-3">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profil -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow rounded-4 text-center p-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->user->name) }}&background=random&size=128"
                    alt="Profile" class="rounded-circle img-fluid mb-3 mx-auto" style="width: 130px; height: 130px;">
                <h5 class="fw-bold mb-0">{{ $employee->user->name }}</h5>
                <p class="text-muted mt-1 mb-0">{{ $employee->position }}</p>
                <p class="text-muted small">{{ $employee->department }}</p>

                <div class="mt-3 d-flex justify-content-center gap-2">
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-outline-primary btn-sm px-3">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Informasi Karyawan -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-semibold text-primary mb-3">🧾 Informasi Karyawan</h5>
                </div>
                <div class="card-body">
                    @php
                        $info = [
                            'Nama Lengkap' => $employee->user->name,
                            'NIP' => $employee->nip,
                            'Email' => $employee->user->email,
                            'Jabatan' => $employee->position,
                            'Departemen' => $employee->department,
                            'Nomor Telepon' => $employee->phone_number,
                            'Alamat' => $employee->address,
                            'Tanggal Bergabung' => $employee->join_date->format('d F Y'),
                            'Gaji Pokok' => 'Rp ' . number_format($employee->basic_salary, 0, ',', '.'),
                        ];
                    @endphp

                    @foreach($info as $label => $value)
                        <div class="row py-2">
                            <div class="col-sm-4 text-muted fw-semibold">{{ $label }}</div>
                            <div class="col-sm-8">{{ $value }}</div>
                        </div>
                        @if (!$loop->last)
                            <hr class="my-1">
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Riwayat Absensi -->
            <div class="card shadow rounded-4 mt-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-white pt-4 pb-2">
                    <h5 class="fw-semibold text-primary mb-0">🕓 Riwayat Absensi</h5>
                    <a href="{{ route('attendances.index') }}?employee_id={{ $employee->id }}"
                        class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if ($employee->attendances && $employee->attendances->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee->attendances->sortByDesc('date')->take(5) as $attendance)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                            <td>{{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '-' }}</td>
                                            <td>{{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '-' }}</td>
                                            <td>
                                                @php
                                                    $statusMap = [
                                                        'hadir' => ['Hadir', 'success'],
                                                        'izin' => ['Izin', 'info'],
                                                        'sakit' => ['Sakit', 'warning'],
                                                        'cuti' => ['Cuti', 'primary'],
                                                        'alpha' => ['Alpha', 'danger'],
                                                    ];
                                                    [$label, $color] = $statusMap[$attendance->status] ?? ['-', 'secondary'];
                                                @endphp
                                                <span class="badge bg-{{ $color }}">{{ $label }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            Belum ada data absensi
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

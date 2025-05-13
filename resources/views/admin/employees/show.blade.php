@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3">Detail Karyawan</h1>
                    <p class="text-muted">Informasi lengkap karyawan.</p>
                </div>
                <div>
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Profil Karyawan</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->user->name) }}&background=random&size=128"
                            alt="Profile" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px;">
                        <h5 class="mb-0">{{ $employee->user->name }}</h5>
                        <p class="text-muted mb-1">{{ $employee->position }}</p>
                        <p class="small text-muted mb-3">{{ $employee->department }}</p>

                        <hr>

                        <div class="d-flex justify-content-center mt-3">
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary me-2">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Karyawan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Nama Lengkap</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ $employee->user->name }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">NIP</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ $employee->nip }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Email</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ $employee->user->email }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Jabatan</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ $employee->position }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Departemen</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ $employee->department }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Nomor Telepon</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ $employee->phone_number }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Alamat</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ $employee->address }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Tanggal Bergabung</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ $employee->join_date->format('d F Y') }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Gaji Pokok</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">Rp {{ number_format($employee->basic_salary, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Riwayat Absensi</h5>
                        <a href="{{ route('attendances.index') }}?employee_id={{ $employee->id }}"
                            class="btn btn-sm btn-primary">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($employee->attendances && $employee->attendances->count() > 0)
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
                                        @foreach ($employee->attendances->sortByDesc('date')->take(5) as $attendance)
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
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <p class="mb-0">Belum ada data absensi</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

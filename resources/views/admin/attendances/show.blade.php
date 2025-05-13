@extends('layouts.app')

@section('title', 'Detail Absensi')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3">Detail Absensi</h1>
                    <p class="text-muted">Informasi lengkap absensi.</p>
                </div>
                <div>
                    <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Karyawan</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($attendance->employee->user->name) }}&background=random&size=128"
                            alt="Profile" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px;">
                        <h5 class="mb-0">{{ $attendance->employee->user->name }}</h5>
                        <p class="text-muted mb-1">{{ $attendance->employee->position }}</p>
                        <p class="small text-muted mb-3">{{ $attendance->employee->department }}</p>

                        <hr>

                        <div class="mb-2">
                            <p class="mb-1 fw-bold text-muted small">NIP</p>
                            <p>{{ $attendance->employee->nip }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="mb-1 fw-bold text-muted small">Email</p>
                            <p>{{ $attendance->employee->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Absensi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Tanggal</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ \Carbon\Carbon::parse($attendance->date)->format('d F Y') }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Status</p>
                            </div>
                            <div class="col-sm-8">
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
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Jam Masuk</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">
                                    {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Jam Pulang</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">
                                    {{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Durasi Kerja</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">
                                    {{ $attendance->clock_in && $attendance->clock_out ? $attendance->getDurationAttribute() . ' jam' : '-' }}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Keterangan</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ $attendance->notes ?: '-' }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Dibuat Pada</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ $attendance->created_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 fw-bold">Diperbarui Pada</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0">{{ $attendance->updated_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

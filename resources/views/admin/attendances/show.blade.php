@extends('layouts.app')

@section('title', 'Detail Absensi')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 fw-bold text-dark">📄 Detail Absensi</h1>
                <p class="text-muted">Informasi lengkap absensi karyawan.</p>
            </div>
            <div>
                <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-primary me-2 d-flex align-items-center gap-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('attendances.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Karyawan -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold text-primary">👤 Informasi Karyawan</h5>
                </div>
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($attendance->employee->user->name) }}&background=random&size=128"
                        alt="Profile" class="rounded-circle mb-3 shadow" width="150" height="150">
                    <h5 class="mb-0 fw-bold">{{ $attendance->employee->user->name }}</h5>
                    <p class="text-muted mb-1">{{ $attendance->employee->position }}</p>
                    <p class="small text-muted mb-3">{{ $attendance->employee->department }}</p>

                    <hr>
                    <div class="text-start">
                        <div class="mb-3">
                            <small class="text-muted fw-semibold">NIP</small>
                            <p class="mb-0">{{ $attendance->employee->nip }}</p>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold">Email</small>
                            <p class="mb-0">{{ $attendance->employee->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Absensi -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-semibold text-primary">📆 Informasi Absensi</h5>
                </div>
                <div class="card-body">
                    @php
                        $info = [
                            'Tanggal' => \Carbon\Carbon::parse($attendance->date)->format('d F Y'),
                            'Status' => match($attendance->status) {
                                'hadir' => '<span class="badge bg-success">Hadir</span>',
                                'izin' => '<span class="badge bg-info">Izin</span>',
                                'sakit' => '<span class="badge bg-warning">Sakit</span>',
                                'cuti' => '<span class="badge bg-primary">Cuti</span>',
                                default => '<span class="badge bg-danger">Alpha</span>',
                            },
                            'Jam Masuk' => $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '-',
                            'Jam Pulang' => $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '-',
                            'Durasi Kerja' => $attendance->clock_in && $attendance->clock_out ? $attendance->getDurationAttribute() . ' jam' : '-',
                            'Keterangan' => $attendance->notes ?: '-',
                            'Dibuat Pada' => $attendance->created_at->format('d F Y H:i'),
                            'Diperbarui Pada' => $attendance->updated_at->format('d F Y H:i'),
                        ];
                    @endphp

                    @foreach($info as $label => $value)
                        <div class="row py-2 border-bottom">
                            <div class="col-sm-4 fw-semibold text-muted">{{ $label }}</div>
                            <div class="col-sm-8">{!! $value !!}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

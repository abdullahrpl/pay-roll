@extends('layouts.app')

@section('title', 'Detail Penggajian')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3">Detail Penggajian</h1>
                    <p class="text-muted">Informasi lengkap penggajian karyawan.</p>
                </div>
                <div>
                    <a href="{{ route('salaries.edit', $salary->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('salaries.payslip', $salary->id) }}" class="btn btn-secondary me-2" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i> Slip Gaji
                    </a>
                    <a href="{{ route('salaries.index') }}" class="btn btn-light">
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
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($salary->employee->user->name) }}&background=random&size=128"
                            alt="Profile" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px;">
                        <h5 class="mb-0">{{ $salary->employee->user->name }}</h5>
                        <p class="text-muted mb-1">{{ $salary->employee->position }}</p>
                        <p class="small text-muted mb-3">{{ $salary->employee->department }}</p>

                        <hr>

                        <div class="mb-2">
                            <p class="mb-1 fw-bold text-muted small">NIP</p>
                            <p>{{ $salary->employee->nip }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="mb-1 fw-bold text-muted small">Email</p>
                            <p>{{ $salary->employee->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Penggajian</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title text-white">Total Gaji</h5>
                                        <h3 class="mb-0">{{ $salary->formatted_total_salary }}</h3>
                                        <small>Periode: {{ $salary->period }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card {{ $salary->is_paid ? 'bg-success' : 'bg-warning' }} text-white">
                                    <div class="card-body">
                                        <h5 class="card-title text-white">Status Pembayaran</h5>
                                        <h3 class="mb-0">{{ $salary->is_paid ? 'Dibayar' : 'Belum Dibayar' }}</h3>
                                        <small>
                                            {{ $salary->is_paid ? 'Dibayar pada: ' . $salary->paid_at->format('d F Y H:i') : 'Menunggu pembayaran' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th colspan="2" class="text-center">Rincian Penggajian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="40%">Periode</td>
                                        <td>{{ $salary->period }}</td>
                                    </tr>
                                    <tr>
                                        <td>Gaji Pokok</td>
                                        <td>Rp {{ number_format($salary->basic_salary, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Kehadiran</td>
                                        <td>{{ $salary->attendance_count }} hari</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Ketidakhadiran</td>
                                        <td>{{ $salary->absence_count }} hari</td>
                                    </tr>
                                    <tr>
                                        <td>Potongan</td>
                                        <td>Rp {{ number_format($salary->deduction, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bonus</td>
                                        <td>Rp {{ number_format($salary->bonus, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="table-secondary">
                                        <td class="fw-bold">Total Gaji</td>
                                        <td class="fw-bold">{{ $salary->formatted_total_salary }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            @if ($salary->is_paid)
                                                <span class="badge bg-success">Dibayar</span>
                                            @else
                                                <span class="badge bg-warning">Belum Dibayar</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($salary->is_paid)
                                        <tr>
                                            <td>Tanggal Pembayaran</td>
                                            <td>{{ $salary->paid_at->format('d F Y H:i') }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>{{ $salary->notes ?: '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Edit Penggajian')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3">Edit Penggajian</h1>
                <p class="text-muted">Edit data penggajian karyawan.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Edit Penggajian</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('salaries.update', $salary->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Informasi Karyawan</h6>
                                            <p class="card-text mb-1"><strong>Nama:</strong>
                                                {{ $salary->employee->user->name }}</p>
                                            <p class="card-text mb-1"><strong>NIP:</strong> {{ $salary->employee->nip }}</p>
                                            <p class="card-text mb-0"><strong>Periode:</strong> {{ $salary->period }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Informasi Gaji</h6>
                                            <p class="card-text mb-1"><strong>Gaji Pokok:</strong> Rp
                                                {{ number_format($salary->basic_salary, 0, ',', '.') }}</p>
                                            <p class="card-text mb-1"><strong>Kehadiran:</strong>
                                                {{ $salary->attendance_count }} hari</p>
                                            <p class="card-text mb-0"><strong>Ketidakhadiran:</strong>
                                                {{ $salary->absence_count }} hari</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Potongan & Total</h6>
                                            <p class="card-text mb-1"><strong>Potongan:</strong> Rp
                                                {{ number_format($salary->deduction, 0, ',', '.') }}</p>
                                            <p class="card-text mb-1"><strong>Total Sekarang:</strong>
                                                {{ $salary->formatted_total_salary }}</p>
                                            <p class="card-text mb-0"><strong>Status:</strong>
                                                @if ($salary->is_paid)
                                                    <span class="badge bg-success">Dibayar</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Dibayar</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="bonus" class="form-label">Bonus</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('bonus') is-invalid @enderror"
                                        id="bonus" name="bonus" value="{{ old('bonus') ?? $salary->bonus }}"
                                        min="0">
                                </div>
                                <small class="text-muted">Bonus tambahan di luar gaji pokok</small>
                                @error('bonus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Keterangan</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') ?? $salary->notes }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_paid" name="is_paid"
                                        value="1" {{ old('is_paid') ?? $salary->is_paid ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_paid">Tandai sebagai Dibayar</label>
                                </div>
                                <small class="text-muted">Jika dicentang, sistem akan menandai gaji ini sebagai sudah
                                    dibayar dengan tanggal pembayaran saat ini.</small>
                            </div>

                            <div class="alert alert-info">
                                <h6 class="alert-heading">Informasi Perhitungan</h6>
                                <p class="mb-0 small">Sistem akan otomatis menghitung ulang total gaji jika Anda mengubah
                                    nilai bonus.</p>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('salaries.index') }}" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

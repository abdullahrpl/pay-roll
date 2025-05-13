@extends('layouts.app')

@section('title', 'Tambah Penggajian')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3">Tambah Penggajian</h1>
                <p class="text-muted">Tambahkan data penggajian karyawan.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Tambah Penggajian</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('salaries.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="employee_id" class="form-label">Karyawan</label>
                                    <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id"
                                        name="employee_id" required>
                                        <option value="">Pilih Karyawan</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->user->name }} - {{ $employee->nip }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="month" class="form-label">Bulan</label>
                                    <select class="form-select @error('month') is-invalid @enderror" id="month"
                                        name="month" required>
                                        <option value="">Pilih Bulan</option>
                                        @foreach ($months as $key => $month)
                                            <option value="{{ $key }}"
                                                {{ old('month') == $key ? 'selected' : '' }}>
                                                {{ $month }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('month')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="year" class="form-label">Tahun</label>
                                    <select class="form-select @error('year') is-invalid @enderror" id="year"
                                        name="year" required>
                                        <option value="">Pilih Tahun</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}"
                                                {{ old('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="bonus" class="form-label">Bonus (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('bonus') is-invalid @enderror"
                                        id="bonus" name="bonus" value="{{ old('bonus') ?? 0 }}" min="0">
                                </div>
                                <small class="text-muted">Bonus tambahan di luar gaji pokok</small>
                                @error('bonus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Keterangan (Opsional)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <h6 class="alert-heading">Informasi Perhitungan</h6>
                                <p class="mb-0 small">Sistem akan otomatis menghitung total gaji berdasarkan:</p>
                                <ul class="mb-0 small">
                                    <li>Gaji pokok karyawan terdaftar di sistem</li>
                                    <li>Data absensi pada bulan dan tahun yang dipilih</li>
                                    <li>Potongan untuk ketidakhadiran (sakit, izin, atau alpha)</li>
                                    <li>Bonus tambahan yang diinput</li>
                                </ul>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('salaries.index') }}" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

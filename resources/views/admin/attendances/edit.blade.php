@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 fw-bold text-dark">Edit Absensi</h1>
                <p class="text-muted">Edit data absensi karyawan.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 hover-effect">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-semibold text-primary">✏️ Form Edit Absensi</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="employee_id" class="form-label fw-semibold">Karyawan</label>
                                    <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id"
                                        name="employee_id" required>
                                        <option value="">Pilih Karyawan</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ (old('employee_id') ?? $attendance->employee_id) == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->user->name }} - {{ $employee->nip }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="date" class="form-label fw-semibold">Tanggal</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        id="date" name="date"
                                        value="{{ old('date') ?? $attendance->date->format('Y-m-d') }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="status" class="form-label fw-semibold">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="hadir"
                                            {{ (old('status') ?? $attendance->status) == 'hadir' ? 'selected' : '' }}>Hadir
                                        </option>
                                        <option value="izin"
                                            {{ (old('status') ?? $attendance->status) == 'izin' ? 'selected' : '' }}>Izin
                                        </option>
                                        <option value="sakit"
                                            {{ (old('status') ?? $attendance->status) == 'sakit' ? 'selected' : '' }}>Sakit
                                        </option>
                                        <option value="cuti"
                                            {{ (old('status') ?? $attendance->status) == 'cuti' ? 'selected' : '' }}>Cuti
                                        </option>
                                        <option value="alpha"
                                            {{ (old('status') ?? $attendance->status) == 'alpha' ? 'selected' : '' }}>Alpha
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="clock_in" class="form-label fw-semibold">Jam Masuk</label>
                                    <input type="time" class="form-control @error('clock_in') is-invalid @enderror"
                                        id="clock_in" name="clock_in"
                                        value="{{ old('clock_in') ?? ($attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '') }}">
                                    @error('clock_in')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="clock_out" class="form-label fw-semibold">Jam Pulang</label>
                                    <input type="time" class="form-control @error('clock_out') is-invalid @enderror"
                                        id="clock_out" name="clock_out"
                                        value="{{ old('clock_out') ?? ($attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '') }}">
                                    @error('clock_out')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label fw-semibold">Keterangan</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') ?? $attendance->notes }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('attendances.index') }}" class="btn btn-outline-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

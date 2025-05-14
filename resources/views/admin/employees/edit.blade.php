@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold fs-3 mb-1">✏️ Edit Karyawan</h1>
            <p class="text-secondary">Ubah informasi lengkap karyawan dengan mudah.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="fw-semibold text-primary">📋 Formulir Data Karyawan</h5>
                </div>
                <div class="card-body pt-2">
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama & Email --}}
                        <div class="row g-4 mb-2">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">👤 Nama Lengkap</label>
                                <input type="text" class="form-control shadow-sm @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ old('name', $employee->user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">📧 Email</label>
                                <input type="email" class="form-control shadow-sm @error('email') is-invalid @enderror" 
                                    id="email" name="email" value="{{ old('email', $employee->user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Password & NIP --}}
                        <div class="row g-4 mb-2">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">🔒 Password</label>
                                <input type="password" class="form-control shadow-sm @error('password') is-invalid @enderror" 
                                    id="password" name="password">
                                <small class="text-muted">Biarkan kosong jika tidak ingin diubah.</small>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nip" class="form-label fw-semibold">🆔 NIP</label>
                                <input type="text" class="form-control shadow-sm @error('nip') is-invalid @enderror" 
                                    id="nip" name="nip" value="{{ old('nip', $employee->nip) }}" required>
                                @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Jabatan & Departemen --}}
                        <div class="row g-4 mb-2">
                            <div class="col-md-6">
                                <label for="position" class="form-label fw-semibold">💼 Jabatan</label>
                                <input type="text" class="form-control shadow-sm @error('position') is-invalid @enderror" 
                                    id="position" name="position" value="{{ old('position', $employee->position) }}" required>
                                @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="department" class="form-label fw-semibold">🏢 Departemen</label>
                                <input type="text" class="form-control shadow-sm @error('department') is-invalid @enderror" 
                                    id="department" name="department" value="{{ old('department', $employee->department) }}" required>
                                @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Telepon & Tanggal --}}
                        <div class="row g-4 mb-2">
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label fw-semibold">📱 Nomor Telepon</label>
                                <input type="text" class="form-control shadow-sm @error('phone_number') is-invalid @enderror" 
                                    id="phone_number" name="phone_number" value="{{ old('phone_number', $employee->phone_number) }}" required>
                                @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="join_date" class="form-label fw-semibold">📅 Tanggal Bergabung</label>
                                <input type="date" class="form-control shadow-sm @error('join_date') is-invalid @enderror" 
                                    id="join_date" name="join_date" value="{{ old('join_date', $employee->join_date->format('Y-m-d')) }}" required>
                                @error('join_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Gaji --}}
                        <div class="row g-4 mb-2">
                            <div class="col-md-6">
                                <label for="basic_salary" class="form-label fw-semibold">💰 Gaji Pokok</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="number" class="form-control @error('basic_salary') is-invalid @enderror" 
                                        id="basic_salary" name="basic_salary" value="{{ old('basic_salary', $employee->basic_salary) }}" required>
                                </div>
                                @error('basic_salary') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">📍 Alamat</label>
                            <textarea class="form-control shadow-sm @error('address') is-invalid @enderror" 
                                id="address" name="address" rows="3" required>{{ old('address', $employee->address) }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                                ❌ Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill shadow">
                                💾 Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

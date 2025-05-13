@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3">Manajemen Karyawan</h1>
                    <p class="text-muted">Kelola data karyawan perusahaan.</p>
                </div>
                <div>
                    <a href="{{ route('employees.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Tambah Karyawan
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Daftar Karyawan</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIP</th>
                                        <th>Email</th>
                                        <th>Jabatan</th>
                                        <th>Departemen</th>
                                        <th>Gaji Pokok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($employees as $key => $employee)
                                        <tr>
                                            <td>{{ $employees->firstItem() + $key }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->user->name) }}&background=random"
                                                        class="rounded-circle me-2" width="32" height="32">
                                                    <span>{{ $employee->user->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $employee->nip }}</td>
                                            <td>{{ $employee->user->email }}</td>
                                            <td>{{ $employee->position }}</td>
                                            <td>{{ $employee->department }}</td>
                                            <td>Rp {{ number_format($employee->basic_salary, 0, ',', '.') }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('employees.show', $employee->id) }}"
                                                        class="btn btn-sm btn-info me-1" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('employees.edit', $employee->id) }}"
                                                        class="btn btn-sm btn-primary me-1" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('employees.destroy', $employee->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-3">Belum ada data karyawan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $employees->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

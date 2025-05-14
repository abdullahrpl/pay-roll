@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold fs-3 mb-1">👥 Manajemen Karyawan</h1>
                <p class="text-secondary">Kelola dan pantau seluruh data karyawan perusahaan Anda.</p>
            </div>
            <div>
                <a href="{{ route('employees.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow">
                    <i class="fas fa-user-plus me-2"></i> Tambah Karyawan
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 pb-2">
                    <h5 class="fw-semibold text-primary mb-0">📄 Daftar Karyawan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr class="text-secondary fw-semibold">
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Email</th>
                                    <th>Jabatan</th>
                                    <th>Departemen</th>
                                    <th>Gaji Pokok</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $key => $employee)
                                    <tr>
                                        <td>{{ $employees->firstItem() + $key }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->user->name) }}&background=random"
                                                    alt="Avatar" class="rounded-circle me-2" width="36" height="36">
                                                <span class="fw-medium">{{ $employee->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $employee->nip }}</td>
                                        <td>{{ $employee->user->email }}</td>
                                        <td>{{ $employee->position }}</td>
                                        <td>{{ $employee->department }}</td>
                                        <td>Rp {{ number_format($employee->basic_salary, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-outline-info rounded-circle" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-outline-primary rounded-circle" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">Belum ada data karyawan</td>
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

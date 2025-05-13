@extends('layouts.app')

@section('title', 'Manajemen Penggajian')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3">Manajemen Penggajian</h1>
                    <p class="text-muted">Kelola data penggajian karyawan.</p>
                </div>
                <div>
                    <a href="{{ route('salaries.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Tambah Penggajian
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Daftar Penggajian</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Karyawan</th>
                                        <th>Periode</th>
                                        <th>Gaji Pokok</th>
                                        <th>Potongan</th>
                                        <th>Bonus</th>
                                        <th>Total Gaji</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($salaries as $key => $salary)
                                        <tr>
                                            <td>{{ $salaries->firstItem() + $key }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($salary->employee->user->name) }}&background=random"
                                                        class="rounded-circle me-2" width="32" height="32">
                                                    <span>{{ $salary->employee->user->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $salary->period }}</td>
                                            <td>Rp {{ number_format($salary->basic_salary, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($salary->deduction, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($salary->bonus, 0, ',', '.') }}</td>
                                            <td>{{ $salary->formatted_total_salary }}</td>
                                            <td>
                                                @if ($salary->is_paid)
                                                    <span class="badge bg-success">Dibayar</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Dibayar</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('salaries.show', $salary->id) }}"
                                                        class="btn btn-sm btn-info me-1" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('salaries.edit', $salary->id) }}"
                                                        class="btn btn-sm btn-primary me-1" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('salaries.payslip', $salary->id) }}"
                                                        class="btn btn-sm btn-secondary me-1" title="Slip Gaji"
                                                        target="_blank">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                    <form action="{{ route('salaries.destroy', $salary->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data penggajian ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-3">Belum ada data penggajian</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $salaries->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Histori Penggajian')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3">Histori Penggajian</h1>
                <p class="text-muted">Riwayat penggajian Anda.</p>
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
                                        <th>Periode</th>
                                        <th>Gaji Pokok</th>
                                        <th>Kehadiran</th>
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
                                            <td>{{ $salary->period }}</td>
                                            <td>Rp {{ number_format($salary->basic_salary, 0, ',', '.') }}</td>
                                            <td>{{ $salary->attendance_count }} hari</td>
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
                                                <a href="{{ route('salaries.payslip', $salary->id) }}"
                                                    class="btn btn-sm btn-secondary" title="Slip Gaji" target="_blank">
                                                    <i class="fas fa-file-pdf"></i> Slip Gaji
                                                </a>
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

@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 fw-bold text-dark">Riwayat Absensi</h1>
                <p class="text-muted">Daftar riwayat absensi Anda.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4 hover-effect">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold text-primary">📅 Riwayat Absensi</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive rounded">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr class="text-secondary small text-uppercase">
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($attendances as $key => $attendance)
                                        <tr class="table-row-hover">
                                            <td>{{ $attendances->firstItem() + $key }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                            <td>{{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '-' }}</td>
                                            <td>{{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '-' }}</td>
                                            <td>
                                                @php
                                                    $badgeColors = [
                                                        'hadir' => 'success',
                                                        'izin' => 'info',
                                                        'sakit' => 'warning',
                                                        'cuti' => 'primary',
                                                        'alpha' => 'danger'
                                                    ];
                                                    $color = $badgeColors[$attendance->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }} bg-opacity-75 px-3 py-2 rounded-pill text-capitalize">
                                                    {{ $attendance->status }}
                                                </span>
                                            </td>
                                            <td>{{ $attendance->notes }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data absensi</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $attendances->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

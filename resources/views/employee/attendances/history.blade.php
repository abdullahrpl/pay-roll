@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3">Riwayat Absensi</h1>
                <p class="text-muted">Daftar riwayat absensi Anda.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Riwayat Absensi</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
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
                                        <tr>
                                            <td>{{ $attendances->firstItem() + $key }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                            <td>{{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '-' }}
                                            </td>
                                            <td>{{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '-' }}
                                            </td>
                                            <td>
                                                @if ($attendance->status == 'hadir')
                                                    <span class="badge bg-success">Hadir</span>
                                                @elseif($attendance->status == 'izin')
                                                    <span class="badge bg-info">Izin</span>
                                                @elseif($attendance->status == 'sakit')
                                                    <span class="badge bg-warning">Sakit</span>
                                                @elseif($attendance->status == 'cuti')
                                                    <span class="badge bg-primary">Cuti</span>
                                                @else
                                                    <span class="badge bg-danger">Alpha</span>
                                                @endif
                                            </td>
                                            <td>{{ $attendance->notes }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-3">Belum ada data absensi</td>
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

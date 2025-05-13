@extends('layouts.app')

@section('title', 'Manajemen Absensi')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3">Manajemen Absensi</h1>
                    <p class="text-muted">Kelola data absensi karyawan.</p>
                </div>
                <div>
                    <a href="{{ route('attendances.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Tambah Absensi
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Daftar Absensi</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Karyawan</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($attendances as $key => $attendance)
                                        <tr>
                                            <td>{{ $attendances->firstItem() + $key }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($attendance->employee->user->name) }}&background=random"
                                                        class="rounded-circle me-2" width="32" height="32">
                                                    <span>{{ $attendance->employee->user->name }}</span>
                                                </div>
                                            </td>
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
                                            <td>{{ $attendance->notes ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('attendances.show', $attendance->id) }}"
                                                        class="btn btn-sm btn-info me-1" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('attendances.edit', $attendance->id) }}"
                                                        class="btn btn-sm btn-primary me-1" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('attendances.destroy', $attendance->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data absensi ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-3">Belum ada data absensi</td>
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

@extends('layouts.app')

@section('title', 'Manajemen Absensi')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold text-dark">📋 Manajemen Absensi</h1>
                    <p class="text-muted">Kelola data absensi karyawan dengan mudah dan cepat.</p>
                </div>
                <a href="{{ route('attendances.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Absensi
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 hover-effect">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-semibold text-primary">🗂️ Daftar Absensi</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover table-bordered">
                                <thead class="table-light">
                                    <tr class="text-nowrap text-center">
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
                                            <td class="text-center">{{ $attendances->firstItem() + $key }}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($attendance->employee->user->name) }}&background=random"
                                                        class="rounded-circle me-2" width="32" height="32" alt="Avatar">
                                                    <div>{{ $attendance->employee->user->name }}</div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '-' }}</td>
                                            <td class="text-center">{{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '-' }}</td>
                                            <td class="text-center">
                                                @php
                                                    $badge = [
                                                        'hadir' => 'success',
                                                        'izin' => 'info',
                                                        'sakit' => 'warning',
                                                        'cuti' => 'primary',
                                                        'alpha' => 'danger',
                                                    ][$attendance->status];
                                                @endphp
                                                <span class="badge bg-{{ $badge }} text-capitalize">{{ $attendance->status }}</span>
                                            </td>
                                            <td>{{ $attendance->notes ?? '-' }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="{{ route('attendances.show', $attendance->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('attendances.edit', $attendance->id) }}"
                                                        class="btn btn-sm btn-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('attendances.destroy', $attendance->id) }}"
                                                        method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data absensi ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">Tidak ada data absensi.</td>
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

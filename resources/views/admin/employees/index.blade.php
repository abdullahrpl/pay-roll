@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">Manajemen Karyawan</h1>
                <p class="text-gray-600">Kelola dan pantau seluruh data karyawan perusahaan Anda.</p>
            </div>
            <div class="flex space-x-2">
                {{-- Contoh tombol export (placeholder) --}}
                <button class="p-2 bg-white border rounded-md text-gray-700 hover:bg-gray-50" title="Export">
                    <i class="fas fa-download"></i>
                </button>
                <a href="{{ route('employees.create') }}"
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 flex items-center shadow">
                    <i class="fas fa-user-plus mr-2"></i> Tambah Karyawan
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-lg font-medium text-primary-600">Daftar Karyawan</h2>
            </div>

            {{-- Search & Filter (dummy, bisa dikembangkan) --}}
            <div class="p-4 border-b flex flex-wrap items-center gap-4">
                <div class="relative flex-1 min-w-[200px]">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input type="search" placeholder="Cari karyawan..."
                        class="w-full pl-10 pr-4 py-2 border rounded-md focus:ring-primary-600 focus:border-primary-600">
                </div>
                <div class="flex items-center gap-2">
                    <select class="p-2 border rounded-md focus:ring-primary-600 focus:border-primary-600">
                        <option value="">Semua Departemen</option>
                        <option value="engineering">Engineering</option>
                        <option value="marketing">Marketing</option>
                        <option value="hr">Human Resources</option>
                        <option value="finance">Finance</option>
                    </select>
                    <button class="p-2 bg-white border rounded-md text-gray-700 hover:bg-gray-50" title="Filter">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left table-auto">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">NIP</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Jabatan</th>
                            <th class="px-6 py-3">Departemen</th>
                            <th class="px-6 py-3">Gaji Pokok</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($employees as $key => $employee)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 align-middle">{{ $employees->firstItem() + $key }}</td>
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->user->name) }}&background=random"
                                            alt="Avatar" class="rounded-full w-9 h-9 mr-3 object-cover" />
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $employee->user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-middle">{{ $employee->nip }}</td>
                                <td class="px-6 py-4 align-middle text-gray-600 text-sm">{{ $employee->user->email }}</td>
                                <td class="px-6 py-4 align-middle">{{ $employee->position }}</td>
                                <td class="px-6 py-4 align-middle">{{ $employee->department }}</td>
                                <td class="px-6 py-4 align-middle">Rp
                                    {{ number_format($employee->basic_salary, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 align-middle text-center text-sm space-x-2">
                                    <a href="{{ route('employees.show', $employee->id) }}"
                                        class="text-primary-600 hover:text-primary-900" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('employees.edit', $employee->id) }}"
                                        class="text-primary-600 hover:text-primary-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-gray-400 py-6">Belum ada data karyawan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t flex items-center justify-between">
                {{-- <div class="text-sm text-gray-500">
                    Menampilkan {{ $employees->firstItem() ?? 0 }} sampai {{ $employees->lastItem() ?? 0 }} dari
                    {{ $employees->total() }} karyawan
                </div> --}}
                <div>
                    {{ $employees->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </main>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
@endsection

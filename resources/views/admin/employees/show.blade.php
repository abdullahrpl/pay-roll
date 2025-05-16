@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
    <main class="flex-1 overflow-y-auto p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
                <a href="{{ route('employees.index') }}"
                    class="p-2 bg-white border rounded-md text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold">Detail Karyawan</h1>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('employees.edit', $employee->id) }}"
                    class="px-4 py-2 bg-white border rounded-md text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        <i class="fas fa-trash-alt mr-2"></i> Hapus
                    </button>
                </form>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="p-6 border-b">
                <div class="flex flex-col md:flex-row md:items-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->user->name) }}&background=random&size=128"
                        alt="Profile" class="h-24 w-24 rounded-full mb-4 md:mb-0 md:mr-6">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $employee->user->name }}</h2>
                        <p class="text-gray-500">{{ $employee->position }} • {{ $employee->department }}</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Aktif</span>
                            <span
                                class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $employee->nip }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <!-- Personal Info -->
                <div>
                    <h3 class="font-medium text-gray-900 mb-4">Informasi Pribadi</h3>
                    <div class="space-y-3">
                        <div class="flex"><span class="text-gray-500 w-32">Nama:</span><span
                                class="font-medium">{{ $employee->user->name }}</span></div>
                        <div class="flex"><span class="text-gray-500 w-32">Email:</span><span
                                class="font-medium">{{ $employee->user->email }}</span></div>
                        <div class="flex"><span class="text-gray-500 w-32">Telepon:</span><span
                                class="font-medium">{{ $employee->phone_number }}</span></div>
                        <div class="flex"><span class="text-gray-500 w-32">Alamat:</span><span
                                class="font-medium">{{ $employee->address }}</span></div>
                    </div>
                </div>

                <!-- Employment Info -->
                <div>
                    <h3 class="font-medium text-gray-900 mb-4">Informasi Pekerjaan</h3>
                    <div class="space-y-3">
                        <div class="flex"><span class="text-gray-500 w-32">NIP:</span><span
                                class="font-medium">{{ $employee->nip }}</span></div>
                        <div class="flex"><span class="text-gray-500 w-32">Jabatan:</span><span
                                class="font-medium">{{ $employee->position }}</span></div>
                        <div class="flex"><span class="text-gray-500 w-32">Departemen:</span><span
                                class="font-medium">{{ $employee->department }}</span></div>
                        <div class="flex"><span class="text-gray-500 w-32">Tgl Gabung:</span><span
                                class="font-medium">{{ $employee->join_date->format('d F Y') }}</span></div>
                        <div class="flex"><span class="text-gray-500 w-32">Gaji Pokok:</span><span class="font-medium">Rp
                                {{ number_format($employee->basic_salary, 0, ',', '.') }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance History -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-lg font-medium">Riwayat Absensi</h2>
                <a href="{{ route('attendances.index') }}?employee_id={{ $employee->id }}"
                    class="text-primary-600 hover:text-primary-900 text-sm">
                    Lihat Semua
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($employee->attendances->sortByDesc('date')->take(5) as $attendance)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap font-medium">
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusMap = [
                                            'hadir' => ['Hadir', 'bg-green-100 text-green-800'],
                                            'izin' => ['Izin', 'bg-blue-100 text-blue-800'],
                                            'sakit' => ['Sakit', 'bg-yellow-100 text-yellow-800'],
                                            'cuti' => ['Cuti', 'bg-purple-100 text-purple-800'],
                                            'alpha' => ['Alpha', 'bg-red-100 text-red-800'],
                                        ];
                                        [$label, $class] = $statusMap[$attendance->status] ?? [
                                            'Tidak Diketahui',
                                            'bg-gray-100 text-gray-800',
                                        ];
                                    @endphp
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }}">
                                        {{ $label }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

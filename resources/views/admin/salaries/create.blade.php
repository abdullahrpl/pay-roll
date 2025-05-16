@extends('layouts.app')

@section('title', 'Tambah Penggajian')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Tambah Penggajian</h1>
            <p class="text-sm text-gray-500">Tambahkan data penggajian karyawan.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-medium text-gray-700 mb-4">Form Tambah Penggajian</h2>

            <form action="{{ route('salaries.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-1">Karyawan</label>
                        <select id="employee_id" name="employee_id"
                            class="w-full py-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('employee_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Karyawan</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->user->name }} - {{ $employee->nip }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                        <select id="month" name="month"
                            class="w-full py-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('month') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Bulan</option>
                            @foreach ($months as $key => $month)
                                <option value="{{ $key }}" {{ old('month') == $key ? 'selected' : '' }}>
                                    {{ $month }}</option>
                            @endforeach
                        </select>
                        @error('month')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <select id="year" name="year"
                            class="w-full py-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('year') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}</option>
                            @endforeach
                        </select>
                        @error('year')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="bonus" class="block text-sm font-medium text-gray-700 mb-1">Bonus (Opsional)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" id="bonus" name="bonus" value="{{ old('bonus') ?? 0 }}" min="0"
                            class="pl-10 py-2 block w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('bonus') border-red-500 @enderror">
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Bonus tambahan di luar gaji pokok</p>
                    @error('bonus')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full py-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-gray-700 space-y-1">
                    <h3 class="font-semibold text-blue-700">Informasi Perhitungan</h3>
                    <p>Sistem akan otomatis menghitung total gaji berdasarkan:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Gaji pokok karyawan terdaftar di sistem</li>
                        <li>Data absensi pada bulan dan tahun yang dipilih</li>
                        <li>Potongan untuk ketidakhadiran (sakit, izin, atau alpha)</li>
                        <li>Bonus tambahan yang diinput</li>
                    </ul>
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <a href="{{ route('salaries.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

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

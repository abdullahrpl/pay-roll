@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 min-h-screen">
        <div class="flex items-center gap-2 mb-6">
            <a href="{{ route('employees.index') }}"
                class="p-2 bg-white border rounded-md text-gray-700 hover:bg-gray-50 shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Karyawan</h1>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-lg font-medium text-gray-900">Informasi Karyawan</h2>
                <p class="text-sm text-gray-500 mt-1">Isi data lengkap untuk menambahkan karyawan baru.</p>
            </div>

            <form action="{{ route('employees.store') }}" method="POST" novalidate class="p-6 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Personal Information --}}
                    <div class="space-y-6">
                        <h3 class="font-medium text-gray-900">Informasi Pribadi</h3>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-primary-200 focus:outline-none focus:border-primary-500 @error('name') border-red-500 @enderror"
                                required>
                            @error('name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-primary-200 focus:outline-none focus:border-primary-500 @error('email') border-red-500 @enderror"
                                required>
                            @error('email')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-primary-200 focus:outline-none focus:border-primary-500 @error('phone_number') border-red-500 @enderror"
                                required>
                            @error('phone_number')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="join_date" class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                            <input type="date" name="join_date" id="join_date"
                                value="{{ old('join_date') ?? date('Y-m-d') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-primary-200 focus:outline-none focus:border-primary-500" @error('join_date') border-red-500 @enderror"
                                required>
                            @error('join_date')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea name="address" id="address" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-primary-200 focus:outline-none focus:border-primary-500 @error('address') border-red-500 @enderror"
                                required rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Employment Information --}}
                    <div class="space-y-6">
                        <h3 class="font-medium text-gray-900">Informasi Pekerjaan</h3>

                        <div>
                            <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                            <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-primary-200 focus:outline-none focus:border-primary-500 @error('nip') border-red-500 @enderror"
                                required>
                            @error('nip')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700">Departemen</label>
                            <input type="text" name="department" id="department" value="{{ old('department') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-primary-200 focus:outline-none focus:border-primary-500 @error('department') border-red-500 @enderror"
                                required>
                            @error('department')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700">Jabatan</label>
                            <input type="text" name="position" id="position" value="{{ old('position') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-primary-200 focus:outline-none focus:border-primary-500 @error('position') border-red-500 @enderror"
                                required>
                            @error('position')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="basic_salary" class="block text-sm font-medium text-gray-700">Gaji Pokok</label>
                            <input type="number" name="basic_salary" id="basic_salary" value="{{ old('basic_salary') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-primary-200 focus:outline-none focus:border-primary-500 @error('basic_salary') border-red-500 @enderror"
                                required>
                            @error('basic_salary')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password Awal</label>
                            <input type="password" name="password" id="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-primary-200 focus:outline-none focus:border-primary-500 @error('password') border-red-500 @enderror"
                                required>
                            <p class="text-xs text-gray-500 mt-1">Karyawan akan diminta ganti saat login pertama kali</p>
                            @error('password')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('employees.index') }}"
                        class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Tambah Karyawan</button>
                </div>
            </form>
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

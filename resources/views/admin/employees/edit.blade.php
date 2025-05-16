@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<main class="flex-1 overflow-y-auto p-6">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('employees.index') }}" class="p-2 bg-white border rounded-md text-gray-700 hover:bg-gray-50">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold">Edit Karyawan</h1>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-lg font-medium">Informasi Karyawan</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui data karyawan dengan benar</p>
        </div>

        <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="space-y-4">
                    <h3 class="font-medium text-gray-900">Informasi Pribadi</h3>

                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $employee->user->name) }}" required class="w-full p-2 border rounded-md @error('name') border-red-500 @enderror">
                        @error('name') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $employee->user->email) }}" required class="w-full p-2 border rounded-md @error('email') border-red-500 @enderror">
                        @error('email') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $employee->phone_number) }}" required class="w-full p-2 border rounded-md @error('phone_number') border-red-500 @enderror">
                        @error('phone_number') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="address" name="address" rows="3" required class="w-full p-2 border rounded-md @error('address') border-red-500 @enderror">{{ old('address', $employee->address) }}</textarea>
                        @error('address') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input type="password" id="password" name="password" class="w-full p-2 border rounded-md @error('password') border-red-500 @enderror">
                        <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin diubah</p>
                        @error('password') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Employment Information -->
                <div class="space-y-4">
                    <h3 class="font-medium text-gray-900">Informasi Pekerjaan</h3>

                    <div class="space-y-2">
                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip', $employee->nip) }}" required class="w-full p-2 border rounded-md @error('nip') border-red-500 @enderror">
                        @error('nip') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="department" class="block text-sm font-medium text-gray-700">Departemen</label>
                        <input type="text" id="department" name="department" value="{{ old('department', $employee->department) }}" required class="w-full p-2 border rounded-md @error('department') border-red-500 @enderror">
                        @error('department') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="position" class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <input type="text" id="position" name="position" value="{{ old('position', $employee->position) }}" required class="w-full p-2 border rounded-md @error('position') border-red-500 @enderror">
                        @error('position') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="join_date" class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                        <input type="date" id="join_date" name="join_date" value="{{ old('join_date', $employee->join_date->format('Y-m-d')) }}" required class="w-full p-2 border rounded-md @error('join_date') border-red-500 @enderror">
                        @error('join_date') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="basic_salary" class="block text-sm font-medium text-gray-700">Gaji Pokok</label>
                        <input type="number" id="basic_salary" name="basic_salary" value="{{ old('basic_salary', $employee->basic_salary) }}" required class="w-full p-2 border rounded-md @error('basic_salary') border-red-500 @enderror">
                        @error('basic_salary') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('employees.index') }}" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</main>
@endsection

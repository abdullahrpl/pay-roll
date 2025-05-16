@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
    <main class="flex-1 overflow-y-auto p-6">
        <div class="flex items-center gap-2 mb-6">
            <a href="{{ route('attendances.index') }}" class="p-2 bg-white border rounded-md text-gray-700 hover:bg-gray-50">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Edit Absensi</h1>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden w-full">
            <div class="p-6 border-b">
                <h2 class="text-lg font-medium text-primary-600">✏️ Form Edit Absensi</h2>
                <p class="text-sm text-gray-500 mt-1">Edit data absensi karyawan.</p>
            </div>

            <form action="{{ route('attendances.update', $attendance->id) }}" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label for="employee_id" class="block text-sm font-medium text-gray-700">Karyawan</label>
                    <select id="employee_id" name="employee_id" required
                        class="w-full p-2 border rounded-md @error('employee_id') border-red-500 @enderror">
                        <option value="">Pilih Karyawan</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}"
                                {{ (old('employee_id') ?? $attendance->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->user->name }} - {{ $employee->nip }}
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" id="date" name="date" required
                        value="{{ old('date') ?? $attendance->date->format('Y-m-d') }}"
                        class="w-full p-2 border rounded-md @error('date') border-red-500 @enderror" />
                    @error('date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="clock_in" class="block text-sm font-medium text-gray-700">Jam Masuk</label>
                        <input type="time" id="clock_in" name="clock_in"
                            value="{{ old('clock_in') ?? optional($attendance->clock_in)->format('H:i') }}"
                            class="w-full p-2 border rounded-md @error('clock_in') border-red-500 @enderror" />
                        @error('clock_in')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="clock_out" class="block text-sm font-medium text-gray-700">Jam Pulang</label>
                        <input type="time" id="clock_out" name="clock_out"
                            value="{{ old('clock_out') ?? optional($attendance->clock_out)->format('H:i') }}"
                            class="w-full p-2 border rounded-md @error('clock_out') border-red-500 @enderror" />
                        @error('clock_out')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" required
                        class="w-full p-2 border rounded-md @error('status') border-red-500 @enderror">
                        <option value="hadir" {{ (old('status') ?? $attendance->status) == 'hadir' ? 'selected' : '' }}>
                            Hadir</option>
                        <option value="izin" {{ (old('status') ?? $attendance->status) == 'izin' ? 'selected' : '' }}>
                            Izin</option>
                        <option value="sakit" {{ (old('status') ?? $attendance->status) == 'sakit' ? 'selected' : '' }}>
                            Sakit</option>
                        <option value="cuti" {{ (old('status') ?? $attendance->status) == 'cuti' ? 'selected' : '' }}>
                            Cuti</option>
                        <option value="alpha" {{ (old('status') ?? $attendance->status) == 'alpha' ? 'selected' : '' }}>
                            Alpha</option>
                    </select>
                    @error('status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full p-2 border rounded-md @error('notes') border-red-500 @enderror">{{ old('notes') ?? $attendance->notes }}</textarea>
                    @error('notes')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6 bg-gray-50 border-t flex justify-end gap-2">
                    <a href="{{ route('attendances.index') }}"
                        class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                        Update
                    </button>
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

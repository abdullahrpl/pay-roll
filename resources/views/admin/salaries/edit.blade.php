@extends('layouts.app')

@section('title', 'Edit Penggajian')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Edit Penggajian</h1>
            <p class="text-sm text-gray-500">Edit data penggajian karyawan.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-medium text-gray-700 mb-6">Form Edit Penggajian</h2>

            <form action="{{ route('salaries.update', $salary->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4 shadow-inner">
                        <h3 class="font-semibold text-gray-700 mb-3">Informasi Karyawan</h3>
                        <p class="text-gray-700 mb-1"><strong>Nama:</strong> {{ $salary->employee->user->name }}</p>
                        <p class="text-gray-700 mb-1"><strong>NIP:</strong> {{ $salary->employee->nip }}</p>
                        <p class="text-gray-700"><strong>Periode:</strong> {{ $salary->period }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 shadow-inner">
                        <h3 class="font-semibold text-gray-700 mb-3">Informasi Gaji</h3>
                        <p class="text-gray-700 mb-1"><strong>Gaji Pokok:</strong> Rp
                            {{ number_format($salary->basic_salary, 0, ',', '.') }}</p>
                        <p class="text-gray-700 mb-1"><strong>Kehadiran:</strong> {{ $salary->attendance_count }} hari</p>
                        <p class="text-gray-700"><strong>Ketidakhadiran:</strong> {{ $salary->absence_count }} hari</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 shadow-inner">
                        <h3 class="font-semibold text-gray-700 mb-3">Potongan & Total</h3>
                        <p class="text-gray-700 mb-1"><strong>Potongan:</strong> Rp
                            {{ number_format($salary->deduction, 0, ',', '.') }}</p>
                        <p class="text-gray-700 mb-1"><strong>Total Sekarang:</strong> {{ $salary->formatted_total_salary }}
                        </p>
                        <p class="text-gray-700">
                            <strong>Status:</strong>
                            @if ($salary->is_paid)
                                <span
                                    class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Dibayar</span>
                            @else
                                <span
                                    class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">Belum
                                    Dibayar</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div>
                    <label for="bonus" class="block text-sm font-medium text-gray-700 mb-1">Bonus</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" id="bonus" name="bonus" min="0"
                            value="{{ old('bonus') ?? $salary->bonus }}"
                            class="pl-10 py-2 block w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('bonus') border-red-500 @enderror">
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Bonus tambahan di luar gaji pokok</p>
                    @error('bonus')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full py-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @enderror">{{ old('notes') ?? $salary->notes }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-3">
                    <input id="is_paid" name="is_paid" type="checkbox" value="1"
                        class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('is_paid') ?? $salary->is_paid ? 'checked' : '' }}>
                    <label for="is_paid" class="text-sm text-gray-700 font-medium">Tandai sebagai Dibayar</label>
                </div>
                <p class="text-sm text-gray-500 mb-6">Jika dicentang, sistem akan menandai gaji ini sebagai sudah
                    dibayar dengan tanggal pembayaran saat ini.</p>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-gray-700">
                    <h3 class="font-semibold text-blue-700 mb-1">Informasi Perhitungan</h3>
                    <p>Sistem akan otomatis menghitung ulang total gaji jika Anda mengubah nilai bonus.</p>
                </div>

                <div class="flex justify-end gap-2 pt-6">
                    <a href="{{ route('salaries.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

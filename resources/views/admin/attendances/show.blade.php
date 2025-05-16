@extends('layouts.app')

@section('title', 'Detail Absensi')

@section('content')
    <main class="flex-1 overflow-y-auto p-6">
        <div class="flex items-center gap-2 mb-6">
            <a href="{{ route('attendances.index') }}" class="p-2 bg-white border rounded-md text-gray-700 hover:bg-gray-50">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold">Attendance Details</h1>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden max-w-3xl mx-auto">
            <div class="p-6 border-b">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-lg font-medium">{{ \Carbon\Carbon::parse($attendance->date)->format('F d, Y') }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::parse($attendance->date)->format('l') }}
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        @php
                            $statusClasses = [
                                'hadir' => 'bg-green-100 text-green-800',
                                'izin' => 'bg-blue-100 text-blue-800',
                                'sakit' => 'bg-yellow-100 text-yellow-800',
                                'cuti' => 'bg-purple-100 text-purple-800',
                                'alpha' => 'bg-red-100 text-red-800',
                            ];
                            $statusLabel = ucfirst($attendance->status);
                        @endphp
                        <span
                            class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClasses[$attendance->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Clock In/Out Times -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 border rounded-md bg-gray-50">
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-4">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Clock In</p>
                                <p class="text-lg font-medium">
                                    {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border rounded-md bg-gray-50">
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 mr-4">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Clock Out</p>
                                <p class="text-lg font-medium">
                                    {{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('h:i A') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Working Hours -->
                <div class="p-4 border rounded-md">
                    <div class="flex items-center mb-4">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Working Hours</p>
                            <p class="text-lg font-medium">
                                {{ $attendance->clock_in && $attendance->clock_out ? $attendance->getDurationAttribute() . ' hours' : '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 100%"></div>
                    </div>
                    <div class="flex justify-between mt-2 text-xs text-gray-500">
                        <span>0h</span>
                        <span>Required: 8h</span>
                        <span>12h</span>
                    </div>
                </div>

                <!-- Location -->
                <div class="p-4 border rounded-md">
                    <h3 class="font-medium mb-2">Location</h3>
                    <div class="flex flex-col space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Clock In Location:</span>
                            <span class="text-sm">{{ $attendance->clock_in_location ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Clock Out Location:</span>
                            <span class="text-sm">{{ $attendance->clock_out_location ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="p-4 border rounded-md">
                    <h3 class="font-medium mb-2">Notes</h3>
                    <p class="text-sm text-gray-600">{{ $attendance->notes ?: 'No notes for this attendance record.' }}</p>
                </div>
            </div>

            <div class="p-6 bg-gray-50 border-t flex justify-end">
                <a href="{{ route('attendances.index') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Back to History
                </a>
            </div>
        </div>
    </main>

@endsection

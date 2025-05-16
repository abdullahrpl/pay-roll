@extends('layouts.app')

@section('title', 'Manajemen Absensi')

@section('content')
    <main class="flex-1 overflow-y-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Attendance Management</h1>
            <div class="flex space-x-2">
                <a href="{{ route('attendances.create') }}"
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add Attendance
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-lg font-medium">Attendance Records</h2>
            </div>

            <!-- Search & Filter -->
            {{-- <div class="p-4 border-b flex flex-wrap items-center gap-4">
                <div class="relative flex-1 min-w-[200px]">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

            </div> --}}

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Clock In</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Clock Out</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($attendances as $attendance)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $attendance->employee->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->clock_in ?? '--' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->clock_out ?? '--' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- @php
                                        $badge = [
                                            'hadir' => 'success',
                                            'izin' => 'info',
                                            'sakit' => 'warning',
                                            'cuti' => 'primary',
                                            'alpha' => 'danger',
                                        ][$attendance->status];
                                    @endphp --}}
                                    <span
                                        class="badge bg-{{ ['hadir' => 'success', 'cuti' => 'primary', 'alpha', 'terlambat' => 'danger'][$attendance->status] ?? 'secondary' }} px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-capitalize">
                                        {{ $attendance->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('attendances.show', $attendance->id) }}"
                                        class="text-primary-600 hover:text-primary-900 mr-3">View</a>
                                    <a href="{{ route('attendances.edit', $attendance->id) }}"
                                        class="text-primary-600 hover:text-primary-900">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t flex flex-wrap items-center justify-between">
                {{-- <div class="text-sm text-gray-500 mr-6">
                    Showing {{ $attendances->firstItem() }} to {{ $attendances->lastItem() }} of
                    {{ $attendances->total() }} entries
                </div> --}}
                <div class="ml-auto">
                    {{ $attendances->onEachSide(1)->links() }}
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

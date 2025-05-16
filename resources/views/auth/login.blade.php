@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="bg-gray-100">
        {{-- <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h1 class="h3 mb-3 fw-normal">Sistem Penggajian Karyawan</h1>
                            <p class="text-muted">Silahkan login untuk melanjutkan</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" required
                                        autocomplete="current-password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3 text-muted">
                    <small>&copy; {{ date('Y') }} Sistem Penggajian Karyawan</small>
                </div>
            </div>
        </div> --}}

        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden w-full max-w-md">
                <div class="p-6 text-center border-b">
                    <h2 class="text-2xl font-bold">Sistem Penggajian Karyawan</h2>
                    <p class="text-gray-500 mt-1">Sign in ke akun anda untuk melanjutkan</p>
                </div>

                <!-- Tabs -->


                <!-- Employee Login Form -->
                <div id="employee-form" class="p-6 space-y-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" placeholder="name@company.com" name="email"
                                    class="w-full p-2 border rounded-md @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                    <a href="#" class="text-xs text-gray-500 hover:text-primary-600">Forgot
                                        password?</a>
                                </div>
                                <input type="password" id="password"
                                    class="w-full p-2 border rounded-md @error('password') is-invalid @enderror"
                                    name="password" equired autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit"
                                class="w-full py-2 px-4 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>

                <div class="p-6 bg-gray-50 border-t text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} Sistem Penggajian Karyawan
                </div>
            </div>
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

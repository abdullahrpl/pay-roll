<div>
    {{-- Sidebar desktop --}}
    <aside class="w-64 bg-white border-r hidden md:block h-screen fixed z-10">
        <nav class="mt-6 px-4">
            @if (auth()->user()->role === 'admin')
                <div id="admin-menu">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Admin</p>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-md mb-1">
                        <i class="fa fa-tachometer mr-3 text-gray-600"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('attendances.index') }}"
                        class="flex items-center px-4 py-2 {{ request()->routeIs('attendances.index') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-md mb-1">
                        <i class="fa fa-clipboard mr-3 text-gray-600"></i>
                        Attendance
                    </a>
                    <a href="{{ route('employees.index') }}"
                        class="flex items-center px-4 py-2 {{ request()->routeIs('employees.index') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-md mb-1">
                        <i class="fa fa-users mr-3 text-gray-600"></i>
                        Employees
                    </a>
                    <a href="{{ route('salaries.index') }}"
                        class="flex items-center px-4 py-2 {{ request()->routeIs('salaries.index') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-md mb-1">
                        <i class="fa fa-money mr-3 text-gray-600"></i>
                        Payroll
                    </a>
                </div>
            @else
                <div id="employee-menu" class="mt-8">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Employee</p>
                    <a href="{{ route('employee.dashboard') }}"
                        class="flex items-center px-4 py-2 rounded-md mb-1 {{ request()->routeIs('employee.dashboard') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fa fa-home mr-3 text-gray-600"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('employee.attendance.history') }}"
                        class="flex items-center px-4 py-2 {{ request()->routeIs('employee.attendance.history') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-md mb-1">
                        <i class="fa fa-calendar mr-3 text-gray-600"></i>
                        My Attendance
                    </a>
                    <a href="{{ route('employee.salary.history') }}"
                        class="flex items-center px-4 py-2 {{ request()->routeIs('employee.salary.history') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-md mb-1">
                        <i class="fa fa-file mr-3 text-gray-600"></i>
                        My Salary
                    </a>
                </div>
            @endif

            <div class="mt-8">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Account</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md mb-1">
                        <i class="fa fa-sign-out mr-3 text-gray-600"></i>
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    {{-- Sidebar responsive --}}
    <div class="md:hidden fixed bottom-0 left-0 right-0 z-20 bg-white border-t flex justify-around p-3 shadow-inner">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center text-center {{ request()->routeIs('admin.dashboard') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">
                <i class="fas fa-tachometer-alt text-xl"></i>
                <p class="text-xs mt-1">Dashboard</p>
            </a>
            <a href="{{ route('attendances.index') }}" class="flex flex-col items-center justify-center text-center {{ request()->routeIs('attendances.index') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">
                <i class="fas fa-clock text-xl"></i>
                <p class="text-xs mt-1">Attendance</p>
            </a>
            <a href="{{ route('employees.index') }}" class="flex flex-col items-center justify-center text-center {{ request()->routeIs('employees.index') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">
                <i class="fas fa-users text-xl"></i>
                <p class="text-xs mt-1">Employees</p>
            </a>
            <a href="{{ route('salaries.index') }}" class="flex flex-col items-center justify-center text-center {{ request()->routeIs('salaries.index') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">
                <i class="fas fa-money-bill-wave text-xl"></i>
                <p class="text-xs mt-1">Payroll</p>
            </a>
        @else
            <a href="{{ route('employee.dashboard') }}" class="flex flex-col items-center justify-center text-center {{ request()->routeIs('employee.dashboard') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">
                <i class="fas fa-home text-xl"></i>
                <p class="text-xs mt-1">Dashboard</p>
            </a>
            <a href="{{ route('employee.attendance.history') }}" class="flex flex-col items-center justify-center text-center {{ request()->routeIs('employee.attendance.history') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">
                <i class="fas fa-calendar text-xl"></i>
                <p class="text-xs mt-1">My Attendance</p>
            </a>
            <a href="{{ route('employee.salary.history') }}" class="flex flex-col items-center justify-center text-center {{ request()->routeIs('employee.salary.history') ? 'text-primary-600' : 'text-gray-600 hover:text-primary-600' }}">
                <i class="fas fa-file text-xl"></i>
                <p class="text-xs mt-1">My Salary</p>
            </a>
        @endif
    </div>
</div>

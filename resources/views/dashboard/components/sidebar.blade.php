<aside id="logo-sidebar" class="fixed top-0 left-0 z-30 w-64 h-screen pt-20 transition-transform -translate-x-full border-r border-gray-200 sm:translate-x-0 bg-[#A4C4B5]" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-[#A4C4B5]">
        <ul class="space-y-2 font-medium">
            <li>
                <h1 class="font-extrabold text-xl px-2">Urusan Sumber Daya, Keuangan</h1>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg {{ Route::is('dashboard') ? 'bg-gray-100' : 'hover:bg-gray-100 group' }}">
                    <img src="{{ asset('assets/icon/home.svg') }}" class="w-[30px]">
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->role == 0 || Auth::user()->role == 1)
                <li>
                    <a href="{{ route('dashboard.user') }}" class="flex items-center p-2 text-gray-900 rounded-lg {{ Route::is('dashboard.user*') ? 'bg-gray-100' : 'hover:bg-gray-100 group' }}">
                        <img src="{{ asset('assets/icon/group.svg') }}" class="w-[30px]">
                        <span class="flex-1 ms-3 whitespace-nowrap">User</span>
                    </a>
                </li>
            @endif

            @php
                $isDropdownActive = Route::is('dashboard.document*') || Route::is('dashboard.programs*') || Route::is('dashboard.chart*') || Route::is('dashboard.timeline*');
            @endphp

            <li>
                <button onclick="toggleDropdown()" class="w-full text-left flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group focus:outline-none">
                    <img src="{{ asset('assets/icon/tm.svg') }}" class="w-[30px]">
                    <span class="flex-1 ms-3 whitespace-nowrap">Sumber Daya</span>
                    <svg id="dropdown-icon" class="w-4 h-4 ms-auto transition-transform {{ $isDropdownActive ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-menu" class="space-y-2 ms-8 {{ $isDropdownActive ? '' : 'hidden' }}">
                    <li>
                        <a href="{{ route('dashboard.document') }}" class="flex items-center p-2 text-gray-900 rounded-lg {{ Route::is('dashboard.document*') ? 'bg-gray-100' : 'hover:bg-gray-100 group' }}">
                            <span>Dokumen</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.programs') }}" class="flex items-center p-2 text-gray-900 rounded-lg {{ Route::is('dashboard.programs*') ? 'bg-gray-100' : 'hover:bg-gray-100 group' }}">
                            <span>Program</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.chart') }}" class="flex items-center p-2 text-gray-900 rounded-lg {{ Route::is('dashboard.chart*') ? 'bg-gray-100' : 'hover:bg-gray-100 group' }}">
                            <span>Gantt Chart</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.timeline') }}" class="flex items-center p-2 text-gray-900 rounded-lg {{ Route::is('dashboard.timeline*') ? 'bg-gray-100' : 'hover:bg-gray-100 group' }} group">
                            <span>Timeline</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>

<script>
    function toggleDropdown() {
        const menu = document.getElementById('dropdown-menu');
        const icon = document.getElementById('dropdown-icon');
        menu.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }
</script>

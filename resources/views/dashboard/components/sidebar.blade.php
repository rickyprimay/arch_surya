<aside id="logo-sidebar" class="fixed top-0 left-0 z-30 w-64 h-screen pt-20 transition-transform -translate-x-full border-r border-gray-200 sm:translate-x-0 bg-[#A4C4B5]" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-[#A4C4B5]">
        <ul class="space-y-2 font-medium">
            <li>
                <h1 class="font-extrabold text-xl px-2">Urusan Sumber Daya, Keuangan</h1>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <img src="{{ asset('assets/icon/home.svg') }}" class="w-[30px]">
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->role == 0 || Auth::user()->role == 1)
                <li>
                    <a href="{{ route('dashboard.user') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <img src="{{ asset('assets/icon/group.svg') }}" class="w-[30px]">
                        <span class="flex-1 ms-3 whitespace-nowrap">User</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <img src="{{ asset('assets/icon/tm.svg') }}" class="w-[30px]">
                    <span class="flex-1 ms-3 whitespace-nowrap">Sumber Daya</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<nav class="fixed top-0 z-40 w-full bg-[#7EC299] border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <a href="#" class="flex ms-2 md:me-24">
                    <img src="{{ asset('assets/logo/logo-fri.png') }}" class="h-10 me-3" alt="Logo" />
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2 bg-white p-2 rounded-lg">
                        <img src="{{ asset('assets/icon/user.svg') }}" class="w-[20px]"> 
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" type="button" class="flex items-center space-x-2 bg-white p-2 rounded-lg cursor-pointer">
                        <img src="{{ asset('assets/icon/logout.svg') }}" class="w-[20px]"> 
                        <span>Logout</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>

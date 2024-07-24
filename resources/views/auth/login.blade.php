<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surya Arch</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="bg-[#ffffff] flex justify-center items-center h-screen">
        <div class="relative h-screen hidden lg:block" style="width: 100%">
            <img src="{{ asset('assets/img/water.png') }}" alt="Image Water" class="object-cover w-full h-full" />
            <div class="absolute top-0 left-0 w-full h-full flex justify-center items-center">
                <img src="{{ asset('assets/logo/logo-fri.png') }}" alt="Logo Fakultas" class="w-3/4" />
            </div>
        </div>
        <div class="bg-[#A4C4B5] lg:p-24 md:p-52 sm:20 p-8 w-full h-full lg:w-1/2">
            <div class="flex justify-center lg:hidden mb-4">
                <img src="{{ asset('assets/logo/logo-fri.png') }}" alt="Logo Fakultas" class="w-3/4" />
            </div>
            <div class="flex flex-col items-center mb-8">
                <h1 class="text-2xl font-semibold text-white">Selamat Datang!</h1>
            </div>
            @if ($errors->any())
                <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Danger</span>
                    <div>
                        @foreach ($errors->all() as $error)
                            <span class="font-medium">{{ $error }}</span><br>
                        @endforeach
                    </div>
                </div>
            @endif
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="text-white mb-1 flex flex-start">Email</label>
                    <input type="text" id="email" name="email"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                        autocomplete="off" placeholder="email@example.com" required />
                </div>
                <div class="mb-4">
                    <label for="password" class="text-white mb-1 flex flex-start">Password</label>
                    <div class="relative w-full">
                        <input id="password" name="password" type="password"
                            class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                            autocomplete="off" placeholder="*******" required />
                    </div>
                </div>
                <button type="submit"
                    class="bg-white text-black font-semibold rounded-md py-2 px-4 w-full">Login</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
</body>

</html>

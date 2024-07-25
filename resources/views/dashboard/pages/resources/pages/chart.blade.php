@extends('dashboard.layouts.app')

@section('content')
<button data-modal-target="create-modal" data-modal-toggle="create-modal" class="flex items-center text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 4v16m-8-8h16"></path>
    </svg>
    Tambah Agenda
</button>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4 border border-black">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th rowspan="2" class="px-4 py-2 border border-gray-300">No</th>
                <th rowspan="2" class="px-4 py-2 border border-gray-300">Agenda</th>
                <th rowspan="2" class="px-4 py-2 border border-gray-300">Dibuat oleh</th>
                <th rowspan="2" class="px-4 py-2 border border-gray-300">Kota</th>
                <th rowspan="2" class="px-4 py-2 border border-gray-300">Durasi (Hari)</th>
                <th rowspan="2" class="px-4 py-2 border border-gray-300">A/R</th>
                @if (!empty($agendas))
                <th colspan="30" class="relative px-4 py-2 border border-gray-300 bg-gray-200">
                    <button id="dropdownButton" class="w-full text-left">
                        <span>Pilih Bulan</span>
                        <span class="float-right">&#x25BC;</span>
                    </button>
                    <div id="dropdownMenu" class="hidden absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded shadow-lg z-10">
                        <ul>
                            @foreach($months as $month)
                                <li>
                                    <a href="?month={{ $month }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">{{ $month }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </th>
                @endif
            </tr>
            @if (!empty($agendas))
            <tr>
                @for ($i = 1; $i <= 30; $i++)
                    <th class="px-4 py-2 border border-gray-300">{{ $i }}</th>
                @endfor
            </tr>
            @endif
        </thead>
        <tbody class="border-t border-gray-300">
            @if (empty($agendas))
                <tr>
                    <td colspan="37" class="border border-gray-300 px-4 py-2 text-center">Tidak ada data agenda</td>
                </tr>
            @else
                @foreach ($agendas as $agenda)
                    <tr>
                        <td rowspan="2" class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td rowspan="2" class="border border-gray-300 px-4 py-2 text-nowrap">{{ $agenda->title }}</td>
                        <td rowspan="2" class="border border-gray-300 px-4 py-2">{{ $agenda->created_by }}</td>
                        <td rowspan="2" class="border border-gray-300 px-4 py-2">{{ $agenda->city->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $agenda->duration_a }}</td>
                        <td class="border border-gray-300 px-4 py-2">A</td>
                        @for ($i = 1; $i <= 30; $i++)
                            @php
                                $date = date('Y-m-d', strtotime("2024-07-" . str_pad($i, 2, '0', STR_PAD_LEFT)));
                            @endphp
                            <td class="border border-gray-300 px-4 py-2 
                                @if($date >= $agenda->start_dt_a && $date <= $agenda->end_dt_a) bg-red-500 
                                @endif">
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $agenda->duration_r }}</td>
                        <td class="border border-gray-300 px-4 py-2">R</td>
                        @for ($i = 1; $i <= 30; $i++)
                            @php
                                $date = date('Y-m-d', strtotime("2024-07-" . str_pad($i, 2, '0', STR_PAD_LEFT)));
                            @endphp
                            <td class="border border-gray-300 px-4 py-2 
                                @if($date >= $agenda->start_dt_r && $date <= $agenda->end_dt_r) bg-green-500 
                                @endif">
                            </td>
                        @endfor
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    
    
</div>

<!-- Modal create agenda -->
<div id="create-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                <h3 class="text-lg font-semibold text-gray-900">
                    Tambah agenda baru
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="create-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" method="POST" action="{{ route('dashboard.chart.store') }}">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Nama Agenda</label>
                        <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Nama Agenda" required>
                    </div>
                    
                    <!-- Date Range Picker for A -->
                    <div id="date-range-picker-a" date-rangepicker class="flex flex-col col-span-2 mb-2">
                        <label for="start_dt_a" class="block text-sm font-medium text-gray-900 mb-2">Tanggal Mulai dan Selesai (A)</label>
                        <div class="flex gap-4 mb-2">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input id="datepicker-range-start-a" name="start_dt_a" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
                            </div>
                            <span class="flex items-center text-gray-500">to</span>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input id="datepicker-range-end-a" name="end_dt_a" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
                            </div>
                        </div>
                    </div>     

                    <!-- Date Range Picker for R -->
                    <div id="date-range-picker-r" date-rangepicker class="flex flex-col col-span-2 mb-2">
                        <label for="start_dt_r" class="block text-sm font-medium text-gray-900 mb-2">Tanggal Mulai dan Selesai (R)</label>
                        <div class="flex gap-4 mb-2">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input id="datepicker-range-start-r" name="start_dt_r" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
                            </div>
                            <span class="flex items-center text-gray-500">to</span>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input id="datepicker-range-end-r" name="end_dt_r" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
                            </div>
                        </div>
                    </div>      

                    <div class="col-span-2">
                        <label for="duration_a" class="block mb-2 text-sm font-medium text-gray-900">Durasi (Hari) (A)</label>
                        <input type="number" name="duration_a" id="duration_a" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Durasi Agenda" required>
                    </div>
            
                    <div class="col-span-2">
                        <label for="duration_r" class="block mb-2 text-sm font-medium text-gray-900">Durasi (Hari) (R)</label>
                        <input type="number" name="duration_r" id="duration_r" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Durasi Agenda" required>
                    </div>
            
                    <div class="col-span-2">
                        <label for="city_id" class="block mb-2 text-sm font-medium text-gray-900">Kota</label>
                        <select name="city_id" id="city_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                            <option value="">Pilih Kota</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="col-span-2">
                        <label for="program_id" class="block mb-2 text-sm font-medium text-gray-900">Program</label>
                        <select name="program_id" id="program_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                            <option value="">Pilih Program</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    Tambah Agenda
                </button>
            </form>
            
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#datepicker-range-start-a", {
        dateFormat: "Y-m-d"
    });
    flatpickr("#datepicker-range-end-a", {
        dateFormat: "Y-m-d"
    });
    flatpickr("#datepicker-range-start-r", {
        dateFormat: "Y-m-d"
    });
    flatpickr("#datepicker-range-end-r", {
        dateFormat: "Y-m-d"
    });
});
document.addEventListener('DOMContentLoaded', function() {
        // Ambil elemen dropdown dan menu
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        // Fungsi untuk toggle menu dropdown
        function toggleDropdown() {
            if (dropdownMenu.classList.contains('hidden')) {
                dropdownMenu.classList.remove('hidden');
            } else {
                dropdownMenu.classList.add('hidden');
            }
        }

        // Event listener untuk button dropdown
        dropdownButton.addEventListener('click', toggleDropdown);

        // Event listener untuk klik di luar dropdown untuk menutupnya
        document.addEventListener('click', function(event) {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
</script>
@endsection

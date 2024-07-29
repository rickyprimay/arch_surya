@extends('dashboard.layouts.app')

@section('content')
    <div class="p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="font-bold text-2xl">Chart</h1>
            <p class="text-gray-400">Surya Arch / Sumber Daya / Chart</p>
        </div>
        <div class="flex justify-end space-x-4 mb-4">
            <form id="filterForm" action="{{ route('dashboard.chart') }}" method="GET" class="flex space-x-4">
                <div>
                    <label for="city_id" class="block mb-2 text-sm font-medium text-gray-900">Kota</label>
                    <select id="city_id" name="city_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                        <option value="">Semua Kota</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="program_id" class="block mb-2 text-sm font-medium text-gray-900">Program</label>
                    <select id="program_id" name="program_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                        <option value="">Semua Program</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}"
                                {{ request('program_id') == $program->id ? 'selected' : '' }}>
                                {{ $program->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="year" class="block mb-2 text-sm font-medium text-gray-900">Tahun</label>
                    <select id="year" name="year"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                        <option value="">Pilih Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="month" class="block mb-2 text-sm font-medium text-gray-900">Bulan</label>
                    <select id="month" name="month"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                        <option value="">Pilih Bulan</option>
                        @foreach ($months as $month)
                            <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">Filter</button>
                </div>
            </form>
        </div>
        <button data-modal-target="create-modal" data-modal-toggle="create-modal"
            class="flex items-center text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
            type="button">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M12 4v16m-8-8h16"></path>
            </svg>
            Tambah Agenda
        </button>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4 border border-black">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th rowspan="2" class="px-4 py-2 border sticky left-0 bg-gray-50 border-gray-300 z-10">No</th>
                        <th rowspan="2" class="px-4 py-2 border sticky left-12 bg-gray-50 border-gray-300 z-10">Agenda
                        </th>
                        <th rowspan="2" class="px-4 py-2 border border-gray-300">Dibuat oleh</th>
                        <th rowspan="2" class="px-4 py-2 border border-gray-300">Kota</th>
                        <th rowspan="2" class="px-4 py-2 border border-gray-300">Durasi (Hari)</th>
                        <th rowspan="2" class="px-4 py-2 border border-gray-300">R/A</th>
                        <th rowspan="2" class="px-4 py-2 border border-gray-300">Aksi</th>
                        @if ($agendas->isNotEmpty())
                            <th colspan="{{ $daysInMonth }}" class="px-4 py-2 border border-gray-300 bg-gray-200 z-0">
                                <button id="dropdownButton" type="button" class="w-full text-left focus:outline-none">
                                    <span>{{ DateTime::createFromFormat('!m', $selectedMonth)->format('F') }}
                                        {{ $selectedYear }}</span>
                                </button>
                            </th>
                        @endif
                    </tr>
                    @if ($agendas->isNotEmpty())
                        <tr>
                            @for ($i = 1; $i <= $daysInMonth; $i++)
                                <th class="px-4 py-2 border border-gray-300">{{ $i }}</th>
                            @endfor
                        </tr>
                    @endif
                </thead>
                <tbody class="border-t border-gray-300">
                    @if ($agendas->isEmpty())
                        <tr>
                            <td colspan="37" class="border border-gray-300 px-4 py-2 text-center">Tidak ada data agenda
                            </td>
                        </tr>
                    @else
                        @foreach ($agendas as $agenda)
                            <tr>
                                <td rowspan="2" class="border border-gray-300 px-4 py-2 sticky left-0 bg-white z-10">
                                    {{ $loop->iteration }}</td>
                                <td rowspan="2" class="border border-gray-300 px-4 py-2 sticky left-12 bg-white z-10">
                                    {{ $agenda->title }}</td>
                                <td rowspan="2" class="border border-gray-300 px-4 py-2">{{ $agenda->created_by }}</td>
                                <td rowspan="2" class="border border-gray-300 px-4 py-2">{{ $agenda->city->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $agenda->duration_r }}</td>
                                <td class="border border-gray-300 px-4 py-2">R</td>
                                <td rowspan="2" class="border border-gray-300 px-4 py-2 text-nowrap"><button data-modal-target="edit-modal-{{ $agenda->id }}"
                                    data-modal-toggle="edit-modal-{{ $agenda->id }}" type="button"
                                    class="text-white bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Edit</button></td>
                                @for ($i = 1; $i <= $daysInMonth; $i++)
                                    @php
                                        $date = date(
                                            'Y-m-d',
                                            strtotime(
                                                ($selectedYear ?? date('Y')) .
                                                    '-' .
                                                    str_pad($selectedMonth ?? date('m'), 2, '0', STR_PAD_LEFT) .
                                                    '-' .
                                                    str_pad($i, 2, '0', STR_PAD_LEFT),
                                            ),
                                        );
                                    @endphp
                                    <td
                                        class="border border-gray-300 px-4 py-2 @if ($date >= $agenda->start_dt_r && $date <= $agenda->end_dt_r) bg-green-500 @endif">
                                    </td>
                                @endfor
                            </tr>
                            <tr>
                                @if ($agenda->end_dt_a != null)
                                    <td class="border border-gray-300 px-4 py-2">{{ $agenda->duration_a }}</td>
                                    <td class="border border-gray-300 px-4 py-2">A</td>
                                @else
                                    <td colspan="2" class="border border-gray-300 px-4 py-2 text-center">
                                        <button data-modal-target="adding-actual-modal-{{ $agenda->id }}"
                                            data-modal-toggle="adding-actual-modal-{{ $agenda->id }}" type="button"
                                            class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Tambah</button>
                                    </td>
                                @endif

                                @for ($i = 1; $i <= $daysInMonth; $i++)
                                    @php
                                        $date = date(
                                            'Y-m-d',
                                            strtotime(
                                                ($selectedYear ?? date('Y')) .
                                                    '-' .
                                                    str_pad($selectedMonth ?? date('m'), 2, '0', STR_PAD_LEFT) .
                                                    '-' .
                                                    str_pad($i, 2, '0', STR_PAD_LEFT),
                                            ),
                                        );
                                    @endphp
                                    <td
                                        class="border border-gray-300 px-4 py-2 @if ($date >= $agenda->start_dt_a && $date <= $agenda->end_dt_a) bg-[#A4C4B5] @endif">
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Log History Section -->
        <div class="mt-4 p-4 bg-white border border-gray-300 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Log History</h2>
            <ul class="space-y-2">
                @foreach ($logAgendas as $logAgenda)
                    <li class="text-sm text-gray-700">
                        <span class="font-semibold">{{ $loop->iteration }}.)</span>
                        <span class="font-semibold">{{ $logAgenda->name }}</span>
                        @if ($logAgenda->status == 0)
                            menambahkan Rencana pada Agenda
                        @elseif($logAgenda->status == 1)
                            menambahkan Actual pada Agenda
                        @elseif($logAgenda->status == 2)
                            mengedit data pada Agenda
                        @elseif($logAgenda->status == 3)
                            menghapus data pada Agenda
                        @else
                            Lain nya
                        @endif
                        <span class="font-semibold">{{ $logAgenda->title }}</span> pada tanggal
                        <span class="font-semibold">{{ $logAgenda->created_at }}</span>
                        <hr>
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- Modal Adding Actual Agenda -->
        @foreach ($agendas as $agenda)
            <div id="adding-actual-modal-{{ $agenda->id }}" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Tambah Actual
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-toggle="adding-actual-modal-{{ $agenda->id }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form class="p-4 md:p-5" method="POST"
                            action="{{ route('dashboard.chart.updateActual', $agenda->id) }}">
                            @csrf
                            @method('put')
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <!-- Date Range Picker for A -->
                                <div id="date-range-picker-a" date-rangepicker class="flex flex-col col-span-2 mb-2">
                                    <label for="start_dt_a" class="block text-sm font-medium text-gray-900 mb-2">Tanggal
                                        Mulai
                                        dan Selesai (A)</label>
                                    <div class="flex gap-4 mb-2">
                                        <div class="relative w-full">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 1 1 0-2Z" />
                                                </svg>
                                            </div>
                                            <input id="datepicker-range-start-a" name="start_dt_a" type="text"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 "
                                                placeholder="Select date start" autocomplete="off" value="">
                                        </div>
                                        <span class="flex items-center text-gray-500">to</span>
                                        <div class="relative w-full">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 1 1 0-2Z" />
                                                </svg>
                                            </div>
                                            <input id="datepicker-range-end-a" name="end_dt_a" type="text"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 "
                                                placeholder="Select date end" autocomplete="off" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Modal Edit --}}
        @foreach ($agendas as $agenda)
    <div id="edit-modal-{{ $agenda->id }}" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Edit Agenda
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="edit-modal-{{ $agenda->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" method="POST" action="{{ route('dashboard.chart.update', $agenda->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Nama Agenda</label>
                            <input type="text" name="title" id="title" value="{{ $agenda->title }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Nama Agenda" required>
                        </div>
                        <!-- Date Range Picker for R -->
                        <div id="date-range-picker-r-edit" date-rangepicker class="flex flex-col col-span-2 mb-2">
                            <label for="start_dt_r" class="block text-sm font-medium text-gray-900 mb-2">Tanggal Mulai dan Selesai (R)</label>
                            <div class="flex gap-4 mb-2">
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 1 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="datepicker-range-start-r-edit" name="start_dt_r" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                        placeholder="Select date start" autocomplete="off"
                                        value="{{ \Carbon\Carbon::parse($agenda->start_dt_r)->format('m/d/Y') }}">
                                </div>
                                <span class="flex items-center text-gray-500">to</span>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 1 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="datepicker-range-end-r-edit" name="end_dt_r" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                        placeholder="Select date end" autocomplete="off"
                                        value="{{ \Carbon\Carbon::parse($agenda->end_dt_r)->format('m/d/Y') }}">
                                </div>
                            </div>
                        </div>
                        <!-- Date Range Picker for A -->
                        @if($agenda->start_dt_a != null && $agenda->end_dt_a != null)
                        <div id="date-range-picker-a-edit" date-rangepicker class="flex flex-col col-span-2 mb-2">
                            <label for="start_dt_a" class="block text-sm font-medium text-gray-900 mb-2">Tanggal Mulai dan Selesai (A)</label>
                            <div class="flex gap-4 mb-2">
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 1 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="datepicker-range-start-a-edit" name="start_dt_a" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                        placeholder="Select date start" autocomplete="off"
                                        value="{{ $agenda->start_dt_a ? \Carbon\Carbon::parse($agenda->start_dt_a)->format('m/d/Y') : '' }}">
                                </div>
                                <span class="flex items-center text-gray-500">to</span>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 1 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="datepicker-range-end-a-edit" name="end_dt_a" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                        placeholder="Select date end" autocomplete="off"
                                        value="{{ $agenda->end_dt_a ? \Carbon\Carbon::parse($agenda->end_dt_a)->format('m/d/Y') : '' }}">
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-span-2">
                            <label for="city_id" class="block mb-2 text-sm font-medium text-gray-900">Kota</label>
                            <select name="city_id" id="city_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required>
                                <option value="">Pilih Kota</option>
                                @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ $agenda->city_id == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="program_id" class="block mb-2 text-sm font-medium text-gray-900">Program</label>
                            <select name="program_id" id="program_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required>
                                <option value="">Pilih Program</option>
                                @foreach ($programs as $program)
                                <option value="{{ $program->id }}" {{ $agenda->program_id == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Simpan
                    </button>
                </form>
                <form action="{{ route('dashboard.chart.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
                    </div>
            </div>
        </div>
    </div>
    @endforeach

        <!-- Modal create agenda -->
        <div id="create-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Tambah agenda baru
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-toggle="create-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5" method="POST" action="{{ route('dashboard.chart.store') }}">
                        @csrf
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                    Agenda</label>
                                <input type="text" name="title" id="title"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    placeholder="Nama Agenda" required>
                            </div>

                            <!-- Date Range Picker for R -->
                            <div id="date-range-picker-r" date-rangepicker class="flex flex-col col-span-2 mb-2">
                                <label for="start_dt_r" class="block text-sm font-medium text-gray-900 mb-2">Tanggal Mulai
                                    dan Selesai (R)</label>
                                <div class="flex gap-4 mb-2">
                                    <div class="relative w-full">
                                        <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 1 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input id="datepicker-range-start-r" name="start_dt_r" type="text"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                            placeholder="Select date start" autocomplete="off">
                                    </div>
                                    <span class="flex items-center text-gray-500">to</span>
                                    <div class="relative w-full">
                                        <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 1 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input id="datepicker-range-end-r" name="end_dt_r" type="text"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                            placeholder="Select date end" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-2">
                                <label for="city_id" class="block mb-2 text-sm font-medium text-gray-900">Kota</label>
                                <select name="city_id" id="city_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    required>
                                    <option value="">Pilih Kota</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-2">
                                <label for="program_id"
                                    class="block mb-2 text-sm font-medium text-gray-900">Program</label>
                                <select name="program_id" id="program_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    required>
                                    <option value="">Pilih Program</option>
                                    @foreach ($programs as $program)
                                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit"
                            class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const filterForm = document.getElementById('filterForm');

            function toggleDropdown() {
                dropdownMenu.classList.toggle('hidden');
            }

            dropdownButton.addEventListener('click', function(event) {
                event.stopPropagation();
                toggleDropdown();
            });

            document.addEventListener('click', function(event) {
                if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });

            filterForm.addEventListener('submit', function(event) {
                const year = document.getElementById('year').value;
                const month = document.getElementById('month').value;

                if (month && !year) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Anda harus memilih tahun juga'
                    });
                }
            });
        });
    </script>
@endsection

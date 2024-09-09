@extends('dashboard.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-2xl">Edit Chart</h1>
    </div>
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 mb-6">Edit Chart</h2>

            <form action="{{ route('dashboard.chart.update', $agenda->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Input for Title -->
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Nama Agenda</label>
                        <input type="text" name="title" id="title" value="{{ $agenda->title }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" required>
                    </div>

                    <!-- Sub-agenda Section -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Sub Agenda</label>
                        <div id="input-container">
                            @php
                                $subAgendas = json_decode($agenda->sub, true);
                            @endphp

                            @if ($subAgendas)
                                @foreach ($subAgendas as $subAgenda)
                                    <div class="flex items-center mb-2">
                                        <input id="sub-checkbox" name="sub-checkbox[]" type="checkbox" checked class="h-4 w-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-600 focus:ring-2">
                                        <input type="text" name="sub[]" value="{{ $subAgenda }}" placeholder="Sub Agenda" class="ml-2 border-b-2 border-gray-300 text-gray-900 text-sm focus:outline-none focus:border-blue-500 w-full p-0.5">
                                        <button type="button" class="ml-2 text-red-600 hover:text-gray-900 remove-input">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-1.5 12.5a2 2 0 01-2 1.5H8.5a2 2 0 01-2-1.5L5 7m14 0h-1M5 7H4m10-4h-4m4 0v4m-4 4h8m-8 4h8" />
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" id="add-input" class="mt-2 text-green-600 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.75v14.5m7.25-7.25H4.75" />
                            </svg>
                        </button>
                    </div>

                    <!-- Date Range Picker for R using Flowbite -->
                    <div class="col-span-2">
                        <label for="start_dt_r" class="block text-sm font-medium text-gray-700">Tanggal Mulai dan Selesai (R)</label>
                        <div id="date-range-picker-r" date-rangepicker class="flex items-center">
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input id="datepicker-range-start-r" name="start_dt_r" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date start" value="{{ \Carbon\Carbon::parse($agenda->start_dt_r)->format('m/d/Y') }}" required>
                            </div>
                            <span class="mx-4 text-gray-500">to</span>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input id="datepicker-range-end-r" name="end_dt_r" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date end" value="{{ \Carbon\Carbon::parse($agenda->end_dt_r)->format('m/d/Y') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Date Range Picker for A (if available) -->
                    @if ($agenda->start_dt_a && $agenda->end_dt_a)
                        <div class="col-span-2">
                            <label for="start_dt_a" class="block text-sm font-medium text-gray-700">Tanggal Mulai dan Selesai (A)</label>
                            <div id="date-range-picker-a" date-rangepicker class="flex items-center">
                                <div class="relative">
                                    <input id="datepicker-range-start-a" name="start_dt_a" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date start" value="{{ \Carbon\Carbon::parse($agenda->start_dt_a)->format('m/d/Y') }}">
                                </div>
                                <span class="mx-4 text-gray-500">to</span>
                                <div class="relative">
                                    <input id="datepicker-range-end-a" name="end_dt_a" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date end" value="{{ \Carbon\Carbon::parse($agenda->end_dt_a)->format('m/d/Y') }}">
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Program Selector -->
                    <div class="col-span-2">
                        <label for="program_id" class="block text-sm font-medium text-gray-700">Program</label>
                        <select id="program_id" name="program_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                            <option value="">Pilih Program</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}" {{ $agenda->program_id == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- File Upload Section -->
                    <div class="col-span-2">
                        <label for="file" class="block text-sm font-medium text-gray-700">Dokumen (Opsional)</label>
                        <input type="file" name="file[]" id="file" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" multiple>
                    </div>

                    <!-- Display existing documents if available -->
                    @if (!empty($agenda->document))
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Dokumen yang Diunggah</label>
                            @php
                                $documents = json_decode($agenda->document, true);
                            @endphp
                            @if ($documents && is_array($documents))
                                @foreach ($documents as $document)
                                    <iframe src="{{ asset('storage/' . $document) }}" width="100%" height="200px"></iframe>
                                @endforeach
                            @else
                                <iframe src="{{ asset('storage/' . $agenda->document) }}" width="100%" height="200px"></iframe>
                            @endif
                        </div>
                    @endif

                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex gap-4">
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Chart
                    </button>
                </form>
                <form action="{{ route('dashboard.chart.destroy', $agenda->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Hapus
                    </button>
                </form>
                </div>
        </div>
    </div>
</div>
<script>
    // Menambahkan sub agenda baru
    document.getElementById('add-input').addEventListener('click', function() {
        var container = document.getElementById('input-container');
        
        // Buat elemen baru
        var newInput = document.createElement('div');
        newInput.className = 'flex items-center mb-2';
        newInput.innerHTML = `
            <input id="sub-checkbox" name="sub-checkbox[]" type="checkbox" checked class="h-4 w-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-600 focus:ring-2">
            <input type="text" name="sub[]" placeholder="Sub Agenda" class="ml-2 border-b-2 border-gray-300 text-gray-900 text-sm focus:outline-none focus:border-blue-500 w-full p-0.5">
            <button type="button" class="ml-2 text-red-600 hover:text-gray-900 remove-input">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-1.5 12.5a2 2 0 01-2 1.5H8.5a2 2 0 01-2-1.5L5 7m14 0h-1M5 7H4m10-4h-4m4 0v4m-4 4h8m-8 4h8" />
                </svg>
            </button>
        `;
    
        container.appendChild(newInput);
    
        // Tambahkan event listener untuk tombol hapus pada input yang baru
        newInput.querySelector('.remove-input').addEventListener('click', function() {
            container.removeChild(newInput);
        });
    });
    
    // Menghapus sub agenda yang ada
    document.querySelectorAll('.remove-input').forEach(function(btn) {
        btn.addEventListener('click', function() {
            btn.parentElement.remove();
        });
    });
    </script>
    
@endsection

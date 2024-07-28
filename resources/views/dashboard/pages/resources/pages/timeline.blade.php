@extends('dashboard.layouts.app')

@section('content')
<div class="p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-2xl">Timeline  </h1>
        <p class="text-gray-400">Surya Arch / Sumber Daya / Timeline</p>
    </div>
    <form action="{{ route('dashboard.timeline') }}" method="GET" class="flex justify-end space-x-4 mb-4 items-center">
        <div class="flex items-center space-x-2 mr-auto">
            <span class="inline-block w-6 h-6 rounded-full bg-red-500"></span>
            <p class="text-sm text-left rtl:text-right text-black">Tidak Tepat Waktu</p>
            <span class="inline-block w-6 h-6 rounded-full bg-green-500 ml-4"></span>
            <p class="text-sm text-left rtl:text-right text-black">Tepat Waktu</p>
        </div>
        <div>
            <label for="city_id" class="block mb-2 text-sm font-medium text-gray-900 ">Kota</label>
            <select id="city_id" name="city_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 ">
                <option value="">Semua Kota</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="program_id" class="block mb-2 text-sm font-medium text-gray-900 ">Program</label>
            <select id="program_id" name="program_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 ">
                <option value="">Semua Program</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">Filter</button>
        </div>
    </form>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4 border border-black">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th rowspan="2" class="px-4 py-2 ">No</th>
                    <th rowspan="2" class="px-4 py-2 ">Agenda</th>
                    <th rowspan="2" class="px-4 py-2 ">Dibuat oleh</th>
                    <th rowspan="2" class="px-4 py-2 ">Status</th>
                    <th rowspan="2" class="px-4 py-2 ">Rencana SLA</th>
                    <th rowspan="2" class="px-4 py-2 ">Actual</th>
                    <th rowspan="2" class="px-4 py-2 ">Dibuat Pada</th>
                    <th rowspan="2" class="px-4 py-2 ">Keterangan</th>
                </tr>
            </thead>
            <tbody class="border-t border-gray-300 text-center">
                @if ($agendas->isEmpty())
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center">Tidak ada data agenda</td>
                    </tr>
                @else
                    @foreach ($agendas as $agenda)
                        <tr>
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $agenda->title }}</td>
                            <td class="px-4 py-2 text-nowrap">{{ $agenda->created_by }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center">
                                    @if ($agenda->end_dt_a > $agenda->end_dt_r)
                                        <span class="inline-block w-6 h-6 rounded-full bg-red-500"></span>
                                    @else
                                        <span class="inline-block w-6 h-6 rounded-full bg-green-500"></span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-2 text-nowrap">{{ $agenda->start_dt_r }} - {{ $agenda->end_dt_r }}</td>
                            <td class="px-4 py-2 text-nowrap">{{ $agenda->start_dt_a }} - {{ $agenda->end_dt_a }}</td>
                            <td class="px-4 py-2 text-nowrap">{{ $agenda->created_at }}</td>
                            @if($agenda->information != null)
                            <td class="px-4 py-2">
                                @if(strlen($agenda->information) > 50)
                                    <a href="#" data-modal-target="info-modal-{{ $agenda->id }}" data-modal-toggle="info-modal-{{ $agenda->id }}">
                                        {{ \Illuminate\Support\Str::limit($agenda->information, 50, '...') }}
                                    </a>
                                @else
                                    {{ $agenda->information }}
                                @endif
                            </td>
                            @else
                            <td><button data-modal-target="crud-modal-{{ $agenda->id }}" data-modal-toggle="crud-modal-{{ $agenda->id }}" type="button" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">...</button></td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @foreach ($agendas as $agenda)
        <div id="info-modal-{{ $agenda->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow ">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Keterangan
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="info-modal-{{ $agenda->id }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <p class="text-base leading-relaxed text-gray-500">
                                {{ $agenda->information }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        @endforeach
        <!-- Main modal -->
        @foreach ($agendas as $agenda)
<div id="crud-modal-{{ $agenda->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900 ">
                    Tambah Keterangan
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center " data-modal-toggle="crud-modal-{{ $agenda->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('dashboard.addInformation', ['id' => $agenda->id]) }}" method="POST" class="p-4 md:p-5">
                @csrf
                @method('PUT')
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 ">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="..."></textarea>                    
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Simpan
                </button>
            </form>
        </div>
    </div>
</div> 
@endforeach
    </div>
</div>
@endsection

@extends('dashboard.layouts.app')

@section('content')
<div class="p-4">
    <form action="{{ route('dashboard.timeline') }}" method="GET" class="flex justify-end space-x-4 mb-4">
        <div>
            <label for="city_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kota</label>
            <select id="city_id" name="city_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Semua Kota</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="program_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Program</label>
            <select id="program_id" name="program_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                </tr>
            </thead>
            <tbody class="border-t border-gray-300">
                @if ($agendas->isEmpty())
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center">Tidak ada data agenda</td>
                    </tr>
                @else
                    @foreach ($agendas as $agenda)
                        <tr>
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $agenda->title }}</td>
                            <td class="px-4 py-2">{{ $agenda->created_by }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center">
                                    @if ($agenda->end_dt_a > $agenda->end_dt_r)
                                        <span class="inline-block w-6 h-6 rounded-full bg-red-500"></span>
                                    @else
                                        <span class="inline-block w-6 h-6 rounded-full bg-green-500"></span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-2">{{ $agenda->start_dt_r }} - {{ $agenda->end_dt_r }}</td>
                            <td class="px-4 py-2">{{ $agenda->start_dt_a }} - {{ $agenda->end_dt_a }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

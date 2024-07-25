@extends('dashboard.layouts.app')

@section('content')
<div class="p-4">
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4 border border-black">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th rowspan="2" class="px-4 py-2 ">No</th>
                <th rowspan="2" class="px-4 py-2 ">Agenda</th>
                <th rowspan="2" class="px-4 py-2 ">Dibuat oleh</th>
                <th rowspan="2" class="px-4 py-2 ">Rencana SLA</th>
                <th rowspan="2" class="px-4 py-2 ">Actual</th>
                {{-- <th rowspan="2" class="px-4 py-2 ">Keterangan</th> --}}
            </tr>
        </thead>
        <tbody class="border-t border-gray-300">
            @if ($agendas->isEmpty())
                    <tr>
                        <td colspan="5" class=" px-4 py-2 text-center">Tidak ada data agenda</td>
                    </tr>
                @else
                @foreach ($agendas as $agenda)
                <tr>
                    <td class=" px-4 py-2">{{ $loop->iteration }}</td>
                    <td class=" px-4 py-2">{{ $agenda->title }}</td>
                    <td class=" px-4 py-2">{{ $agenda->created_by }}</td>
                    <td class=" px-4 py-2">{{ $agenda->start_dt_r }}  -  {{ $agenda->end_dt_r }}</td>
                    <td class=" px-4 py-2">{{ $agenda->start_dt_a }}  -  {{ $agenda->end_dt_a }}</td>
                    {{-- <td class=" px-4 py-2">{{ $agenda->detail }}</td> --}}
                </tr>
                @endforeach
                @endif
        </tbody>
    </table>
</div>
</div>
@endsection

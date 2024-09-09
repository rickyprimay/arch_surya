@extends('dashboard.layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-2xl">Dashboard</h1>
        <p class="text-gray-400">Surya Arch / Dashboard</p>
    </div>
    <div class="flex justify-center items-center py-8">
        <img src="{{ asset('assets/logo/logo-fri.png') }}" class="w-[400px]">
    </div>
    <div class="mb-4">
        <form method="GET" action="{{ route('dashboard') }}">
            <select name="year" class="p-2 border rounded" onchange="this.form.submit()">
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>        
        </form>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-[#E3E3E3] text-black p-4 rounded-lg">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold pb-4">{{ $totalActual }}</div>
                    <div class="text-lg">Telah Selesai</div>
                </div>
                <div>
                    <img src="{{ asset('assets/icon/check.svg') }}" alt="Check Icon">
                </div>
            </div>
        </div>
        <div class="bg-[#E3E3E3] text-black p-4 rounded-lg">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold pb-4">{{ $totalPlan }}</div>
                    <div class="text-lg">Dalam Proses</div>
                </div>
                <div>
                    <img src="{{ asset('assets/icon/prog.svg') }}" alt="Progress Icon">
                </div>
            </div>
        </div>
        @if (Auth::user()->role != 3)
        <div class="bg-[#E3E3E3] text-black p-4 rounded-lg">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold pb-4">{{ $totalOnTime }}</div>
                    <div class="text-lg">Tepat Waktu</div>
                </div>
                <div>
                    <img src="{{ asset('assets/icon/clock.svg') }}" class="w-12" alt="On Time Icon">
                </div>
            </div>
        </div>
    
        <div class="bg-[#E3E3E3] text-black p-4 rounded-lg">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold pb-4">{{ $totalLate }}</div>
                    <div class="text-lg">Tidak Tepat Waktu</div>
                </div>
                <div>
                    <img src="{{ asset('assets/icon/late.svg') }}" class="w-12" alt="Late Icon">
                </div>
            </div>
        </div>
        @endif
    </div>
    <br>
    @if (Auth::user()->role == 3)
    <div class="bg-[#E3E3E3] text-black p-4 rounded-lg w-full">
        <div class="flex justify-between items-center">
            <div>
                <div class="text-2xl font-bold pb-4">Agenda akan datang</div>
                <ul class="list-disc pl-5">
                    @forelse ($upcomingAgendas as $agenda)
                        <li>Agenda dari {{ $agenda->created_by }} Yang berjudul {{ $agenda->title }} Jatuh pada {{ $agenda->end_dt_r->format('d M Y') }}</li>
                    @empty
                        <li>Tidak ada agenda yang akan datang.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    @endif
    {{-- @if (Auth::user()->role != 3) --}}
    <div style="width: 100%; margin: auto;" class="pb-96">
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('myChart').getContext('2d');
            const chartData = @json($chartData);

            let myChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Laporan'
                        }
                    }
                }
            });
        });
    </script>
@endsection

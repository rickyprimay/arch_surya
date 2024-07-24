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
        <select id="yearFilter" class="p-2 border rounded">
            <option value="2024">2024</option>
            <option value="2023">2023</option>
        </select>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-[#E3E3E3] text-black p-4 rounded-lg">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold pb-4" id="total-completed">0</div>
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
                    <div class="text-2xl font-bold pb-4" id="total-in-progress">0</div>
                    <div class="text-lg">Dalam Proses</div>
                </div>
                <div>
                    <img src="{{ asset('assets/icon/prog.svg') }}" alt="Progress Icon">
                </div>
            </div>
        </div>
    </div>
    <div style="width: 100%; margin: auto;">
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const yearFilter = document.getElementById('yearFilter');
            const ctx = document.getElementById('myChart').getContext('2d');

            const chartData = {
                2024: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'],
                    datasets: [{
                            label: 'Telah Selesai',
                            data: [1000, 750, 500, 250, 500, 250, 1000, 500, 250, 500, 750, 1000],
                            backgroundColor: 'rgba(75, 0, 130, 0.2)',
                            borderColor: 'rgba(75, 0, 130, 1)',
                            borderWidth: 1,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Dalam Proses',
                            data: [500, 250, 1000, 500, 250, 500, 750, 500, 250, 1000, 500, 750],
                            backgroundColor: 'rgba(192, 192, 192, 0.2)',
                            borderColor: 'rgba(192, 192, 192, 1)',
                            borderWidth: 1,
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                2023: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'],
                    datasets: [{
                            label: 'Telah Selesai',
                            data: [900, 800, 700, 600, 700, 800, 900, 600, 700, 800, 900, 1000],
                            backgroundColor: 'rgba(75, 0, 130, 0.2)',
                            borderColor: 'rgba(75, 0, 130, 1)',
                            borderWidth: 1,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Dalam Proses',
                            data: [400, 350, 300, 450, 400, 300, 250, 450, 400, 300, 250, 450],
                            backgroundColor: 'rgba(192, 192, 192, 0.2)',
                            borderColor: 'rgba(192, 192, 192, 1)',
                            borderWidth: 1,
                            fill: true,
                            tension: 0.4
                        }
                    ]
                }
            };

            let myChart = new Chart(ctx, {
                type: 'line',
                data: chartData[2024],
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

            yearFilter.addEventListener('change', function() {
                const selectedYear = this.value;
                const data = chartData[selectedYear];
                myChart.data.labels = data.labels;
                myChart.data.datasets = data.datasets;
                myChart.update();
            });
        });
    </script>
@endsection

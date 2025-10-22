@extends('admin.layout.main')

@section('title', 'Dashboard')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-slate-50">
        <div class="grid grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col gap-4 w-full">
                <div class="flex justify-between">
                    <div>
                        <h2 class="text-md font-medium text-gray-600 mb-4">Total User</h2>
                        <p class="text-2xl font-semibold text-gray-700">6000</p>
                    </div>
                    <div class="flex justify-center items-center bg-indigo-200 w-16 h-16 rounded-lg">
                        <i class="fa-solid fa-users text-2xl text-indigo-500"></i>
                    </div>
                </div>
                <div class="text-sm text-emerald-500">8.5% Up from yesterday</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col gap-4 w-full">
                <div class="flex justify-between">
                    <div>
                        <h2 class="text-md font-medium text-gray-600 mb-4">Total Order</h2>
                        <p class="text-2xl font-semibold text-gray-700">6000</p>
                    </div>
                    <div class="flex justify-center items-center bg-amber-200 w-16 h-16 rounded-lg">
                        <i class="fa-solid fa-box text-2xl text-amber-500"></i>
                    </div>
                </div>
                <div class="text-sm text-emerald-500">8.5% Up from yesterday</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col gap-4 w-full">
                <div class="flex justify-between">
                    <div>
                        <h2 class="text-md font-medium text-gray-600 mb-4">Total Sales</h2>
                        <p class="text-2xl font-semibold text-gray-700">6000</p>
                    </div>
                    <div class="flex justify-center items-center bg-green-200 w-16 h-16 rounded-lg">
                        <i class="fa-solid fa-chart-simple text-2xl text-green-500"></i>
                    </div>
                </div>
                <div class="text-sm text-emerald-500">8.5% Up from yesterday</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col gap-4 w-full">
                <div class="flex justify-between">
                    <div>
                        <h2 class="text-md font-medium text-gray-600 mb-4">Pending</h2>
                        <p class="text-2xl font-semibold text-gray-700">2040</p>
                    </div >
                    <div class="flex justify-center items-center bg-orange-200 w-16 h-16 rounded-lg">
                        <i class="fa-solid fa-box text-2xl text-orange-500"></i>
                    </div>
                </div>
                <div class="text-sm text-emerald-500">8.5% Up from yesterday</div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-md w-full">
            <h2 class="text-md font-semibold mb-4">Sales</h2>
            <canvas id="salesChart" class="w-full"></canvas>
        </div>

        <div class="w-full flex flex-col gap-4 bg-white p-4 rounded-lg shadow-md">
            <p class="text-lg font-semibold">Running Orders</p>
            <div class="overflow-x-auto rounded-lg">
                <table class="table rounded-lg">
                    <thead>
                        <tr class="bg-[#D5D5D5]">
                            <th>Name</th>
                            <th>Telephone</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Coach</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Christine Brooks</td>
                            <td>083452628563</td>
                            <td>04 Sep 2019</td>
                            <td>16:00-17:00</td>
                            <td>Coach Ferizwan</td>
                            <td>
                                <div class="bg-[#CCF0EB] text-[#00B69B] py-2 px-4 rounded-lg text-center w-fit">
                                    Confirmed
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Christine Brooks</td>
                            <td>083452628563</td>
                            <td>04 Sep 2019</td>
                            <td>16:00-17:00</td>
                            <td>Coach Ferizwan</td>
                            <td>
                                <div class="bg-[#FFEDDD] text-[#FFA756] py-2 px-4 rounded-lg text-center w-fit">On Hold
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Christine Brooks</td>
                            <td>083452628563</td>
                            <td>04 Sep 2019</td>
                            <td>16:00-17:00</td>
                            <td>Coach Ferizwan</td>
                            <td>
                                <div class="bg-[#FCD7D4] text-[#EF3826] py-2 px-4 rounded-lg text-center w-fit">Rejected
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        <script>
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli'],
                    datasets: [{
                        label: 'Total Penjualan (juta rupiah)',
                        data: [12, 19, 15, 25, 22, 30, 28],
                        fill: true,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        tension: 0.3, // membuat garis sedikit melengkung
                        pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Sales',
                            font: {
                                size: 18
                            }
                        },
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Penjualan'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        }
                    }
                }
            });
        </script>
    </section>
@endsection

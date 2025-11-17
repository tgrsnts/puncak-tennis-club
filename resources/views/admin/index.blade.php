@extends('admin.layout.main')

@section('title', 'Dashboard')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-slate-50">
        <div class="grid grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col gap-4 w-full">
                <div class="flex justify-between">
                    <div>
                        <h2 class="text-md font-medium text-gray-600 mb-4">Total User</h2>
                        <p class="text-2xl font-semibold text-gray-700">{{ $totalUsers }}</p>
                    </div>
                    <div class="flex justify-center items-center bg-indigo-200 w-16 h-16 rounded-lg">
                        <i class="fa-solid fa-users text-2xl text-indigo-500"></i>
                    </div>
                </div>
                {{-- <div class="text-sm flex gap-2 items-center">
                    <div class="text-emerald-500 flex gap-2 items-center">
                        <i class="fa-solid fa-arrow-trend-up"></i>8.5%
                    </div>
                    <div class="text-gray-600 "> Up from yesterday</div>
                </div> --}}
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col gap-4 w-full">
                <div class="flex justify-between">
                    <div>
                        <h2 class="text-md font-medium text-gray-600 mb-4">Total Order</h2>
                        <p class="text-2xl font-semibold text-gray-700"> {{ $totalOrders }} </p>
                    </div>
                    <div class="flex justify-center items-center bg-amber-200 w-16 h-16 rounded-lg">
                        <i class="fa-solid fa-box text-2xl text-amber-500"></i>
                    </div>
                </div>
                {{-- <div class="text-sm flex gap-2 items-center">
                    <div class="text-emerald-500 flex gap-2 items-center">
                        <i class="fa-solid fa-arrow-trend-up"></i>8.5%
                    </div>
                    <div class="text-gray-600 "> Up from yesterday</div>
                </div> --}}
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col gap-4 w-full">
                <div class="flex justify-between">
                    <div>
                        <h2 class="text-md font-medium text-gray-600 mb-4">Total Sales</h2>
                        <p class="text-2xl font-semibold text-gray-700">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex justify-center items-center bg-green-200 w-16 h-16 rounded-lg">
                        <i class="fa-solid fa-chart-line text-2xl text-green-500"></i>
                    </div>
                </div>
                {{-- <div class="text-sm flex gap-2 items-center">
                    <div class="text-emerald-500 flex gap-2 items-center">
                        <i class="fa-solid fa-arrow-trend-up"></i>8.5%
                    </div>
                    <div class="text-gray-600 "> Up from yesterday</div>
                </div> --}}
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col gap-4 w-full">
                <div class="flex justify-between">
                    <div>
                        <h2 class="text-md font-medium text-gray-600 mb-4">Pending</h2>
                        <p class="text-2xl font-semibold text-gray-700">{{ $pendingCount }}</p>
                    </div>
                    <div class="flex justify-center items-center bg-orange-200 w-16 h-16 rounded-lg">
                        <i class="fa-solid fa-box text-2xl text-orange-500"></i>
                    </div>
                </div>
                {{-- <div class="text-sm flex gap-2 items-center">
                    <div class="text-emerald-500 flex gap-2 items-center">
                        <i class="fa-solid fa-arrow-trend-up"></i>8.5%
                    </div>
                    <div class="text-gray-600 "> Up from yesterday</div>
                </div> --}}
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
                        @forelse ($runningOrders as $order)
                            @php
                                $status = $order->status;
                                $badge = [
                                    'confirmed' => ['bg' => '#CCF0EB', 'text' => '#00B69B', 'label' => 'Confirmed'],
                                    'pending' => ['bg' => '#FFEDDD', 'text' => '#FFA756', 'label' => 'On Hold'],
                                    'rejected' => ['bg' => '#FCD7D4', 'text' => '#EF3826', 'label' => 'Rejected'],
                                    'challenge' => ['bg' => '#FFF7CC', 'text' => '#D4A300', 'label' => 'Challenge'],
                                ][$status] ?? [
                                    'bg' => '#E5E5E5',
                                    'text' => '#555555',
                                    'label' => ucfirst($status),
                                ];
                            @endphp
                            <tr>
                                <td>{{ $order->user->name ?? $order->guest_name }}</td>
                                <td>{{ $order->user->telepon ?? $order->guest_phone }}</td>
                                <td>{{ optional($order->timetable)->date ? \Carbon\Carbon::parse($order->timetable->date)->format('d M Y') : '-' }}
                                </td>
                                <td>
                                    @if ($order->timetable)
                                        {{ \Carbon\Carbon::parse($order->timetable->start_time)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($order->timetable->end_time)->format('H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ optional($order->timetable->coach ?? null)->name ?? '-' }}</td>
                                <td>
                                    <div class="py-2 px-4 rounded-lg text-center w-fit"
                                        style="background-color: {{ $badge['bg'] }}; color: {{ $badge['text'] }}">
                                        {{ $badge['label'] }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-4">Belum ada running orders.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        <script>
            const salesLabels = @json($salesLabels);
            const salesData = @json($salesData);

            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: salesLabels,
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: salesData,
                        fill: true,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        tension: 0.3,
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

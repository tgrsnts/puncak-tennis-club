@extends('admin.layout.main')

@section('title', 'Timetable')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Timetable</h2>
        <a href="{{ route('admin.timetable.create') }}"
            class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">Add
            New Timetable</a>
        <div class="overflow-x-auto bg-white shadow-xl rounded-lg">
            <table id="tablehewan" class="table rounded-lg row-border w-full">
                <thead>
                    <tr class="bg-[#D5D5D5]">
                        <th>Date</th>
                        <th>Time</th>
                        <th>Coach</th>
                        <th>Level</th>
                        <th>Slot</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        @php
                            $taken = $item->current_slots ?? 0; // pake withCount di controller
                            $max = $item->max_slots;
                            $status = '';

                            if ($taken === 0) {
                                $status = 'available';
                            } elseif ($taken < $max) {
                                $status = 'booked';
                            } else {
                                $status = 'full';
                            }

                            $badge = [
                                'available' => ['bg' => '#CCF0EB', 'text' => '#00B69B', 'label' => 'Available'],
                                'booked' => ['bg' => '#FFEDDD', 'text' => '#FFA756', 'label' => 'Booked'],
                                'full' => ['bg' => '#FCD7D4', 'text' => '#EF3826', 'label' => 'Full Booked'],
                            ][$status];
                        @endphp

                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</td>

                            <td>{{ $item->start_time }} - {{ $item->end_time }}</td>

                            <td>{{ $item->coach->name }}</td>

                            <td>{{ $item->level }}</td>

                            <td>{{ $taken }}/{{ $max }}</td>

                            <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>

                            <td>
                                <div class="py-2 px-4 rounded-lg text-center w-fit"
                                    style="background-color: {{ $badge['bg'] }}; color: {{ $badge['text'] }}">
                                    {{ $badge['label'] }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

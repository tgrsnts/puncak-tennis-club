@extends('admin.layout.main')

@section('title', 'Order')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Order</h2>
        <div class="overflow-x-auto bg-white shadow-xl rounded-lg">
            <table id="tablehewan" class="table rounded-lg row-border w-full">
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
                    @foreach ($data as $o)
                        @php
                            $status = $o->status;

                            $badge = [
                                'confirmed' => ['bg' => '#CCF0EB', 'text' => '#00B69B', 'label' => 'Confirmed'],
                                'pending' => ['bg' => '#FFEDDD', 'text' => '#FFA756', 'label' => 'On Hold'],
                                'rejected' => ['bg' => '#FCD7D4', 'text' => '#EF3826', 'label' => 'Rejected'],
                            ][$status] ?? [
                                'bg' => '#E5E5E5',
                                'text' => '#555',
                                'label' => ucfirst($status),
                            ];
                        @endphp

                        <tr>
                            <td>{{ $o->user->name ?? $o->guest_name }}</td>

                            <td>{{ $o->user->phone ?? $o->guest_phone }}</td>

                            <td>{{ \Carbon\Carbon::parse($o->timetable->date)->format('d M Y') }}</td>

                            <td>
                                {{ $o->timetable->start_time }} - {{ $o->timetable->end_time }}
                            </td>

                            <td>{{ $o->timetable->coach->name }}</td>

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

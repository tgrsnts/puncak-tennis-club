@extends('admin.layout.main')

@section('title', 'Timetable')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Timetable</h2>
        <a href="{{ route('admin.timetable.create') }}"
            class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">Add New Timetable</a>
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
                    <tr>
                        <td>04 Sep 2019</td>
                        <td>16:00-17:00</td>
                        <td>Coach Ferizwan</td>
                        <td>Beginner</td>
                        <td>0/1</td>
                        <td>Rp100.000</td>
                        <td>
                            <div class="bg-[#CCF0EB] text-[#00B69B] py-2 px-4 rounded-lg text-center w-fit">Available</div>
                        </td>
                    </tr>
                    <tr>
                        <td>04 Sep 2019</td>
                        <td>16:00-17:00</td>
                        <td>Coach Ferizwan</td>
                        <td>Beginner</td>
                        <td>0/1</td>
                        <td>Rp100.000</td>
                        <td>
                            <div class="bg-[#FFEDDD] text-[#FFA756] py-2 px-4 rounded-lg text-center w-fit">Booked</div>
                        </td>
                    </tr>
                    <tr>
                        <td>04 Sep 2019</td>
                        <td>16:00-17:00</td>
                        <td>Coach Ferizwan</td>
                        <td>Beginner</td>
                        <td>0/1</td>
                        <td>Rp100.000</td>
                        <td>
                            <div class="bg-[#FCD7D4] text-[#EF3826] py-2 px-4 rounded-lg text-center w-fit">Full Booked
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection

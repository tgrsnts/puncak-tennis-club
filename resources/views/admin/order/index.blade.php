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
                    <tr>
                        <td>Christine Brooks</td>
                        <td>083452628563</td>
                        <td>04 Sep 2019</td>
                        <td>16:00-17:00</td>
                        <td>Coach Ferizwan</td>
                        <td>
                            <div class="bg-[#CCF0EB] text-[#00B69B] py-2 px-4 rounded-lg text-center w-fit">Confirmed</div>
                        </td>
                    </tr>
                    <tr>
                        <td>Christine Brooks</td>
                        <td>083452628563</td>
                        <td>04 Sep 2019</td>
                        <td>16:00-17:00</td>
                        <td>Coach Ferizwan</td>
                        <td>
                            <div class="bg-[#FFEDDD] text-[#FFA756] py-2 px-4 rounded-lg text-center w-fit">On Hold</div>
                        </td>
                    </tr>
                    <tr>
                        <td>Christine Brooks</td>
                        <td>083452628563</td>
                        <td>04 Sep 2019</td>
                        <td>16:00-17:00</td>
                        <td>Coach Ferizwan</td>
                        <td>
                            <div class="bg-[#FCD7D4] text-[#EF3826] py-2 px-4 rounded-lg text-center w-fit">Rejected</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection

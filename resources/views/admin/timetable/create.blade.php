@extends('admin.layout.main')

@section('title', 'Timetable')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Timetable</h2>
        <a href="{{ route('admin.timetable.index') }}"
            class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">Kembali</a>
        <div class="bg-white p-4 rounded-lg border border-gray-200 flex flex-col gap-4">
            <form action="">
                <!-- GRID: 2 kolom, Title span 2 -->
                <div class="grid grid-cols-2 gap-6 items-start">
                    <!-- Row 1: Title (span 2) -->
                    <div class="col-span-2">
                        <label for="date" class="block text-left">Date</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="date" name="date" id="date" />
                    </div>

                    <div class="flex flex-col">
                        <label for="start" class="block text-left">Time Start</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="time" name="start" id="start" />
                    </div>

                    <div class="flex flex-col">
                        <label for="finish" class="block text-left">Time Finish</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="time" name="finish" id="finish" />
                    </div>

                    <div class="col-span-2">
                        <label for="level" class="block text-left">Level</label>
                        <select name="level" id="level" class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermedate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label for="slot" class="block text-left">Slot</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="number" name="slot" id="slot" />
                    </div>

                    <div class="flex flex-col">
                        <label for="max_slot" class="block text-left">Max Slot</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="number" name="max_slot" id="max_slot" />
                    </div>

                    <div class="col-span-2">
                        <label for="price" class="block text-left">Price</label>
                        <input
                            class="w-full p-2 border border-slate-400 focus:outline focus:outline-green-normal rounded-lg"
                            type="number" name="price" id="price" />
                    </div>
                </div>

                <div class="w-full mt-4">
                    <button
                        class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

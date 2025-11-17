@extends('admin.layout.main')

@section('title', 'Timetable')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Timetable</h2>
        <a href="{{ route('admin.timetable.index', app()->getLocale()) }}"
            class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">Kembali</a>
        <div class="bg-white p-4 rounded-lg border border-gray-200 flex flex-col gap-4">
            <form action="{{ route('admin.timetable.store', app()->getLocale()) }}" method="POST" class="flex flex-col gap-4">
                @csrf

                {{-- GLOBAL ERROR MESSAGE --}}
                {{-- @if ($errors->any())
                    <div class="p-4 rounded-lg bg-red-100 border border-red-300 text-red-700 text-sm">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                <div class="grid grid-cols-2 gap-6 items-start">

                    {{-- DATE --}}
                    <div class="col-span-2">
                        <label for="date" class="block">Date</label>
                        <input type="date" name="date" id="date" value="{{ old('date') }}"
                            class="w-full p-2 border border-slate-400 rounded-lg">
                        @error('date')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- TIME START --}}
                    <div class="flex flex-col">
                        <label for="start_time" class="block">Time Start</label>
                        <input type="text" name="start_time" id="start_time" value="{{ old('start_time') }}"
                            class="w-full p-2 border border-slate-400 rounded-lg">
                        @error('start_time')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                    
                    <script>
                        flatpickr("#date", {
                            dateFormat: "Y-m-d"
                        });
                        flatpickr("#start_time", {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i",
                            time_24hr: true
                        });
                    </script>

                    {{-- DURATION --}}
                    <div class="flex flex-col">
                        <label for="duration" class="block">Durasi (jam)</label>
                        <input type="number" name="duration" id="duration" value="{{ old('duration') }}"
                            class="w-full p-2 border border-slate-400 rounded-lg">
                        @error('duration')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- COACH --}}
                    <div class="flex flex-col">
                        <label for="coach_id" class="block">Coach</label>
                        <select name="coach_id" id="coach_id" class="w-full p-2 border border-slate-400 rounded-lg">
                            @foreach ($coach as $c)
                                <option value="{{ $c->id }}" {{ old('coach_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('coach_id')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- LEVEL --}}
                    <div class="flex flex-col">
                        <label for="level" class="block">Level</label>
                        <select name="level" id="level" class="w-full p-2 border border-slate-400 rounded-lg">
                            <option value="Beginner" {{ old('level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="Intermediate" {{ old('level') == 'Intermediate' ? 'selected' : '' }}>
                                Intermediate</option>
                            <option value="Advanced" {{ old('level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                        @error('level')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- MAX SLOT --}}
                    <div class="flex flex-col">
                        <label for="max_slots" class="block">Max Slot</label>
                        <input type="number" name="max_slots" id="max_slots" value="{{ old('max_slots') }}"
                            class="w-full p-2 border border-slate-400 rounded-lg">
                        @error('max_slots')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PRICE --}}
                    <div class="flex flex-col">
                        <label for="price" class="block">Price</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                            class="w-full p-2 border border-slate-400 rounded-lg">
                        @error('price')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <button class="bg-green-dark text-white px-4 py-2 rounded-lg w-fit">
                    Submit
                </button>
            </form>

        </div>
    </section>
@endsection

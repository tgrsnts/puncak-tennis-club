@extends('admin.layout.main')

@section('title', 'Coach')

@section('content')
    <section id="dashboard" class="min-h-screen font-poppins w-full flex flex-col gap-4 p-4 pb-20 bg-[#F4F5F9]">
        <h2 class="text-2xl font-semibold mb-4">Coach</h2>
        <a href="{{ route('admin.coach.create') }}"
            class="bg-green-dark hover:bg-green-dark-hover focus:bg-green-dark-hover px-4 py-2 w-fit text-white rounded-lg">Add
            New Coach</a>
        <div class="overflow-x-auto bg-white shadow-xl rounded-lg">
            <table id="tablehewan" class="table rounded-lg row-border w-full">
                <thead>
                    <tr class="bg-[#D5D5D5]">
                        <th>Name</th>
                        <th>Specialty</th>
                        <th>Photo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->name }}</td>

                            <td>{{ $item->specialty }}</td>

                            <td>
                                <img id="photo-preview"
                                class="{{ $item->photo_url ? 'block' : 'hidden' }} w-20 h-full object-cover"
                                src="{{ $item->photo_url ? asset('storage/' . $item->photo_url) : '' }}"
                                alt="Coach Photo" />
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.coach.edit', ['locale' => app()->getLocale(), 'id' => $item->id]) }}"
                                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm rounded-lg">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.coach.destroy', ['locale' => app()->getLocale(), 'id' => $item->id]) }}"
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

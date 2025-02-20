@extends('layouts.master')
@section('title', 'Insight')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Profile Insights</h1>

        <!-- Date Range Filter -->
        <form method="GET" action="{{ route('insight') }}"
            class="mb-6 flex flex-wrap items-center justify-center gap-4">
            <div>
                <label class="font-semibold text-gray-700">Start Date:</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" max="{{ date('Y-m-d') }}" class="border p-2 rounded-lg">
            </div>
            <div>
                <label class="font-semibold text-gray-700">End Date:</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" max="{{ date('Y-m-d') }}" class="border p-2 rounded-lg">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Apply Filter
            </button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-xl font-semibold">👍 Total Likes</h2>
                <p class="text-4xl font-bold mt-2">{{ $totalLikes }}</p>
            </div>
            <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-xl font-semibold">💬 Total Comments</h2>
                <p class="text-4xl font-bold mt-2">{{ $totalComments }}</p>
            </div>
            <div class="bg-green-400 text-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-xl font-semibold">🖼 Total Album</h2>
                <p class="text-4xl font-bold mt-2">{{ $totalAlbums }}</p>
            </div>
            <div class="bg-cyan-500 text-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-xl font-semibold">📷 Total Post</h2>
                <p class="text-4xl font-bold mt-2">{{ $totalFotos }}</p>
            </div>
        </div>

        <div class="mt-10">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Top 5 Liked Photos</h2>
            @if ($topLikedPhotos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($topLikedPhotos as $photo)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            <img src="{{ asset($photo->lokasi_file) }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">{{ $photo->judul_foto }}</h3>
                                <p class="text-gray-600 text-sm">👍 {{ $photo->like_count }} Likes</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">No liked photos available.</p>
            @endif
        </div>

        <div class="mt-10">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Top 5 Commented Photos</h2>
            @if ($topCommentedPhotos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($topCommentedPhotos as $photo)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            <img src="{{ asset($photo->lokasi_file) }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">{{ $photo->judul_foto }}</h3>
                                <p class="text-gray-600 text-sm">💬 {{ $photo->komen_count }} Comments</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">No commented photos available.</p>
            @endif
        </div>

        <div class="mt-10">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Top 5 Interactors</h2>
            <div class="bg-white shadow-lg rounded-lg p-6">
                @if ($topInteractors->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                                    <th class="py-3 px-4 text-left">User</th>
                                    <th class="py-3 px-4 text-left">Total Likes</th>
                                    <th class="py-3 px-4 text-left">Total Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topInteractors as $user)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="py-3 px-4 flex items-center gap-3">
                                            <img src="{{ asset($user->foto_profil) }}"
                                                class="w-10 h-10 rounded-full object-cover">
                                            <span class="font-medium">{{ $user->username }}</span>
                                        </td>
                                        <td class="py-3 px-4">👍 {{ $user->total_like }}</td>
                                        <td class="py-3 px-4">💬 {{ $user->total_komen }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-gray-500">No interactors available.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid mx-auto px-6 py-8">
        <div class="mx-14 mb-4 flex justify-between">
            <h1 class="text-2xl font-bold">Photo Gallery</h1>
            <form method="GET" action="{{ route('dashboard') }}">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <select name="filter" onchange="this.form.submit()" class="border px-3 py-2 rounded-md">
                    <option value="">-- Filter By --</option>
                    <option value="likes_desc" {{ request('filter') == 'likes_desc' ? 'selected' : '' }}>Most Liked</option>
                    <option value="likes_asc" {{ request('filter') == 'likes_asc' ? 'selected' : '' }}>Least Liked</option>
                    <option value="komen_desc" {{ request('filter') == 'komen_desc' ? 'selected' : '' }}>Most Commented
                    </option>
                    <option value="komen_asc" {{ request('filter') == 'komen_asc' ? 'selected' : '' }}>Least Commented
                    </option>
                    <option value="date_desc" {{ request('filter') == 'date_desc' ? 'selected' : '' }}>Newest</option>
                    <option value="date_asc" {{ request('filter') == 'date_asc' ? 'selected' : '' }}>Oldest</option>
                    <option value="only_liked" {{ request('filter') == 'only_liked' ? 'selected' : '' }}>Only Liked</option>
                </select>
            </form>

        </div>

        <div class="card-container">
            @foreach ($foto as $f)
                <div class="card-foto card_box">
                    <button onclick="window.location.href='/foto/{{ $f->id }}'" class="w-full">
                        <img src="{{ $f->lokasi_file }}" alt="Image {{ $f->id }}"
                            class="w-full object-cover rounded-lg shadow-md">
                    </button>
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-sm md:text-lg font-semibold">{{ '@' . $f->user->username }}</h2>
                        <div class="flex items-center">
                            <span class="text-gray-600" id="like-{{ $f->id }}">{{ $f->like_count }}</span>
                            <form action="{{ route('toggleLike', $f->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="ml-1">
                                    @if ($f->is_liked)
                                        <svg class="w-5 h-5 text-red-600 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-600 mt-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop

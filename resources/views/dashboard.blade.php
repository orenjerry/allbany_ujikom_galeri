@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid mx-auto px-6 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach ($foto as $f)
                <div>
                    <button onclick="window.location.href='/foto/{{ $f->id }}'" class="w-full h-auto max-h-[300px] object-cover rounded-lg shadow-md">
                        <img src="{{ $f->lokasi_file }}" alt="Image {{ $f->id }}" class="w-full h-auto max-h-[300px] object-cover rounded-lg shadow-md">
                    </button>
                    <div class="-mt-3 flex justify-between items-center">
                        <h2 class="text-sm md:text-lg font-semibold mt-4">{{ '@' . $f->user->username }}</h2>
                        <div class="flex items-center mt-4">
                            <span class="text-gray-600" id="like-{{ $f->id }}">{{ $f->like_count }}</span>
                            <form action="{{ route('toggleLike', $f->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="ml-1 mt-1">
                                    @if ($f->is_liked)
                                        <svg class="w-5 h-5 ml-1 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 ml-1 text-gray-600" fill="none" stroke="currentColor"
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

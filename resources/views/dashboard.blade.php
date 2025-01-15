@extends('layouts.master')
@section('title')
    Dashboard
@stop

@section('content')
    <div class="container-fluid mx-auto px-6 py-8">
        <div class="grid grid-cols-6 gap-4">
            @for ($i = 1; $i <= 30; $i++)
                <div>
                    <img src="https://picsum.photos/200/{{ rand(200, 500) }}?random={{ rand() }}"
                        alt="Image {{ $i }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                    <div class="-mt-3 flex justify-between items-center">
                        <h2 class="text-lg font-semibold mt-4">Image {{ $i }}</h2>
                        <div class="flex items-center mt-4">
                            <span class="text-gray-600">{{ rand(0, 999) }}</span>
                            <svg class="w-5 h-5 ml-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@stop

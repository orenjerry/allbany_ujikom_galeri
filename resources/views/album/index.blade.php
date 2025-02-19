@extends('layouts.master')
@section('title', 'My Albums')

@section('content')
    <div class="container justify-center mx-auto px-6 py-8">
        <div class="flex justify-between items-center my-4 mx-3">
            <h1 class="text-center text-[32px] flex-1 ml-20">My Albums</h1>
            <div class="flex flex-col items-end gap-2">
                <button
                    class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded w-28 flex items-center justify-center space-x-2"
                    onclick="window.location.href='/album/create'">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Album</span>
                </button>
                {{-- <button
                    class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 rounded w-28 flex items-center justify-center space-x-2"
                    onclick="window.location.href='/album/create'">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Report</span>
                </button> --}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="flex flex-wrap row items-center justify-center">
                    @forelse($album as $albums)
                        <div class="mx-3 mb-4">
                            <a href="{{ route('showDetailAlbum', $albums->id) }}">
                                <div class="card rounded-lg h-[350px]">
                                    <img src="{{ $albums->cover_image ?? asset('images/default-album.jpg') }}"
                                        class="card-img-top w-[300px] h-auto max-h-[300px] rounded-xl" alt="Album Cover">
                                    <div class="card-body text-center my-3">
                                        <h5 class="card-title text-center">{{ $albums->name }}</h5>
                                        <p>{{ $albums->nama_album }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <p>No albums found.</p>
                        </div>
                    @endforelse
                </div>

                @if ($album->total() > 6)
                    <div class="mt-4 flex justify-center">
                        <nav class="inline-flex space-x-2">
                            @if ($album->onFirstPage())
                                <span class="px-4 py-2 text-gray-400 bg-gray-200 rounded">Prev</span>
                            @else
                                <a href="{{ $album->previousPageUrl() }}"
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-400">Prev</a>
                            @endif

                            @foreach ($album->getUrlRange(1, $album->lastPage()) as $page => $url)
                                @if ($page == $album->currentPage())
                                    <span class="px-4 py-2 bg-blue-700 text-white rounded">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-400">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($album->hasMorePages())
                                <a href="{{ $album->nextPageUrl() }}"
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-400">Next</a>
                            @else
                                <span class="px-4 py-2 text-gray-400 bg-gray-200 rounded">Next</span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

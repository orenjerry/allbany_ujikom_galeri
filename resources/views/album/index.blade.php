@extends('layouts.master')
@section('title', 'My Albums')

@section('content')
    <div class="container justify-center mx-auto px-6 py-8">
        <div class="flex justify-between items-center my-4 mx-3">
            <h1 class="text-center text-[32px] flex-1 ml-20">My Albums</h1>
            <div class="mb-3">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-28 flex items-center justify-center space-x-2"
                    onclick="window.location.href='/album/create'">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Album</span>
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="flex flex-wrap row items-center justify-center">
                    @forelse($album ?? [] as $albums)
                        <div class="mx-3 mb-4">
                            <div class="card">
                                <img src="{{ $albums->cover_image ?? asset('images/default-album.jpg') }}"
                                    class="card-img-top w-[300px] h-auto max-h-[300px]" alt="Album Cover">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-center">{{ $albums->name }}</h5>
                                    <a href="#{{-- {{ route('album.show', $album->id) }} --}}" class="btn btn-info">{{ $albums->nama_album }}</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p>No albums found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

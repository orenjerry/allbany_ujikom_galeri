@extends('layouts.master')
@section('title', 'My Albums')

@section('content')
<div class="container-fluid">
    <h1 class="text-center text-[32px]">My Albums</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="#{{--{{  route('album.create') }}--}}" class="btn btn-primary">Create New Album</a>
            </div>

            <div class="row">
                @forelse($albums ?? [] as $album)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ $album->cover_image ?? asset('images/default-album.jpg') }}" class="card-img-top" alt="Album Cover">
                            <div class="card-body">
                                <h5 class="card-title">{{ $album->name }}</h5>
                                <p class="card-text">{{ $album->description }}</p>
                                <a href="#{{-- {{ route('album.show', $album->id) }} --}}" class="btn btn-info">View Album</a>
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

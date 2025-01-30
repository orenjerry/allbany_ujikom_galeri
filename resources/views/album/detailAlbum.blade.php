@extends('layouts.master')
@section('title')
    {{ $album->nama_album }}
@stop

@section('content')
    <div class="container-fluid mx-auto px-6 py-6">
        <div id="album" class="">
            <div class="flex justify-center">
                <h1 class="pt-5 pb-2 text-[32px] text-center font-semibold">{{ $album->nama_album }}</h1>
                <button class="pl-1">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15" height="15" viewBox="0 0 30 30">
                        <path
                            d="M24 11l2.414-2.414c.781-.781.781-2.047 0-2.828l-2.172-2.172c-.781-.781-2.047-.781-2.828 0L19 6 24 11zM17 8L5.26 19.74C7.886 19.427 6.03 21.933 7 23c.854.939 3.529-.732 3.26 1.74L22 13 17 8zM4.328 26.944l-.015-.007c-.605.214-1.527-.265-1.25-1.25l-.007-.015L4 23l3 3L4.328 26.944z">
                        </path>
                    </svg>
                </button>
            </div>
            <hr class="border-2 border-gray-300 w-1/2 mx-auto mb-3">
            <p class="w-1/2 mx-auto text-center pb-5">{{ $album->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            <hr class="border-gray-300 w-full mx-auto mb-5">
        </div>

        <div id="editAlbum" class="hidden">
            <form action="{{ route('editAlbum', $album->id) }}" method="post">
                @csrf
                @method('put')
                <div class="flex justify-center">
                    {{-- <h1 class="pt-5 pb-2 text-[32px] text-center font-semibold">{{ $album->nama_album }}</h1> --}}
                    <input type="text" name="nama_album" id="nama_album" value="{{ $album->nama_album }}"
                        class="mt-3 mb-3 text-[32px] text-center font-semibold">
                    <button class="pl-1" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15" height="15"
                            viewBox="0 0 30 30">
                            <path
                                d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z">
                            </path>
                        </svg>
                    </button>
                </div>
                <hr class="border-2 border-gray-300 w-1/2 mx-auto mb-3">
                <div class="flex justify-center pb-5">
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="w-1/2 border border-gray-300 rounded-lg">{{ $album->deskripsi ?? '' }}</textarea>
                </div>
                <hr class="border-gray-300 w-full mx-auto mb-5">
            </form>
        </div>

        <div class="grid grid-cols-6 gap-4">
            @if ($album->foto->isEmpty())
                <div class="col-span-6 text-center">
                    <p class="text-lg">Album ini belum memiliki foto</p>
                </div>
            @else
                @foreach ($album->foto as $f)
                    <div>
                        <button onclick="window.location.href='/foto/{{ $f->id }}'"
                            class="w-full h-auto max-h-[300px] object-cover rounded-lg shadow-md">
                            <img src="{{ asset($f->lokasi_file) }}" alt="Image {{ $f->id }}"
                                class="w-full h-auto max-h-[300px] object-cover rounded-lg shadow-md">
                        </button>
                        <div class="-mt-3 flex justify-between items-center">
                            <h2 class="text-lg font-semibold mt-4">{{ '@' . $f->user->username }}</h2>
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
            @endif
        </div>
    </div>
@stop

@push('scripts')
    <script>
        const album = document.getElementById('album');
        const editAlbum = document.getElementById('editAlbum');

        album.addEventListener('click', () => {
            album.classList.add('hidden');
            editAlbum.classList.remove('hidden');
        });

        // editAlbum.addEventListener('click', () => {
        //     album.classList.remove('hidden');
        //     editAlbum.classList.add('hidden');
        // });

    </script>

@endpush

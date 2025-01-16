@extends('layouts.master')
@section('title', 'Detail Foto')

@section('content')
    <div class="container mx-auto px-6 py-8 flex justify-center">
        <div class="flex bg-slate-300 rounded-lg shadow-lg w-1/2">
            <img src="../{{ $foto->lokasi_file }}" alt="Image {{ $foto->id }}"
                class="w-[300px] h-auto max-h-[500px] object-cover rounded-lg shadow-md">
            <div class="flex flex-col ml-4 mt-5">
                <div class="flex items-center">
                    <span class="text-[20px] text-gray-600" id="like-{{ $foto->id }}">{{ $foto->like_count }}</span>
                    <form action="{{ route('toggleLike', $foto->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center">
                            @if ($foto->is_liked)
                                <svg class="w-[30px] h-[30px] text-red-600 pl-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                        clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg class="w-[30px] h-[30px] text-gray-600 pl-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endif
                        </button>
                    </form>
                    <svg class="ml-3" height="20" role="img" viewBox="0 0 24 24" width="20">
                        <path
                            d="M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6M3 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6m18 0a3 3 0 1 0 0 6 3 3 0 0 0 0-6">
                        </path>
                    </svg>
                </div>
                <div class="h-[400px] w-full mr-10 overflow-y-auto">
                    <div class="mt-3 font-semibold text-[30px]">
                        <h1>{{ $foto->judul_foto }}</h1>
                    </div>
                    <div class="mt-1 text-[13px]">
                        <p>{{ $foto->deskripsi_foto }}</p>
                    </div>
                    <div class="mt-2 text-[15px]">
                        <h1 class="rounded-md bg-blue-50 px-1 py-1 text-xs ring-1 ring-inset ring-blue-700/10 inline-block">
                            Diupload oleh <span class="text-blue-700">{{ '@' . $foto->user->username }}</span></h1>
                    </div>
                    <div class="mt-10 font-medium">
                        <h1>{{ $foto->komen_count }} Komentar</h1>
                        <hr class="border-1 border-black mt-3">
                        <div>
                            <ul class="list-disc pl-5">
                                @foreach ($foto->komen as $k)
                                    <li>
                                        <div class="mt-3">
                                            <h1 class="font-semibold">{{ '@' . $k->user->username }}</h1>
                                            <p class="font-normal text-[12px]">{{ $k->isi_komentar }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="mt-5">
                        <form action="{{ route('addComment', $foto->id) }}" method="POST">
                            @csrf
                            <input type="text" name="komentar" id="komentar"
                                class="w-[97%] rounded-md border-2 border-gray-300 p-2" placeholder="Tulis Komentar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

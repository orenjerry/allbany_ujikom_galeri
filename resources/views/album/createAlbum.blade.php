@extends('layouts.master')
@section('title', 'Create Album')

@section('content')
    <div class="container mx-auto px-6 py-8 flex justify-center">
        <div class="flex bg-slate-300 rounded-lg shadow-lg w-full md:w-1/2">
            <form action="{{ route('createAlbum') }}" method="POST" class="flex flex-col mx-4 mt-5 w-full p-6">
                @csrf
                <div class="mb-4">
                    <label for="nama_album" class="block text-[20px] text-gray-600 mb-2">Nama Album:</label>
                    <input type="text" name="nama_album" id="nama_album" placeholder="Masukkan nama album"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-[20px] text-gray-600 mb-2">Deskripsi:</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Masukkan deskripsi album"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required></textarea>
                </div>

                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200 mt-5">
                    Create Album
                </button>
                @error('nama_album')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </form>
        </div>
    </div>
@stop

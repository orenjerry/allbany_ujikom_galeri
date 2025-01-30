@extends('layouts.master')
@section('title', 'Add Foto')

@section('content')
    <div class="container mx-auto px-6 py-8 flex justify-center">
        <div class="flex bg-slate-300 rounded-lg shadow-lg w-1/2">
            <form action="{{ route('addFoto') }}" method="POST" enctype="multipart/form-data"
                class="flex flex-col ml-4 mt-5 w-full p-6">
                @csrf
                <div class="mb-4">
                    <label for="file" class="block text-[20px] text-gray-600 mb-2">Pilih gambar:</label>
                    <input type="file" name="file" id="file"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="judul" class="block text-[20px] text-gray-600 mb-2">Judul Foto:</label>
                    <input type="text" name="judul" id="judul" placeholder="Masukkan judul foto"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-[20px] text-gray-600 mb-2">Deskripsi:</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Masukkan deskripsi foto"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="album" class="block text-[20px] text-gray-600 mb-2">Album:</label>
                    <select name="album" id="album"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                        <option value="" disabled selected>Pilih album</option>
                        @foreach ($album as $a)
                            <option value="{{ $a->id }}">{{ $a->nama_album }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200 mt-5">
                    Upload Foto
                </button>
            </form>
            @error('file')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
@stop

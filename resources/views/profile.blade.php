@extends('layouts.master')
@section('title', 'Profile')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <form action="{{ route('editProfile') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="flex justify-center">
                <div class="w-full md:w-1/2">
                    <div class="bg-slate-300 rounded-lg shadow-lg p-6">
                        <h1 class="text-[32px] font-semibold text-left">Informasi Pengguna</h1>
                        <div class="mt-4">
                            <div class="flex items-center gap-8">
                                <div class="flex flex-col items-center">
                                    <label for="profile_picture" class="relative group cursor-pointer">
                                        @if ($user->foto_profil)
                                            <img src="{{ asset($user->foto_profil) }}" alt="Profile Picture"
                                                id="preview-image"
                                                class="w-32 h-32 rounded-full object-cover transition duration-200">
                                        @else
                                            <div id="default-preview"
                                                class="w-32 h-32 rounded-full bg-blue-500 flex items-center justify-center text-white text-4xl font-bold">
                                                {{ strtoupper(substr($user->username, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-white text-sm font-semibold rounded-full opacity-0 group-hover:opacity-100 transition duration-200">
                                            Ganti Foto
                                        </div>
                                    </label>
                                    <input type="file" id="profile_picture" name="profile_picture" class="hidden"
                                        accept="image/*">
                                </div>

                                <div class="flex-1">
                                    <div class="mt-3">
                                        <h6 class="bg-gray-400 text-gray-800 px-5">PROFILE</h6>
                                        <div class="flex flex-wrap mt-1">
                                            <div class="w-1/2">
                                                <p class="mt-4 text-black">Nama Lengkap</p>
                                                <p class="mt-4 text-black">Email</p>
                                                <p class="mt-4 text-black">Alamat</p>
                                            </div>
                                            <div class="w-1/2">
                                                <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}"
                                                    id="nama_lengkap"
                                                    class="px-1 mt-4 w-full border border-slate-400 bg-slate-300" required>

                                                <input type="email" name="email" value="{{ $user->email }}"
                                                    id="email"
                                                    class="px-1 mt-4 w-full border border-slate-400 bg-slate-300" required>

                                                <input type="text" name="alamat" value="{{ $user->alamat }}"
                                                    id="alamat"
                                                    class="px-1 mt-4 w-full border border-slate-400 bg-slate-300" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="bg-gray-400 text-gray-800 px-5">AKUN</h6>
                                        <div class="flex flex-wrap mt-1">
                                            <div class="w-1/2">
                                                <p class="mt-4 text-black">Username</p>
                                                <p class="mt-4 text-black">Password Sekarang</p>
                                                @error('current_password')
                                                    <p class="text-slate-300 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                                <p class="mt-4 text-black">Password Baru</p>
                                            </div>
                                            <div class="w-1/2">
                                                <input type="text" name="username" value="{{ $user->username }}"
                                                    id="username"
                                                    class="px-1 mt-4 w-full border border-slate-400 bg-slate-300" required>

                                                <input type="password" name="current_password" id="current_password"
                                                    class="px-1 mt-4 w-full border border-slate-400 bg-slate-300"
                                                    placeholder="Isi Password jika ingin diubah">
                                                @error('current_password')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror

                                                <input type="password" name="new_password" id="new_password"
                                                    class="px-1 mt-4 w-full border border-slate-400 bg-slate-300"
                                                    placeholder="Isi Password jika ingin diubah">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <button type="submit"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200 mt-5">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('profile_picture').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('preview-container');
            const defaultPreview = document.getElementById('default-preview');
            const previewImage = document.getElementById('preview-image');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    if (defaultPreview) {
                        defaultPreview.classList.add('hidden');
                    }
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.src = '';
                previewImage.classList.add('hidden');
                if (defaultPreview) {
                    defaultPreview.classList.remove('hidden');
                }
            }
        });
    </script>
@endpush

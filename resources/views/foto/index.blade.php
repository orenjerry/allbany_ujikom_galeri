@extends('layouts.master')
@section('title', 'Detail Foto')

@section('content')
    <div class="container-fluid mx-auto px-6 py-8 flex justify-center">
        <div class="flex flex-col lg:flex-row bg-slate-300 rounded-lg shadow-lg">
            <div class="w-auto h-auto lg:min-w-[300px] lg:min-h-[200px] lg:max-w-[1000px] lg:max-h-[600px]">
                <img src="../{{ $foto->lokasi_file }}" alt="Image {{ $foto->id }}"
                    class="w-full h-full lg:max-w-[900px] object-cover rounded-lg shadow-md">
            </div>
            <div class="flex flex-col p-4 lg:ml-4 lg:mt-5">
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
                    @if ($foto->id_user === session('user_id') || session('id_role') == 1)
                        <button id="dropdownButton-{{ $foto->id }}" class="ml-3">
                            <svg class="w-5 h-5" role="img" viewBox="0 0 24 24">
                                <path
                                    d="M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6M3 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6m18 0a3 3 0 1 0 0 6 3 3 0 0 0 0-6">
                                </path>
                            </svg>
                        </button>
                        @if (session('id_role') == 1)
                            <div class="relative pt-5">
                                <div id="dropdownMenu-{{ $foto->id }}"
                                    class="hidden absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg z-50">
                                    <form action="{{ route('deleteFoto', $foto->id) }}" method="POST"
                                        onsubmit="event.preventDefault(); askReason(this);">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="reason" id="delete_reason">
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 rounded-lg">Delete</button>
                                    </form>
                                </div>
                            </div>
                            @push('scripts')
                                <script>
                                    function askReason(form) {
                                        Swal.fire({
                                            title: 'Alasan menghapus foto',
                                            input: 'text',
                                            inputPlaceholder: 'Masukkan alasan...',
                                            showCancelButton: true,
                                            confirmButtonText: 'Lanjutkan',
                                            cancelButtonText: 'Batal',
                                            showLoaderOnConfirm: true,
                                            preConfirm: (reason) => {
                                                if (!reason) {
                                                    Swal.showValidationMessage('Alasan harus diisi')
                                                }
                                                return reason;
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                Swal.fire({
                                                    title: 'Apakah kamu yakin?',
                                                    text: "Foto ini akan dihapus secara permanen",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Ya, hapus!',
                                                    cancelButtonText: 'Batal'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('delete_reason').value = result.value;
                                                        form.submit();
                                                    }
                                                });
                                            }
                                        });
                                    }
                                </script>
                            @endpush
                        @else
                            <div class="relative pt-5">
                                <div id="dropdownMenu-{{ $foto->id }}"
                                    class="hidden absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg z-50">
                                    <button id="btn-edit"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left rounded-lg">Edit</button>
                                    <form action="{{ route('deleteFoto', $foto->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah kamu yakin akan menghapus foto ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 rounded-lg">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @push('scripts')
                            <script>
                                document.getElementById('dropdownButton-{{ $foto->id }}').addEventListener('click', function() {
                                    document.getElementById('dropdownMenu-{{ $foto->id }}').classList.toggle('hidden');
                                });

                                window.addEventListener('click', function(e) {
                                    if (!e.target.closest('#dropdownButton-{{ $foto->id }}')) {
                                        document.getElementById('dropdownMenu-{{ $foto->id }}').classList.add('hidden');
                                    }
                                });
                            </script>
                        @endpush
                    @endif
                </div>
                <div class="w-full lg:w-[300px] pr-5" id="content">
                    <div class="h-[400px] w-full overflow-y-auto">
                        <div class="mt-3 font-semibold text-[30px]">
                            <h1>{{ $foto->judul_foto }}</h1>
                        </div>
                        <div class="mt-1 text-[13px]">
                            <p>{{ $foto->deskripsi_foto }}</p>
                        </div>
                        <div class="pt-5 flex items-center gap-2">
                            @if ($foto->user->foto_profil)
                                <img src="{{ asset($foto->user->foto_profil) }}" alt="Profile Picture"
                                    class="w-7 h-7 rounded-full object-cover">
                            @else
                                <div
                                    class="w-7 h-7 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold">
                                    {{ strtoupper(substr($foto->user->username, 0, 1)) }}
                                </div>
                            @endif
                            <span class="text-m font-semibold">{{ $foto->user->username }}</span>
                        </div>

                        <div class="mt-10 font-medium">
                            <h1>{{ $foto->komen_count }} Komentar</h1>
                            <hr class="border-1 border-black mt-3 w-full">
                            <div>
                                <ul class="list-disc">
                                    @foreach ($foto->komen as $k)
                                        <li class="flex items-start gap-3 mt-3">
                                            @if ($k->user->foto_profil)
                                                <img src="{{ asset($k->user->foto_profil) }}" alt="Profile Picture"
                                                    class="w-8 h-8 rounded-full object-cover">
                                            @else
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold">
                                                    {{ strtoupper(substr($k->user->username, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="space-y-0">
                                                <h1 class="font-semibold">{{ $k->user->username }}</h1>
                                                <span class="italic text-[11px] font-light block">
                                                    {{ \Carbon\Carbon::parse($k->created_at)->diffForHumans() }}
                                                </span>
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
                @if ($foto->id_user === session('user_id'))
                    <div class="w-full lg:w-[300px] hidden pr-5" id="edit-content">
                        <form action="{{ route('editFoto', $foto->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mt-3">
                                <label for="judul_foto" class="block text-sm font-medium text-gray-700">Judul Foto</label>
                                <input type="text" name="judul_foto" id="judul_foto" value="{{ $foto->judul_foto }}"
                                    class="w-full block text-gray-700 text-sm font-bold mb-2">
                            </div>
                            <div class="mt-3">
                                <label for="deskripsi_foto" class="block text-sm font-medium text-gray-700">Deskripsi
                                    Foto</label>
                                <input type="text" name="deskripsi_foto" id="deskripsi_foto"
                                    value="{{ $foto->deskripsi_foto }}"
                                    class="w-full block text-gray-700 text-sm font-bold mb-2">
                            </div>
                            <div class="mt-3">
                                <label for="album" class="block text-sm font-medium text-gray-700">Album:</label>
                                <select name="album" id="album"
                                    class="w-full block text-gray-700 text-sm font-bold mb-2 border focus:outline-none focus:border-blue-500"
                                    required>
                                    <option value="" disabled selected>Pilih album</option>
                                    @foreach ($album as $a)
                                        @if ($a->id === $foto->id_album)
                                            <option value="{{ $a->id }}" selected>{{ $a->nama_album }}</option>
                                        @else
                                            <option value="{{ $a->id }}">{{ $a->nama_album }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-2 mt-3">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Edit</button>
                                <button type="button" id="cancel"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded">Cancel</button>
                            </div>
                        </form>
                    </div>

                    @push('scripts')
                        <script>
                            document.getElementById('btn-edit').addEventListener('click', function() {
                                document.getElementById('content').classList.add('hidden');
                                document.getElementById('edit-content').classList.remove('hidden');
                            });
                            document.getElementById('cancel').addEventListener('click', function() {
                                document.getElementById('content').classList.remove('hidden');
                                document.getElementById('edit-content').classList.add('hidden');
                            });
                        </script>
                    @endpush
                @endif
            </div>
        </div>
    </div>
@stop

@extends('layouts.master')
@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-center items-center">
            <div class="container w-3/4 bg-slate-300 rounded-lg shadow-lg p-6 justify-items-center">
                <h1 class="font-bold text-[20px] text-center">New Users Approval</h1>
                <div class="flex justify-center mt-4">
                    <table class="table-auto">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Username</th>
                            <th class="border px-4 py-2">Email</th>
                            <th class="border px-4 py-2">Action</th>
                        </tr>
                        @if (empty($users))
                            <tr>
                                <td class="border px-4 py-2 text-center" colspan="4">No data available</td>
                            </tr>
                        @else
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $user->username }}</td>
                                    <td class="border px-4 py-2">{{ $user->email }}</td>
                                    <td class="border px-4 py-2">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="action" value="approve">
                                                <button type="submit"
                                                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-200">
                                                    Terima
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-200">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

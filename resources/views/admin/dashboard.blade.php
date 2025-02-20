@extends('layouts.master')
@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-col justify-center items-center">
            <div class="container w-3/4 bg-white rounded-lg shadow-xl p-6 mb-10">
                <h1 class="font-bold text-2xl text-center text-gray-800">New Users Approval</h1>
                <div class="flex justify-center mt-6 overflow-x-auto">
                    <table class="table-auto w-full border-collapse rounded-lg shadow-md">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-6 py-3 text-gray-700 w-10">No</th>
                                <th class="border px-6 py-3 text-gray-700">Username</th>
                                <th class="border px-6 py-3 text-gray-700">Email</th>
                                <th class="border px-6 py-3 text-gray-700 w-16">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @if ($users->isEmpty())
                                <tr>
                                    <td class="border px-6 py-4 text-center text-gray-500" colspan="4">No data available
                                    </td>
                                </tr>
                            @else
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                        <td class="border px-6 py-4">{{ $user->username }}</td>
                                        <td class="border px-6 py-4">{{ $user->email }}</td>
                                        <td class="border px-6 py-4 text-center">
                                            <button onclick="openModal({{ json_encode($user) }})"
                                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition">Lihat</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="container w-3/4 bg-white rounded-lg shadow-xl p-6">
                <h1 class="font-bold text-2xl text-center text-gray-800">Rejected Users</h1>
                <div class="flex justify-center mt-6 overflow-x-auto">
                    <table class="table-auto w-full border-collapse rounded-lg shadow-md">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-6 py-3 text-gray-700 w-10">No</th>
                                <th class="border px-6 py-3 text-gray-700">Username</th>
                                <th class="border px-6 py-3 text-gray-700 w-16">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @if ($rejected->isEmpty())
                                <tr>
                                    <td class="border px-6 py-4 text-center text-gray-500" colspan="4">No data available
                                    </td>
                                </tr>
                            @else
                                @foreach ($rejected as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                        <td class="border px-6 py-4">{{ $user->username }}</td>
                                        <td class="border px-6 py-4 text-center">
                                            <button onclick="openModal({{ json_encode($user) }}, true)"
                                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition">Lihat</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="userModal"
        class="fixed inset-0 hidden bg-gray-800 bg-opacity-50 flex justify-center items-center transition-opacity duration-300">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 transform scale-95 opacity-0 transition-transform duration-300"
            id="modalContent">
            <h2 class="text-lg font-bold mb-4">User Details</h2>
            <p><strong>Username:</strong> <span id="modalUsername"></span></p>
            <p><strong>Nama Lengkap:</strong> <span id="modalNamaLengkap"></span></p>
            <p><strong>Email:</strong> <span id="modalEmail"></span></p>
            <p><strong>Alamat:</strong> <span id="modalAlamat"></span></p>
            <hr id="hr-reason" class="my-4 hidden">
            <p class="hidden" id="rejectReason"><strong>Rejected reason:</strong> <span id="modalReason"></span></p>
            <div class="flex justify-end mt-4">
                <button id="approveButton" onclick="approveUser()"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mr-2">
                    Approve
                </button>
                <button id="rejectButton" onclick="rejectUser()"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                    Reject
                </button>
                <button onclick="closeModal()"
                    class="ml-2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        function openModal(user, isRejected = false) {
            console.log(user);

            document.getElementById('modalUsername').dataset.userId = user.id;
            document.getElementById('modalUsername').textContent = user.username;
            document.getElementById('modalNamaLengkap').textContent = user.nama_lengkap || 'No full name provided';
            document.getElementById('modalEmail').textContent = user.email;
            document.getElementById('modalAlamat').textContent = user.alamat;

            if (isRejected) {
                document.querySelector('#approveButton').classList.add('hidden');
                document.querySelector('#rejectButton').classList.add('hidden');
                document.querySelector('#hr-reason').classList.remove('hidden');
                document.querySelector('#rejectReason').classList.remove('hidden');
                document.getElementById('modalReason').textContent = user.rejection_reason.reason;
            } else {
                document.querySelector('#approveButton').classList.remove('hidden');
                document.querySelector('#rejectButton').classList.remove('hidden');
                document.querySelector('#rejectReason').classList.add('hidden');
            }

            let modal = document.getElementById('userModal');
            let modalContent = document.getElementById('modalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }


        function closeModal() {
            let modal = document.getElementById('userModal');
            let modalContent = document.getElementById('modalContent');
            modal.classList.remove('opacity-100');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modal.classList.add('hidden');
        }

        function approveUser() {
            const userId = document.getElementById('modalUsername').dataset.userId;

            Swal.fire({
                title: 'Approve User',
                text: 'Are you sure you want to approve this user?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Approve',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/approve/${userId}`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                action: 'approve'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Approved!', 'User has been approved successfully.', 'success')
                                    .then(() => window.location.reload());
                            } else {
                                Swal.fire('Error', 'Error approving user.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Something went wrong.', 'error');
                        })
                        .finally(() => {
                            closeModal();
                        });
                }
            });
        }


        function rejectUser() {
            const userId = document.getElementById('modalUsername').dataset.userId;

            Swal.fire({
                title: 'Reject User',
                input: 'text',
                inputLabel: 'Reason for rejection',
                inputPlaceholder: 'Enter reason...',
                inputAttributes: {
                    required: true
                },
                showCancelButton: true,
                confirmButtonText: 'Reject',
                cancelButtonText: 'Cancel',
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('Reason is required');
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/approve/${userId}`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                action: 'reject',
                                reason: result.value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Rejected!', 'User has been rejected.', 'success').then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire('Error', 'Failed to reject user', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Failed to reject user', 'error');
                        })
                        .finally(() => {
                            closeModal();
                        });
                }
            });
        }
    </script>
@endsection

<nav class="sticky top-0 bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="/dashboard" class="text-xl font-bold text-gray-800">Gallery</a>
            </div>

            <div class="flex items-center">
                <div class="relative mt-2">
                    <button id="notificationButton" class="relative pl-4" title="Notifications"
                        onclick="toggleNotifications()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 1 0-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
                        </svg>
                        @if ($unreadNotifications->count() > 0)
                            <span id="unreadBadge"
                                class="absolute top-0 right-0 inline-block w-3 h-3 bg-red-600 rounded-full"></span>
                        @endif
                    </button>

                    <div id="notificationModal"
                        class="hidden absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg py-1">
                        @if ($unreadNotifications->count() > 0)
                            @foreach ($unreadNotifications as $notification)
                                <a href="{{ route('detailFoto', $notification->data['id_foto']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <span>{{ $notification->data['message'] }}</span><br>
                                    <span class="italic text-[11px] font-light">{{ $notification->created_at }}</span>
                                </a>
                            @endforeach
                            <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-center w-full" onclick="window.location.href='{{ route('markAsRead') }}'">Mark all as read</button>
                        @else
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-center">No new
                                notifications</a>
                        @endif
                    </div>
                </div>
                <button onclick="window.location.href='/foto/add'" class="pl-4" title="Add Photos">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </button>
                <button onclick="window.location.href='/album'" class="pl-4" title="Albums">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </button>
                <button id="profileButton" class="pl-4" title="Profile">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
                <div class="relative pt-6">
                    <div id="profileModal" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                        <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        @if (session('id_role') == 1)
                            <a href="{{ route('admin.dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('auth.logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        const profileButton = document.getElementById('profileButton');
        const profileModal = document.getElementById('profileModal');

        const notificationButton = document.getElementById('notificationButton');
        const notificationModal = document.getElementById('notificationModal');

        profileButton.addEventListener('click', () => {
            profileModal.classList.toggle('hidden');
        });

        notificationButton.addEventListener('click', () => {
            notificationModal.classList.toggle('hidden');
        });

        window.addEventListener('click', (e) => {
            if (!profileButton.contains(e.target) && !profileModal.contains(e.target)) {
                profileModal.classList.add('hidden');
            }
            if (!notificationButton.contains(e.target) && !notificationModal.contains(e.target)) {
                notificationModal.classList.add('hidden');
            }
        });
    </script>
@endpush

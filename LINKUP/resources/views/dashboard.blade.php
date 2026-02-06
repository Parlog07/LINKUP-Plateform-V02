@auth
    <script>
        window.currentUserId = {{ auth()->id() }};
    </script>
@endauth

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - Linkup</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        },
                        secondary: {
                            500: '#8b5cf6',
                            600: '#7c3aed',
                        },
                        neutral: {
                            50: '#fafafa',
                            100: '#f5f5f5',
                            200: '#e5e5e5',
                            300: '#d4d4d4',
                            700: '#404040',
                            800: '#262626',
                            900: '#171717',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'pulse-subtle': 'pulseSubtle 2s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        pulseSubtle: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '0.8' },
                        }
                    }
                }
            }
        }
    </script>

    @vite(['resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="font-sans antialiased min-h-screen bg-gradient-to-br from-neutral-50 via-white to-primary-50/20">
    <!-- Header -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-white/90 border-b border-neutral-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-secondary-600 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full border-2 border-white"></div>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">
                        Linkup
                    </span>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50' }}">
                        <i class="fas fa-compass mr-2"></i>Discover
                    </a>
                    <a href="{{ route('connections') }}"
                        class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 {{ request()->routeIs('connections') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50' }}">
                        <i class="fas fa-user-friends mr-2"></i>Connections
                    </a>
                    <a href="{{ route('posts.store') }}"
                        class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 {{ request()->routeIs('posts.*') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50' }}">
                        <i class="fas fa-edit mr-2"></i>Posts
                    </a>
                    <a href="{{ route('posts.feeds') }}"
                        class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 {{ request()->routeIs('posts.*') ? 'bg-primary-50 text-primary-600 shadow-sm' : 'text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50' }}">
                        <i class="fas fa-newspaper mr-2"></i>Feed
                    </a>
                    <a href="#"
                        class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50">
                        <i class="fas fa-envelope mr-2"></i>Messages
                    </a>
                    <a href="#"
                        class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50 relative">
                        <i class="fas fa-bell mr-2"></i>Notifications
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center animate-pulse-subtle">3</span>
                    </a>
                </nav>

                <!-- User Actions -->
                <div class="flex items-center space-x-3">
                    <!-- Search -->
                    <div class="relative hidden md:block">
                        <form method="GET" action="{{ route('dashboard') }}">
                            <div class="relative">
                                <input type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search users..."
                                    class="pl-10 pr-4 py-2.5 bg-neutral-50 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 w-64 text-sm transition-all duration-300">
                                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-400 hover:text-primary-600 transition-colors">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- User Menu -->
                    <div class="relative" id="userDropdown">
                        <button onclick="toggleDropdown()" class="flex items-center space-x-3 focus:outline-none group">
                            <div class="flex items-center space-x-3 bg-white/50 rounded-xl px-3 py-2 border border-neutral-200 hover:border-primary-300 transition-all duration-200 group-hover:shadow-sm">
                                <div class="w-8 h-8 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center overflow-hidden ring-2 ring-white ring-offset-1 ring-offset-primary-50">
                                    @if(Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="w-full h-full object-cover">
                                    @else
                                    <i class="fas fa-user text-primary-600"></i>
                                    @endif
                                </div>
                                <div class="hidden lg:block text-left">
                                    <p class="text-sm font-medium text-neutral-800">{{ Auth::user()->first_name }}</p>
                                    <p class="text-xs text-neutral-500">View profile</p>
                                </div>
                                <i class="fas fa-chevron-down text-neutral-400 text-xs group-hover:text-primary-600 transition-colors"></i>
                            </div>
                        </button>

                        <div id="dropdownMenu" class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl py-2 z-50 hidden border border-neutral-200 animate-fade-in animate-slide-up">
                            <div class="px-4 py-3 border-b border-neutral-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center overflow-hidden ring-2 ring-primary-100">
                                        @if(Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="w-full h-full object-cover">
                                        @else
                                        <i class="fas fa-user text-primary-600"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-neutral-900">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                                        <p class="text-xs text-neutral-500 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="py-2">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-neutral-700 hover:bg-primary-50/50 hover:text-primary-600 transition-colors group">
                                    <div class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center mr-3 group-hover:bg-primary-100 transition-colors">
                                        <i class="fas fa-user-edit text-primary-600 text-sm"></i>
                                    </div>
                                    Edit Profile
                                </a>

                                <a href="#" class="flex items-center px-4 py-2.5 text-sm text-neutral-700 hover:bg-primary-50/50 hover:text-primary-600 transition-colors group">
                                    <div class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center mr-3 group-hover:bg-primary-100 transition-colors">
                                        <i class="fas fa-cog text-primary-600 text-sm"></i>
                                    </div>
                                    Settings
                                </a>
                            </div>

                            <div class="border-t border-neutral-100 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors group">
                                        <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-100 transition-colors">
                                            <i class="fas fa-sign-out-alt text-red-600 text-sm"></i>
                                        </div>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-10 animate-fade-in">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 mb-2">Welcome back, {{ Auth::user()->first_name ?? Auth::user()->username ?? 'User' }}! 👋</h1>
                    <p class="text-neutral-600">Discover and connect with professionals on Linkup</p>
                </div>
                <div class="flex items-center space-x-2 text-sm text-neutral-500">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->format('l, F j, Y') }}</span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-gradient-to-br from-white to-primary-50 rounded-2xl shadow-sm border border-neutral-200/80 p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-neutral-600 mb-1">Total Connections</p>
                            <p class="text-3xl font-bold text-neutral-900">42</p>
                            <p class="text-xs text-green-600 mt-2">
                                <i class="fas fa-arrow-up mr-1"></i> 12% from last month
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-primary-500/10 to-primary-600/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-primary-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-white to-emerald-50/50 rounded-2xl shadow-sm border border-neutral-200/80 p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-neutral-600 mb-1">Pending Requests</p>
                            <p class="text-3xl font-bold text-neutral-900">5</p>
                            <p class="text-xs text-amber-600 mt-2">
                                <i class="fas fa-clock mr-1"></i> Requires attention
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500/10 to-emerald-600/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-plus text-emerald-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-white to-purple-50/50 rounded-2xl shadow-sm border border-neutral-200/80 p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-neutral-600 mb-1">New This Week</p>
                            <p class="text-3xl font-bold text-neutral-900">12</p>
                            <p class="text-xs text-purple-600 mt-2">
                                <i class="fas fa-bolt mr-1"></i> Trending now
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500/10 to-purple-600/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-bolt text-purple-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Discover Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-neutral-200/80 overflow-hidden">
                <!-- Header -->
                <div class="px-8 py-6 border-b border-neutral-100">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-neutral-900">Discover People</h2>
                            <p class="text-sm text-neutral-600 mt-1">Connect with professionals in your network</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <button id="refreshBtn" class="px-5 py-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-all duration-200 shadow-sm hover:shadow-md flex items-center">
                                <i class="fas fa-sync-alt mr-2"></i> Refresh
                            </button>
                            <form method="GET" action="{{ route('dashboard') }}" class="flex">
                                @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <select name="sort" onchange="this.form.submit()" class="border border-neutral-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 text-sm bg-white shadow-sm">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Recently Added</option>
                                    <option value="alphabetical" {{ request('sort') == 'alphabetical' ? 'selected' : '' }}>Alphabetical</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- User Cards -->
                <div class="p-8">
                    @if($users->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($users as $user)
                        <div class="group border border-neutral-200 rounded-2xl p-6 hover:shadow-lg hover:border-primary-300 transition-all duration-300 bg-white">
                            <!-- User Header -->
                            <div class="flex items-start justify-between mb-5">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center overflow-hidden ring-3 ring-white shadow-sm">
                                            @if($user->profile_picture)
                                            <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                                alt="{{ $user->first_name }}"
                                                class="w-full h-full object-cover">
                                            @else
                                            <i class="fas fa-user text-primary-600 text-2xl"></i>
                                            @endif
                                        </div>
                                        @if($user->is_online)
                                        <div class="absolute bottom-1 right-1 w-4 h-4 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full border-2 border-white shadow-sm"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-neutral-900 text-lg">{{ $user->first_name }} {{ $user->last_name }}</h3>
                                        <p class="text-sm text-neutral-500">@{{ $user->username }}</p>
                                        <div class="flex items-center mt-2">
                                            <i class="fas fa-map-marker-alt text-neutral-400 text-xs mr-2"></i>
                                            <span class="text-xs text-neutral-600">{{ $user->location ?? 'Unknown location' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                @if($user->friend_request_pending)
                                <div class="px-3 py-1.5 bg-amber-50 text-amber-700 rounded-lg text-sm border border-amber-200">
                                    <i class="fas fa-clock mr-1.5"></i>Pending
                                </div>
                                @elseif($user->is_friend)
                                <div class="px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm border border-emerald-200">
                                    <i class="fas fa-check mr-1.5"></i>Connected
                                </div>
                                @else
                                <form action="{{ route('connections.store', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md text-sm font-medium">
                                        <i class="fas fa-user-plus mr-2"></i>Connect
                                    </button>
                                </form>
                                @endif
                            </div>

                            <!-- Bio -->
                            <div class="mb-5">
                                <p class="text-neutral-700 text-sm leading-relaxed line-clamp-2">
                                    {{ $user->bio ?? 'No bio available.' }}
                                </p>
                            </div>

                            <!-- Interests -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                @if($user->interests && count(json_decode($user->interests)) > 0)
                                @foreach(json_decode($user->interests) as $interest)
                                <span class="px-3 py-1.5 bg-gradient-to-r from-primary-50 to-secondary-50 text-primary-700 rounded-full text-xs font-medium border border-primary-200/50">
                                    {{ $interest }}
                                </span>
                                @endforeach
                                @else
                                <span class="px-3 py-1.5 bg-neutral-100 text-neutral-600 rounded-full text-xs">
                                    No interests listed
                                </span>
                                @endif
                            </div>

                            <!-- Stats -->
                            <div class="flex justify-between pt-6 border-t border-neutral-100">
                                <div class="text-center">
                                    <p class="text-xl font-bold text-neutral-900">{{ $user->connections_count ?? 0 }}</p>
                                    <p class="text-xs text-neutral-500 mt-1">Connections</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-xl font-bold text-neutral-900">{{ $user->mutual_friends ?? 0 }}</p>
                                    <p class="text-xs text-neutral-500 mt-1">Mutual</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-xl font-bold text-neutral-900">{{ $user->industry ?? 'N/A' }}</p>
                                    <p class="text-xs text-neutral-500 mt-1">Industry</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10 flex justify-center">
                        <div class="bg-white rounded-xl border border-neutral-200 shadow-sm p-2">
                            {{ $users->links() }}
                        </div>
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gradient-to-br from-primary-50 to-secondary-50 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-primary-50/50">
                            <i class="fas fa-users text-primary-600 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-neutral-900 mb-3">No users found</h3>
                        <p class="text-neutral-600 mb-8 max-w-md mx-auto">We couldn't find anyone matching your search. Try adjusting your filters or search terms.</p>
                        <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md font-medium inline-flex items-center">
                            <i class="fas fa-sync-alt mr-3"></i>Clear Search
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-12 pt-8 border-t border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center py-6">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <div class="w-6 h-6 bg-gradient-to-br from-primary-500 to-secondary-600 rounded-lg"></div>
                    <span class="text-lg font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">
                        Linkup
                    </span>
                    <span class="text-sm text-neutral-500 ml-2">&copy; {{ date('Y') }} All rights reserved</span>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-sm text-neutral-600 hover:text-primary-600 transition-colors">Privacy Policy</a>
                    <a href="#" class="text-sm text-neutral-600 hover:text-primary-600 transition-colors">Terms of Service</a>
                    <a href="#" class="text-sm text-neutral-600 hover:text-primary-600 transition-colors">Contact</a>
                    <a href="#" class="text-sm text-neutral-600 hover:text-primary-600 transition-colors">Support</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            const button = document.querySelector('#userDropdown button');

            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const refreshBtn = document.getElementById('refreshBtn');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function() {
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Refreshing...';
                    this.disabled = true;
                    
                    setTimeout(() => {
                        window.location.href = "{{ route('dashboard') }}";
                    }, 500);
                });
            }
        });
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #0ea5e9, #8b5cf6);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #0284c7, #7c3aed);
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        }
    </style>
</body>

</html>
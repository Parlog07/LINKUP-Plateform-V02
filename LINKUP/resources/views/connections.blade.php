<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Network - Linkup</title>

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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                    <a href="{{ route('dashboard') }}" class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50">
                        <i class="fas fa-compass mr-2"></i>Discover
                    </a>
                    <a href="{{ route('connections') }}" class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 bg-primary-50 text-primary-600 shadow-sm">
                        <i class="fas fa-user-friends mr-2"></i>Connections
                    </a>
                    <a href="{{ route('posts.index')}}" class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50">
                        <i class="fas fa-edit mr-2"></i>Posts
                    </a>
                    <a href="#" class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50 relative">
                        <i class="fas fa-envelope mr-2"></i>Messages
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-blue-500 text-white text-xs rounded-full flex items-center justify-center">2</span>
                    </a>
                </nav>

                <!-- User Profile -->
                <div class="flex items-center">
                    <div class="flex items-center space-x-3 group cursor-pointer">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center overflow-hidden ring-2 ring-white ring-offset-1 ring-offset-primary-50">
                            @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user text-primary-600"></i>
                            @endif
                        </div>
                        <span class="hidden md:block text-sm font-medium text-neutral-700">{{ Auth::user()->first_name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'friends' }">
        
        <!-- Page Header -->
        <div class="mb-10 animate-fade-in">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 mb-3">My Network</h1>
                    <p class="text-neutral-600">Manage your professional connections and requests</p>
                </div>
                <a href="{{ route('dashboard') }}" class="mt-4 sm:mt-0 px-5 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Find New Connections
                </a>
            </div>
            
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-gradient-to-br from-white to-primary-50 rounded-2xl shadow-sm border border-neutral-200/80 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-neutral-600 mb-1">Total Connections</p>
                            <p class="text-3xl font-bold text-neutral-900">{{ $friends->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500/10 to-primary-600/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-primary-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-white to-emerald-50/50 rounded-2xl shadow-sm border border-neutral-200/80 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-neutral-600 mb-1">Pending Requests</p>
                            <p class="text-3xl font-bold text-neutral-900">{{ $receivedRequests->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500/10 to-emerald-600/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-plus text-emerald-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-white to-amber-50/50 rounded-2xl shadow-sm border border-neutral-200/80 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-neutral-600 mb-1">Sent Requests</p>
                            <p class="text-3xl font-bold text-neutral-900">{{ $sentRequests->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-500/10 to-amber-600/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-paper-plane text-amber-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-white rounded-2xl shadow-sm border border-neutral-200/80 mb-8">
                <div class="flex overflow-x-auto">
                    <button @click="activeTab = 'friends'" 
                            :class="activeTab === 'friends' ? 'border-primary-500 text-primary-600 bg-primary-50' : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50'"
                            class="flex-1 flex items-center justify-center px-6 py-4 border-b-2 font-medium text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fas fa-users mr-3 text-lg"></i>
                        <span>My Connections</span>
                        <span class="ml-3 py-1 px-3 rounded-full text-xs font-medium bg-primary-100 text-primary-700">{{ $friends->count() }}</span>
                    </button>

                    <button @click="activeTab = 'received'" 
                            :class="activeTab === 'received' ? 'border-emerald-500 text-emerald-600 bg-emerald-50' : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50'"
                            class="flex-1 flex items-center justify-center px-6 py-4 border-b-2 font-medium text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fas fa-inbox mr-3 text-lg"></i>
                        <span>Received</span>
                        @if($receivedRequests->count() > 0)
                            <span class="ml-3 py-1 px-3 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">{{ $receivedRequests->count() }}</span>
                        @endif
                    </button>

                    <button @click="activeTab = 'sent'" 
                            :class="activeTab === 'sent' ? 'border-amber-500 text-amber-600 bg-amber-50' : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50'"
                            class="flex-1 flex items-center justify-center px-6 py-4 border-b-2 font-medium text-sm transition-all duration-200 whitespace-nowrap">
                        <i class="fas fa-paper-plane mr-3 text-lg"></i>
                        <span>Sent</span>
                        <span class="ml-3 py-1 px-3 rounded-full text-xs font-medium bg-amber-100 text-amber-700">{{ $sentRequests->count() }}</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-8 bg-gradient-to-r from-emerald-50 to-emerald-100 border border-emerald-200 rounded-2xl p-5 animate-fade-in">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-emerald-600"></i>
                    </div>
                    <div>
                        <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- My Connections Tab -->
        <div x-show="activeTab === 'friends'" class="animate-fade-in">
            @if($friends->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($friends as $friend)
                        <div class="group bg-white rounded-2xl shadow-sm border border-neutral-200/80 p-6 hover:shadow-lg hover:border-primary-300 transition-all duration-300">
                            <div class="flex flex-col items-center text-center mb-5">
                                <div class="relative mb-4">
                                    <div class="w-20 h-20 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center overflow-hidden ring-4 ring-white shadow-md">
                                        @if($friend->profile_picture)
                                            <img src="{{ asset('storage/' . $friend->profile_picture) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user text-primary-600 text-2xl"></i>
                                        @endif
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full border-2 border-white flex items-center justify-center">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                </div>
                                <h3 class="font-bold text-neutral-900 text-lg mb-1">{{ $friend->first_name }} {{ $friend->last_name }}</h3>
                                <p class="text-sm text-neutral-500 mb-2">@{{ $friend->username }}</p>
                                <span class="px-3 py-1 bg-primary-50 text-primary-700 rounded-full text-xs font-medium border border-primary-200/50">
                                    {{ $friend->industry ?? 'Professional' }}
                                </span>
                            </div>
                            
                            <div class="flex space-x-3 border-t border-neutral-100 pt-5">
                                <button class="flex-1 py-2.5 px-4 bg-white border border-neutral-200 rounded-xl text-sm font-medium text-neutral-700 hover:bg-neutral-50 hover:border-neutral-300 transition-all duration-200 flex items-center justify-center">
                                    <i class="fas fa-comment-dots mr-2"></i>
                                    Message
                                </button>
                                <form action="{{ route('connection.remove', $friend->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to remove this connection?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full py-2.5 px-4 bg-red-50 border border-red-100 rounded-xl text-sm font-medium text-red-600 hover:bg-red-100 hover:border-red-200 transition-all duration-200 flex items-center justify-center">
                                        <i class="fas fa-user-minus mr-2"></i>
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-neutral-200/80">
                    <div class="w-24 h-24 bg-gradient-to-br from-primary-50 to-secondary-50 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-primary-50/50">
                        <i class="fas fa-users text-primary-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-neutral-900 mb-3">No connections yet</h3>
                    <p class="text-neutral-600 mb-8 max-w-md mx-auto">Start building your professional network by connecting with colleagues and peers.</p>
                    <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md font-medium inline-flex items-center">
                        <i class="fas fa-search mr-3"></i>Find People to Connect
                    </a>
                </div>
            @endif
        </div>

        <!-- Received Requests Tab -->
        <div x-show="activeTab === 'received'" class="animate-fade-in" style="display: none;">
            @if($receivedRequests->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-neutral-200/80 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-100">
                        <div class="flex items-center">
                            <i class="fas fa-user-clock text-emerald-600 mr-3"></i>
                            <h3 class="text-lg font-bold text-neutral-900">Connection Requests</h3>
                            <span class="ml-3 py-1 px-3 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">{{ $receivedRequests->count() }} pending</span>
                        </div>
                    </div>
                    <ul class="divide-y divide-neutral-100">
                        @foreach($receivedRequests as $request)
                            <li class="p-6 flex items-center justify-between hover:bg-neutral-50/50 transition-all duration-200">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-full flex items-center justify-center overflow-hidden mr-4 ring-2 ring-white shadow-sm">
                                            @if($request->profile_picture)
                                                <img src="{{ asset('storage/' . $request->profile_picture) }}" class="w-full h-full object-cover">
                                            @else
                                                <i class="fas fa-user text-emerald-600"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-bold text-neutral-900">{{ $request->first_name }} {{ $request->last_name }}</h4>
                                        <div class="flex items-center mt-1">
                                            <span class="text-sm text-neutral-600">{{ $request->industry ?? 'Professional' }}</span>
                                            <span class="mx-2 text-neutral-300">•</span>
                                            <span class="text-xs text-neutral-500">Sent {{ $request->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex space-x-3">
                                    <form action="{{ route('connection.accept', $request->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:from-emerald-600 hover:to-emerald-700 transition-all duration-200 shadow-sm hover:shadow-md text-sm font-medium flex items-center">
                                            <i class="fas fa-check mr-2"></i> Accept
                                        </button>
                                    </form>
                                    <form action="{{ route('connection.reject', $request->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-5 py-2.5 bg-white border border-neutral-200 text-neutral-700 rounded-xl hover:bg-neutral-50 hover:border-neutral-300 transition-all duration-200 text-sm font-medium flex items-center">
                                            <i class="fas fa-times mr-2"></i> Decline
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-neutral-200/80">
                    <div class="w-24 h-24 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-emerald-50/50">
                        <i class="fas fa-inbox text-emerald-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-neutral-900 mb-3">No pending requests</h3>
                    <p class="text-neutral-600 mb-8 max-w-md mx-auto">You're all caught up! Check back later for new connection requests.</p>
                </div>
            @endif
        </div>

        <!-- Sent Requests Tab -->
        <div x-show="activeTab === 'sent'" class="animate-fade-in" style="display: none;">
            @if($sentRequests->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-neutral-200/80 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-100">
                        <div class="flex items-center">
                            <i class="fas fa-hourglass-half text-amber-600 mr-3"></i>
                            <h3 class="text-lg font-bold text-neutral-900">Pending Sent Requests</h3>
                            <span class="ml-3 py-1 px-3 rounded-full text-xs font-medium bg-amber-100 text-amber-700">{{ $sentRequests->count() }} waiting</span>
                        </div>
                    </div>
                    <ul class="divide-y divide-neutral-100">
                        @foreach($sentRequests as $request)
                            <li class="p-6 flex items-center justify-between hover:bg-neutral-50/50 transition-all duration-200">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <div class="w-14 h-14 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full flex items-center justify-center overflow-hidden mr-4 ring-2 ring-white shadow-sm">
                                            @if($request->profile_picture)
                                                <img src="{{ asset('storage/' . $request->profile_picture) }}" class="w-full h-full object-cover">
                                            @else
                                                <i class="fas fa-user text-amber-600"></i>
                                            @endif
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-gradient-to-r from-amber-400 to-amber-500 rounded-full border-2 border-white flex items-center justify-center">
                                            <i class="fas fa-clock text-white text-xs"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-bold text-neutral-900">{{ $request->first_name }} {{ $request->last_name }}</h4>
                                        <div class="flex items-center mt-1">
                                            <span class="text-sm text-neutral-600">{{ $request->industry ?? 'Professional' }}</span>
                                            <span class="mx-2 text-neutral-300">•</span>
                                            <span class="text-xs text-neutral-500">Sent {{ $request->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <form action="{{ route('connection.cancel', $request->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-5 py-2.5 bg-white border border-neutral-200 text-neutral-700 rounded-xl hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-all duration-200 text-sm font-medium flex items-center">
                                            <i class="fas fa-times mr-2"></i> Cancel Request
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-neutral-200/80">
                    <div class="w-24 h-24 bg-gradient-to-br from-amber-50 to-orange-50 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-amber-50/50">
                        <i class="fas fa-paper-plane text-amber-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-neutral-900 mb-3">No sent requests</h3>
                    <p class="text-neutral-600 mb-8 max-w-md mx-auto">You haven't sent any connection requests yet.</p>
                    <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md font-medium inline-flex items-center">
                        <i class="fas fa-search mr-3"></i>Discover People
                    </a>
                </div>
            @endif
        </div>

        <!-- Footer Note -->
        <div class="mt-12 pt-8 border-t border-neutral-200 text-center">
            <p class="text-sm text-neutral-600">
                <i class="fas fa-lightbulb text-amber-500 mr-2"></i>
                Tip: Regularly review and manage your connections to keep your network strong
            </p>
        </div>

    </main>

    <!-- Custom Styles -->
    <style>
        /* Smooth transitions */
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
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

        /* Selection */
        ::selection {
            background: rgba(14, 165, 233, 0.2);
        }
    </style>

    <!-- Alpine.js Initialization -->
    <script>
        document.addEventListener('alpine:init', () => {
            // You can add Alpine.js custom functions here if needed
        });
    </script>
</body>
</html>
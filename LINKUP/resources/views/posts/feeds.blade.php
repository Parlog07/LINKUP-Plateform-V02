<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Global Feed - Linkup</title>

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
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50">
                        <i class="fas fa-compass mr-2"></i>Discover
                    </a>
                    <a href="{{ route('connections') }}"
                        class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50">
                        <i class="fas fa-user-friends mr-2"></i>Connections
                    </a>
                    <a href="{{ route('posts.store') }}"
                        class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50">
                        <i class="fas fa-edit mr-2"></i>Posts
                    </a>
                    <a href="{{ route('posts.feeds') }}"
                        class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 bg-primary-50 text-primary-600 shadow-sm">
                        <i class="fas fa-newspaper mr-2"></i>Feed
                    </a>
                    <a href="#" class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50 relative">
                        <i class="fas fa-envelope mr-2"></i>Messages
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-blue-500 text-white text-xs rounded-full flex items-center justify-center">2</span>
                    </a>
                    <a href="#" class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 text-neutral-600 hover:text-primary-600 hover:bg-primary-50/50 relative">
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
                                    placeholder="Search posts..."
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
                                <span class="text-sm font-medium text-neutral-800">{{ Auth::user()->first_name }}</span>
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
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8 animate-fade-in">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 mb-2">Global Feed</h1>
                    <p class="text-neutral-600">Discover approved posts from your network</p>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center space-x-2 px-3 py-1.5 bg-primary-50 rounded-full">
                        <i class="fas fa-check-circle text-primary-600"></i>
                        <span class="text-sm font-medium text-primary-700">Approved Posts Only</span>
                    </div>
                </div>
            </div>

            <!-- Create Post Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-neutral-200/80 p-6 mb-8 hover:shadow-md transition-all duration-300">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center overflow-hidden ring-3 ring-white shadow-md">
                            @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="w-full h-full object-cover">
                            @else
                            <i class="fas fa-user text-primary-600 text-xl"></i>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1 w-full" x-data="{ fileName: '' }">
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <textarea name="content" rows="3"
                                class="w-full border-none focus:ring-0 text-neutral-800 text-lg resize-none p-0 placeholder-neutral-400 bg-transparent focus:outline-none"
                                placeholder="What's happening, {{ Auth::user()->first_name }}? Share your thoughts..."></textarea>

                            <div x-show="fileName" class="text-sm text-primary-600 mt-3 flex items-center bg-primary-50 w-fit px-3 py-2 rounded-xl border border-primary-100">
                                <i class="fas fa-paperclip mr-2"></i>
                                <span x-text="fileName" class="font-medium"></span>
                                <button @click="fileName = ''" class="ml-3 text-neutral-400 hover:text-neutral-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <div class="mt-6 flex items-center justify-between pt-6 border-t border-neutral-100">
                                <div class="flex space-x-4">
                                    <label class="cursor-pointer flex items-center px-4 py-2 rounded-xl text-neutral-600 hover:bg-primary-50 hover:text-primary-600 transition-all duration-200 group">
                                        <i class="fas fa-image text-xl mr-3 text-green-500 group-hover:scale-110 transition-transform"></i>
                                        <span class="text-sm font-medium">Photo/Video</span>
                                        <input type="file" name="media" class="hidden" @change="fileName = $event.target.files[0].name">
                                    </label>
                                </div>
                                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-medium rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-paper-plane mr-2"></i> Post
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Pending Posts Notice -->
            <div class="space-y-6 mb-8">
                @foreach($posts as $post)
                    @if ($post->status === 'pending' && auth()->id() === $post->user_id)
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-5 flex items-center animate-fade-in">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-clock text-amber-600 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-amber-800 mb-1">Post Under Review</h4>
                            <p class="text-sm text-amber-700">Your post "<span class="font-medium">{{ Str::limit($post->content, 50) }}</span>" is pending approval</p>
                            <p class="text-xs text-amber-600 mt-1">It will appear here once approved by moderators</p>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-6 bg-gradient-to-r from-emerald-50 to-emerald-100 border border-emerald-200 rounded-2xl p-5 animate-fade-in">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Approved Posts Feed -->
        <div class="space-y-6">
            @php
                $approvedPosts = $posts->where('status', 'approved');
            @endphp

            @foreach($approvedPosts as $post)
            <div class="bg-white rounded-2xl shadow-sm border border-neutral-200/80 overflow-hidden hover:shadow-lg transition-all duration-300 animate-fade-in"
                 x-data="{ showComments: false }">

                <!-- Post Header -->
                <div class="p-6">
                    <div class="flex items-start justify-between mb-5">
                        <div class="flex items-center">
                            <div class="relative">
                                <div class="w-14 h-14 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center overflow-hidden ring-3 ring-white shadow-md">
                                    @if($post->user->profile_picture)
                                    <img src="{{ asset('storage/' . $post->user->profile_picture) }}" class="w-full h-full object-cover">
                                    @else
                                    <i class="fas fa-user text-primary-600 text-xl"></i>
                                    @endif
                                </div>
                                @if($post->user->is_online)
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full border-2 border-white"></div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="flex items-center space-x-2">
                                    <p class="text-base font-bold text-neutral-900">{{ $post->user->first_name }} {{ $post->user->last_name }}</p>
                                    <span class="text-xs px-2 py-1 bg-primary-50 text-primary-700 rounded-full font-medium">
                                        {{ $post->user->industry ?? 'Professional' }}
                                    </span>
                                    <span class="text-xs px-2 py-1 bg-emerald-50 text-emerald-700 rounded-full font-medium flex items-center">
                                        <i class="fas fa-check-circle text-xs mr-1"></i> Approved
                                    </span>
                                </div>
                                <div class="flex items-center mt-1 text-sm text-neutral-500">
                                    <i class="fas fa-clock mr-1"></i>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-globe-americas mr-1"></i>
                                    <span>Public</span>
                                </div>
                            </div>
                        </div>

                        <!-- Post Options -->
                        @if(Auth::id() === $post->user_id)
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 rounded-full text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 ring-1 ring-black ring-opacity-5 z-10 border border-neutral-200 animate-fade-in animate-slide-up" style="display: none;">
                                <a href="{{ route('posts.edit', $post->id) }}" class="flex items-center px-4 py-2.5 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                    <i class="fas fa-edit mr-3 text-sm"></i> Edit Post
                                </a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors" onclick="return confirm('Delete this post?')">
                                        <i class="fas fa-trash-alt mr-3 text-sm"></i> Delete Post
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Post Content -->
                    @if($post->content)
                    <p class="text-neutral-800 mb-6 whitespace-pre-wrap leading-relaxed text-base">{{ $post->content }}</p>
                    @endif

                    <!-- Media Content -->
                    @if($post->media_path)
                    <div class="rounded-xl overflow-hidden border border-neutral-100 shadow-sm mt-4">
                        @if($post->media_type == 'video')
                        <video controls class="w-full max-h-[500px] object-cover bg-black rounded-lg">
                            <source src="{{ asset('storage/' . $post->media_path) }}">
                            Your browser does not support the video tag.
                        </video>
                        @else
                        <img src="{{ asset('storage/' . $post->media_path) }}" alt="Post image" class="w-full max-h-[500px] object-cover rounded-lg">
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Post Stats -->
                <div class="px-6 py-3 bg-neutral-50/50 border-t border-neutral-100 flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <button type="button" onclick="toggleLike( {{ $post->id }}, this)"
                                class="flex items-center space-x-2 transition-all duration-200 group {{ $post->isLikedBy(Auth::user()) ? 'text-red-500' : 'text-neutral-500 hover:text-red-500' }}">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center group-hover:bg-red-50/50 transition-colors">
                                <i class="{{ $post->isLikedBy(Auth::user()) ? 'fas' : 'far' }} fa-heart text-xl"></i>
                            </div>
                            <span class="text-sm font-medium likes-count">
                                {{ $post->likes_count > 0 ? $post->likes_count : 'Like' }}
                            </span>
                        </button>

                        <button @click="showComments = !showComments"
                                class="flex items-center space-x-2 text-neutral-500 hover:text-primary-600 transition-all duration-200 group">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center group-hover:bg-primary-50/50 transition-colors">
                                <i class="far fa-comment-alt text-xl"></i>
                            </div>
                            <span class="text-sm font-medium">
                                {{ $post->comments_count > 0 ? $post->comments_count : 'Comment' }}
                            </span>
                        </button>

                        <button class="flex items-center space-x-2 text-neutral-500 hover:text-green-600 transition-all duration-200 group">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center group-hover:bg-green-50/50 transition-colors">
                                <i class="fas fa-share text-xl"></i>
                            </div>
                            <span class="text-sm font-medium">Share</span>
                        </button>
                    </div>
                </div>

                <!-- Comments Section -->
                <div x-show="showComments" class="bg-neutral-50/30 border-t border-neutral-100 p-6" style="display: none;">

                    <!-- Add Comment Form -->
                    <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="flex items-start space-x-4 mb-6">
                        @csrf
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex-shrink-0 overflow-hidden ring-2 ring-white shadow-sm">
                            @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="w-full h-full object-cover">
                            @else
                            <i class="fas fa-user text-primary-600 p-2"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="text" name="content" placeholder="Write a comment..."
                                   class="w-full px-5 py-3 bg-white border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 text-sm shadow-sm">
                        </div>
                    </form>

                    <!-- Comments List -->
                    @if($post->comments->count() > 0)
                    <div class="space-y-5">
                        @foreach($post->comments as $comment)
                        <div class="flex space-x-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex-shrink-0 overflow-hidden ring-2 ring-white">
                                @if($comment->user->profile_picture)
                                <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" class="w-full h-full object-cover">
                                @else
                                <i class="fas fa-user text-gray-500 p-2"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-neutral-100">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="text-sm font-bold text-neutral-900">{{ $comment->user->first_name }} {{ $comment->user->last_name }}</p>
                                            <span class="text-xs text-neutral-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if(Auth::id() === $comment->user_id)
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-neutral-400 hover:text-red-500">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                    <p class="text-sm text-neutral-700">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <div class="w-16 h-16 bg-neutral-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-comment-slash text-neutral-400 text-xl"></i>
                        </div>
                        <p class="text-sm text-neutral-500 font-medium">No comments yet</p>
                        <p class="text-xs text-neutral-400 mt-1">Be the first to comment</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach

            <!-- Empty State -->
            @if($approvedPosts->count() == 0)
            <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-neutral-200/80">
                <div class="w-24 h-24 bg-gradient-to-br from-primary-50 to-secondary-50 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-primary-50/50">
                    <i class="fas fa-newspaper text-primary-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-neutral-900 mb-3">No approved posts yet</h3>
                <p class="text-neutral-600 mb-8 max-w-md mx-auto">Share something with your network! Your posts will appear here once approved.</p>
            </div>
            @endif

            <!-- Pagination -->
            @if($posts->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-xl border border-neutral-200 shadow-sm p-2">
                    {{ $posts->links() }}
                </div>
            </div>
            @endif
        </div>

        <!-- Pending Posts Indicator -->
        @php
            $pendingCount = $posts->where('status', 'pending')->where('user_id', auth()->id())->count();
        @endphp
        @if($pendingCount > 0)
        <div class="mt-12 pt-8 border-t border-neutral-200">
            <div class="flex items-center justify-center space-x-2">
                <div class="w-5 h-5 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full animate-pulse-subtle"></div>
                <p class="text-sm text-neutral-600">
                    You have <span class="font-bold text-amber-600">{{ $pendingCount }}</span> post(s) pending approval
                </p>
            </div>
        </div>
        @endif
    </main>

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

        async function toggleLike(postId, buttonElement) {
            try {
                const response = await fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    // Update the count text
                    const countSpan = buttonElement.querySelector('.likes-count');
                    countSpan.innerText = data.likes_count > 0 ? data.likes_count : 'Like';

                    // Toggle colors/icons
                    const icon = buttonElement.querySelector('i');
                    if (data.status === 'liked') {
                        buttonElement.classList.add('text-red-500');
                        buttonElement.classList.remove('text-neutral-500');
                        icon.classList.replace('far', 'fas');
                    } else {
                        buttonElement.classList.remove('text-red-500');
                        buttonElement.classList.add('text-neutral-500');
                        icon.classList.replace('fas', 'far');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    </script>

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

        /* Custom textarea resizing */
        textarea {
            min-height: 80px;
        }

        /* Smooth fade-in for new posts */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Status badge animation */
        @keyframes statusPulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .status-approved {
            animation: statusPulse 2s ease-in-out infinite;
        }
    </style>
</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Connections - Linkup</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased min-h-screen bg-gradient-to-br from-indigo-50 to-purple-50">
    
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-800">Linkup</span>
                    </a>
<div class="hidden md:ml-10 md:flex md:space-x-8">
    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent px-3 py-2 text-sm font-medium">Discover</a>
    <a href="{{ route('connections') }}" class="text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent px-3 py-2 text-sm font-medium">Connections</a>
    <a href="{{ route('posts.index')}}" class="text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent px-3 py-2 text-sm font-medium">Posts</a>
    <a href="#" class="text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent px-3 py-2 text-sm font-medium">Messages</a>
</div>
                </div>
                <div class="flex items-center">
                   <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center overflow-hidden">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-user text-indigo-600"></i>
                        @endif
                   </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'friends' }">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Manage Network</h1>
            
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="activeTab = 'friends'" 
                            :class="activeTab === 'friends' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                        <i class="fas fa-users mr-2"></i>
                        My Connections
                        <span class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium bg-gray-100 text-gray-900">{{ $friends->count() }}</span>
                    </button>

                    <button @click="activeTab = 'received'" 
                            :class="activeTab === 'received' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                        <i class="fas fa-inbox mr-2"></i>
                        Received Requests
                        @if($receivedRequests->count() > 0)
                            <span class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium bg-red-100 text-red-600">{{ $receivedRequests->count() }}</span>
                        @endif
                    </button>

                    <button @click="activeTab = 'sent'" 
                            :class="activeTab === 'sent' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Sent Requests
                        <span class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium bg-gray-100 text-gray-900">{{ $sentRequests->count() }}</span>
                    </button>
                </nav>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-md">
                <div class="flex">
                    <div class="flex-shrink-0"><i class="fas fa-check-circle text-green-400"></i></div>
                    <div class="ml-3"><p class="text-sm text-green-700">{{ session('success') }}</p></div>
                </div>
            </div>
        @endif

        <div x-show="activeTab === 'friends'" class="space-y-6">
            @if($friends->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($friends as $friend)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center overflow-hidden mb-4">
                                @if($friend->image)
                                    <img src="{{ asset('storage/' . $friend->profile_picture) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-user text-indigo-600 text-2xl"></i>
                                @endif
                            </div>
                            <h3 class="font-bold text-gray-900 text-lg">{{ $friend->first_name }} {{ $friend->last_name }}</h3>
                            <p class="text-sm text-gray-500 mb-1">@ {{ $friend->username }}</p>
                            <p class="text-xs text-indigo-600 font-medium bg-indigo-50 px-2 py-1 rounded mb-4">{{ $friend->industry ?? 'Member' }}</p>
                            
                            <div class="flex space-x-3 w-full mt-auto">
                                <button class="flex-1 py-2 px-4 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Message
                                </button>
                                <form action="{{ route('connection.remove', $friend->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to remove this connection?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full py-2 px-4 bg-red-50 border border-transparent rounded-lg text-sm font-medium text-red-600 hover:bg-red-100">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl border border-gray-200 border-dashed">
                    <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">No connections yet</h3>
                    <p class="text-gray-500 mb-6">Start connecting with people to grow your network!</p>
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Find People</a>
                </div>
            @endif
        </div>

        <div x-show="activeTab === 'received'" class="space-y-6" style="display: none;">
            @if($receivedRequests->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <ul class="divide-y divide-gray-200">
                        @foreach($receivedRequests as $request)
                            <li class="p-6 flex items-center justify-between hover:bg-gray-50">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center overflow-hidden mr-4">
                                        @if($request->profile_picture)
                                            <img src="{{ asset('storage/' . $request->profile_picture) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user text-indigo-600"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900">{{ $request->first_name }} {{ $request->last_name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $request->industry ?? 'Member' }} • Sent {{ $request->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <form action="{{ route('connection.accept', $request->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-2 bg-green-100 text-green-600 rounded-full hover:bg-green-200" title="Accept">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('connection.reject', $request->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-full hover:bg-red-200" title="Decline">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl border border-gray-200 border-dashed">
                    <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">No pending requests</h3>
                    <p class="text-gray-500">You're all caught up!</p>
                </div>
            @endif
        </div>

        <div x-show="activeTab === 'sent'" class="space-y-6" style="display: none;">
            @if($sentRequests->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <ul class="divide-y divide-gray-200">
                        @foreach($sentRequests as $request)
                            <li class="p-6 flex items-center justify-between hover:bg-gray-50">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden mr-4">
                                        @if($request->profile_picture)
                                            <img src="{{ asset('storage/' . $request->profile_picture) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900">{{ $request->first_name }} {{ $request->last_name }}</h4>
                                        <p class="text-xs text-gray-500">Request sent {{ $request->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div>
                                    <form action="{{ route('connection.cancel', $request->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-gray-500 hover:text-red-600 font-medium">
                                            Cancel Request
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl border border-gray-200 border-dashed">
                    <i class="fas fa-paper-plane text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">No sent requests</h3>
                    <p class="text-gray-500">Go find some people to connect with!</p>
                </div>
            @endif
        </div>

    </div>

</body>
</html>
<div class="space-y-6">
    <!-- Post Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-neutral-200/80 overflow-hidden hover:shadow-lg transition-all duration-300 animate-fade-in"
         x-data="{ showComments: false, showOptions: false }">
        
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
                        <div class="flex items-center space-x-2 mb-1">
                            <p class="text-base font-bold text-neutral-900">{{ $post->user->first_name }} {{ $post->user->last_name }}</p>
                            <span class="text-xs px-2 py-1 bg-primary-50 text-primary-700 rounded-full font-medium">
                                {{ $post->user->industry ?? 'Professional' }}
                            </span>
                        </div>
                        <div class="flex items-center text-sm text-neutral-500">
                            <i class="fas fa-clock text-xs mr-1"></i>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                            @if($post->status === 'approved')
                            <span class="mx-2">•</span>
                            <i class="fas fa-check-circle text-emerald-500 text-xs mr-1"></i>
                            <span class="text-emerald-600 font-medium">Approved</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Post Options -->
                @if(Auth::id() === $post->user_id)
                <div class="relative">
                    <button @click="showOptions = !showOptions" class="p-2 rounded-full text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div x-show="showOptions" @click.away="showOptions = false" 
                         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 ring-1 ring-black ring-opacity-5 z-10 border border-neutral-200 animate-fade-in animate-slide-up" 
                         style="display: none;">
                        <a href="{{ route('posts.edit', $post->id) }}" 
                           class="flex items-center px-4 py-2.5 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                            <div class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-edit text-primary-600 text-sm"></i>
                            </div>
                            Edit Post
                        </a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this post?')"
                                    class="flex items-center w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-trash-alt text-red-600 text-sm"></i>
                                </div>
                                Delete Post
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>

            <!-- Post Content -->
            @if($post->content)
            <div class="mb-6">
                <p class="text-neutral-800 whitespace-pre-wrap leading-relaxed text-base">{{ $post->content }}</p>
            </div>
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
                <img src="{{ asset('storage/' . $post->media_path) }}" 
                     alt="Post image" 
                     class="w-full max-h-[500px] object-cover rounded-lg hover:scale-[1.02] transition-transform duration-300 cursor-zoom-in">
                @endif
            </div>
            @endif

            <!-- Post Status Badge -->
            @if($post->status === 'pending' && auth()->id() === $post->user_id)
            <div class="mt-4 flex items-center p-3 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl">
                <div class="w-8 h-8 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-clock text-amber-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-amber-800">Post Under Review</p>
                    <p class="text-xs text-amber-600">Your post is pending approval and will appear publicly once approved.</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Post Stats & Actions -->
        <div class="px-6 py-3 bg-neutral-50/50 border-t border-neutral-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <!-- Like Button -->
                    <button type="button" 
                            onclick="toggleLike({{ $post->id }}, this)" 
                            class="flex items-center space-x-2 transition-all duration-200 group {{ $post->isLikedBy(Auth::user()) ? 'text-red-500' : 'text-neutral-500 hover:text-red-500' }}">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center group-hover:bg-red-50/50 transition-colors">
                            <i class="{{ $post->isLikedBy(Auth::user()) ? 'fas' : 'far' }} fa-heart text-xl"></i>
                        </div>
                        <span class="text-sm font-medium likes-count">
                            {{ $post->likes_count > 0 ? $post->likes_count : 'Like' }}
                        </span>
                    </button>

                    <!-- Comment Button -->
                    <button @click="showComments = !showComments" 
                            class="flex items-center space-x-2 text-neutral-500 hover:text-primary-600 transition-all duration-200 group">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center group-hover:bg-primary-50/50 transition-colors">
                            <i class="far fa-comment-alt text-xl"></i>
                        </div>
                        <span class="text-sm font-medium">
                            {{ $post->comments_count > 0 ? $post->comments_count : 'Comment' }}
                        </span>
                    </button>

                    <!-- Share Button -->
                    <button class="flex items-center space-x-2 text-neutral-500 hover:text-green-600 transition-all duration-200 group">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center group-hover:bg-green-50/50 transition-colors">
                            <i class="fas fa-share text-xl"></i>
                        </div>
                        <span class="text-sm font-medium">Share</span>
                    </button>
                </div>

                <!-- View Count -->
                <div class="text-xs text-neutral-400 flex items-center">
                    <i class="fas fa-eye mr-1"></i>
                    <span>1.2k views</span>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div x-show="showComments" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             class="bg-neutral-50/30 border-t border-neutral-100 p-6" 
             style="display: none;">
            
            <!-- Add Comment Form -->
            <div class="mb-6">
                <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="flex items-start space-x-4">
                    @csrf
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center overflow-hidden ring-2 ring-white shadow-sm">
                            @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="w-full h-full object-cover">
                            @else
                            <i class="fas fa-user text-primary-600 p-2"></i>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   name="content" 
                                   placeholder="Write a comment..." 
                                   class="w-full px-5 py-3 bg-white border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 text-sm shadow-sm pr-12">
                            <button type="submit" 
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 text-primary-600 hover:text-primary-700 transition-colors">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Comments List -->
            <div class="space-y-4">
                @if($post->comments->count() > 0)
                    @foreach($post->comments as $comment)
                    <div class="flex space-x-4 group hover:bg-white/50 p-2 rounded-xl transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center overflow-hidden ring-2 ring-white">
                                @if($comment->user->profile_picture)
                                <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" class="w-full h-full object-cover">
                                @else
                                <i class="fas fa-user text-gray-500 p-2"></i>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-neutral-100 group-hover:border-primary-100 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-sm font-bold text-neutral-900">{{ $comment->user->first_name }} {{ $comment->user->last_name }}</p>
                                        <span class="text-xs text-neutral-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if(Auth::id() === $comment->user_id)
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Delete this comment?')"
                                                class="text-xs text-neutral-400 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                <p class="text-sm text-neutral-700 leading-relaxed">{{ $comment->content }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                <!-- Empty Comments State -->
                <div class="text-center py-6">
                    <div class="w-16 h-16 bg-neutral-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-comment-slash text-neutral-400 text-xl"></i>
                    </div>
                    <p class="text-sm text-neutral-500 font-medium mb-1">No comments yet</p>
                    <p class="text-xs text-neutral-400">Be the first to share your thoughts!</p>
                </div>
                @endif
            </div>

            <!-- Load More Comments -->
            @if($post->comments_count > 5)
            <div class="mt-6 text-center">
                <button class="text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center justify-center mx-auto">
                    <i class="fas fa-chevron-down mr-2"></i>
                    Load more comments ({{ $post->comments_count - 5 }} more)
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Custom transitions for Alpine.js */
    [x-cloak] { display: none !important; }
    
    /* Smooth animations */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Custom focus styles */
    input:focus, textarea:focus, button:focus {
        outline: 2px solid transparent;
        outline-offset: 2px;
    }
    
    /* Hover effects for interactive elements */
    .hover-lift:hover {
        transform: translateY(-2px);
    }
    
    /* Image zoom effect */
    .hover-zoom {
        transition: transform 0.3s ease;
    }
    
    .hover-zoom:hover {
        transform: scale(1.02);
    }
    
    /* Gradient text */
    .gradient-text {
        background: linear-gradient(135deg, #0ea5e9 0%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Custom scrollbar for comments */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #0ea5e9, #8b5cf6);
        border-radius: 3px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #0284c7, #7c3aed);
    }
</style>

<script>
    // Enhanced toggleLike function with better UX
    async function toggleLike(postId, buttonElement) {
        try {
            const likeIcon = buttonElement.querySelector('i');
            const likeCount = buttonElement.querySelector('.likes-count');
            
            // Add loading state
            buttonElement.classList.add('opacity-50', 'cursor-not-allowed');
            
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
                // Update the count text with animation
                likeCount.innerText = data.likes_count > 0 ? data.likes_count : 'Like';
                
                // Add animation effect
                likeIcon.classList.add('scale-125');
                setTimeout(() => {
                    likeIcon.classList.remove('scale-125');
                }, 300);

                // Toggle colors/icons
                if (data.status === 'liked') {
                    buttonElement.classList.add('text-red-500');
                    buttonElement.classList.remove('text-neutral-500');
                    likeIcon.classList.replace('far', 'fas');
                } else {
                    buttonElement.classList.remove('text-red-500');
                    buttonElement.classList.add('text-neutral-500');
                    likeIcon.classList.replace('fas', 'far');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            // Show error feedback
            buttonElement.classList.add('shake-animation');
            setTimeout(() => {
                buttonElement.classList.remove('shake-animation');
            }, 500);
        } finally {
            // Remove loading state
            buttonElement.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
    
    // Shake animation for error feedback
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .shake-animation {
            animation: shake 0.5s ease-in-out;
        }
    `;
    document.head.appendChild(style);
</script>
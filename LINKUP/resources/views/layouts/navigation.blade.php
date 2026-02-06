<div class="space-y-6">
    <!-- Post Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-neutral-200/80 overflow-hidden hover:shadow-lg transition-all duration-300 animate-fade-in group/post"
         x-data="{ 
             showComments: false, 
             showOptions: false,
             isLiked: {{ $post->isLikedBy(Auth::user()) ? 'true' : 'false' }},
             likesCount: {{ $post->likes_count }},
             commentsCount: {{ $post->comments_count }}
         }">
        
        <!-- Post Header -->
        <div class="p-6">
            <div class="flex items-start justify-between mb-5">
                <div class="flex items-center group">
                    <div class="relative">
                        <a href="#" class="block">
                            <div class="w-14 h-14 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center overflow-hidden ring-3 ring-white shadow-md group-hover:ring-primary-200 transition-all duration-300">
                                @if($post->user->profile_picture)
                                <img src="{{ asset('storage/' . $post->user->profile_picture) }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                @else
                                <i class="fas fa-user text-primary-600 text-xl"></i>
                                @endif
                            </div>
                        </a>
                        @if($post->user->is_online)
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full border-2 border-white shadow-sm"></div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <div class="flex items-center space-x-2 mb-1">
                            <a href="#" class="group/name">
                                <p class="text-base font-bold text-neutral-900 group-hover/name:text-primary-600 transition-colors">
                                    {{ $post->user->first_name }} {{ $post->user->last_name }}
                                </p>
                            </a>
                            <span class="text-xs px-2.5 py-1 bg-gradient-to-r from-primary-50 to-secondary-50 text-primary-700 rounded-full font-medium border border-primary-200/50">
                                {{ $post->user->industry ?? 'Professional' }}
                            </span>
                        </div>
                        <div class="flex items-center text-sm text-neutral-500">
                            <i class="fas fa-clock text-xs mr-1.5"></i>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                            @if($post->status === 'approved')
                            <span class="mx-2.5 text-neutral-300">•</span>
                            <div class="flex items-center px-2 py-1 bg-gradient-to-r from-emerald-50 to-green-50 rounded-full border border-emerald-200/50">
                                <i class="fas fa-check-circle text-emerald-500 text-xs mr-1.5"></i>
                                <span class="text-xs font-medium text-emerald-700">Approved</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Post Options -->
                @if(Auth::id() === $post->user_id)
                <div class="relative">
                    <button @click="showOptions = !showOptions" 
                            class="p-2 rounded-full text-neutral-400 hover:text-neutral-700 hover:bg-neutral-100 transition-all duration-200 group/options">
                        <i class="fas fa-ellipsis-h group-hover/options:scale-110 transition-transform"></i>
                    </button>
                    <div x-show="showOptions" @click.away="showOptions = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-2 z-10 border border-neutral-200/80 backdrop-blur-sm bg-white/95">
                        <a href="{{ route('posts.edit', $post->id) }}" 
                           class="flex items-center px-4 py-3 text-sm text-neutral-700 hover:bg-primary-50 hover:text-primary-600 transition-all duration-200 group/edit">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary-50 to-primary-100 rounded-lg flex items-center justify-center mr-3 group-hover/edit:scale-110 transition-transform">
                                <i class="fas fa-edit text-primary-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium">Edit Post</p>
                                <p class="text-xs text-neutral-500">Update your post content</p>
                            </div>
                        </a>
                        <div class="border-t border-neutral-100 my-1"></div>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this post?')"
                                    class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-all duration-200 group/delete">
                                <div class="w-8 h-8 bg-gradient-to-br from-red-50 to-red-100 rounded-lg flex items-center justify-center mr-3 group-hover/delete:scale-110 transition-transform">
                                    <i class="fas fa-trash-alt text-red-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Delete Post</p>
                                    <p class="text-xs text-red-500/80">Remove permanently</p>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>

            <!-- Post Content -->
            @if($post->content)
            <div class="mb-6 relative">
                <div class="absolute -left-4 top-0 bottom-0 w-1 bg-gradient-to-b from-primary-500 to-secondary-600 rounded-full opacity-0 group-hover/post:opacity-100 transition-opacity duration-300"></div>
                <p class="text-neutral-800 whitespace-pre-wrap leading-relaxed text-base pl-2">{{ $post->content }}</p>
            </div>
            @endif

            <!-- Media Content -->
            @if($post->media_path)
            <div class="rounded-xl overflow-hidden border border-neutral-100 shadow-sm mt-4 group/media relative">
                @if($post->media_type == 'video')
                <div class="relative">
                    <video controls class="w-full max-h-[500px] object-cover bg-black rounded-lg">
                        <source src="{{ asset('storage/' . $post->media_path) }}">
                        Your browser does not support the video tag.
                    </video>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover/media:opacity-100 transition-opacity duration-300"></div>
                </div>
                @else
                <div class="relative overflow-hidden">
                    <img src="{{ asset('storage/' . $post->media_path) }}" 
                         alt="Post image" 
                         class="w-full max-h-[500px] object-cover rounded-lg transition-transform duration-500 group-hover/media:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent opacity-0 group-hover/media:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute top-4 right-4 opacity-0 group-hover/media:opacity-100 transition-opacity duration-300">
                        <button class="p-2 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:bg-white transition-colors">
                            <i class="fas fa-expand text-neutral-700 text-sm"></i>
                        </button>
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Post Status Badge -->
            @if($post->status === 'pending' && auth()->id() === $post->user_id)
            <div class="mt-4 flex items-center p-4 bg-gradient-to-r from-amber-50/80 to-orange-50/80 border border-amber-200 rounded-xl backdrop-blur-sm group/pending">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full flex items-center justify-center mr-4 group-hover/pending:scale-110 transition-transform">
                    <i class="fas fa-clock text-amber-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-amber-800">Post Under Review</p>
                    <p class="text-xs text-amber-700/80 mt-1">Your post is pending approval and will appear publicly once approved by moderators.</p>
                </div>
                <div class="animate-pulse">
                    <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
                </div>
            </div>
            @endif
        </div>

        <!-- Post Stats & Actions -->
        <div class="px-6 py-3 bg-gradient-to-b from-neutral-50/50 to-white border-t border-neutral-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Like Button -->
                    <button type="button" 
                            @click="toggleLike({{ $post->id }}, $el, $data)"
                            class="flex items-center space-x-2 transition-all duration-300 group/like"
                            :class="isLiked ? 'text-red-500' : 'text-neutral-500 hover:text-red-500'">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                 :class="isLiked ? 'bg-red-50/80' : 'group-hover/like:bg-red-50/50'">
                                <i class="text-xl transition-all duration-300" 
                                   :class="isLiked ? 'fas fa-heart' : 'far fa-heart'"></i>
                            </div>
                            <div x-show="isLiked" class="absolute inset-0 bg-red-500/10 rounded-full animate-ping"></div>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300"
                              x-text="likesCount > 0 ? likesCount : 'Like'"></span>
                    </button>

                    <!-- Comment Button -->
                    <button @click="showComments = !showComments" 
                            class="flex items-center space-x-2 text-neutral-500 hover:text-primary-600 transition-all duration-300 group/comment">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center group-hover/comment:bg-primary-50/50 transition-all duration-300">
                            <i class="far fa-comment-alt text-xl"></i>
                        </div>
                        <span class="text-sm font-medium transition-all duration-300"
                              x-text="commentsCount > 0 ? commentsCount : 'Comment'"></span>
                    </button>

                    <!-- Share Button -->
                    <button class="flex items-center space-x-2 text-neutral-500 hover:text-green-600 transition-all duration-300 group/share">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center group-hover/share:bg-green-50/50 transition-all duration-300">
                            <i class="fas fa-share text-xl"></i>
                        </div>
                        <span class="text-sm font-medium">Share</span>
                    </button>
                </div>

                <!-- View Count & Engagement -->
                <div class="flex items-center space-x-4">
                    <div class="text-xs text-neutral-400 flex items-center group/views hover:text-neutral-600 transition-colors">
                        <div class="w-6 h-6 rounded-full bg-neutral-100 flex items-center justify-center mr-2 group-hover/views:bg-neutral-200 transition-colors">
                            <i class="fas fa-eye text-xs"></i>
                        </div>
                        <span>1.2k</span>
                    </div>
                    <div class="w-px h-4 bg-neutral-200"></div>
                    <div class="text-xs text-neutral-400 flex items-center">
                        <div class="w-6 h-6 rounded-full bg-neutral-100 flex items-center justify-center mr-2">
                            <i class="fas fa-chart-line text-xs"></i>
                        </div>
                        <span>High engagement</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div x-show="showComments" 
             x-collapse
             class="bg-gradient-to-b from-white to-neutral-50/30 border-t border-neutral-100">
            <div class="p-6">
                <!-- Add Comment Form -->
                <div class="mb-6">
                    <form action="{{ route('posts.comment', $post->id) }}" method="POST" 
                          class="flex items-start space-x-4 group/form">
                        @csrf
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center overflow-hidden ring-2 ring-white shadow-sm group-hover/form:scale-105 transition-transform">
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
                                       class="w-full px-5 py-3 bg-white border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 text-sm shadow-sm pr-14 transition-all duration-300 focus:shadow-md">
                                <button type="submit" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 p-2 text-primary-600 hover:text-primary-700 transition-colors group/submit">
                                    <i class="fas fa-paper-plane group-hover/submit:scale-110 transition-transform"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Comments List -->
                <div class="space-y-4 max-h-96 overflow-y-auto custom-scrollbar pr-2">
                    @if($post->comments->count() > 0)
                        @foreach($post->comments as $comment)
                        <div class="flex space-x-4 group/comment-item hover:bg-white/50 p-3 rounded-xl transition-all duration-300">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center overflow-hidden ring-2 ring-white group-hover/comment-item:scale-105 transition-transform">
                                    @if($comment->user->profile_picture)
                                    <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" class="w-full h-full object-cover">
                                    @else
                                    <i class="fas fa-user text-gray-500 p-2"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-neutral-100 group-hover/comment-item:border-primary-100 group-hover/comment-item:shadow-md transition-all duration-300">
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
                                                    class="text-xs text-neutral-400 hover:text-red-500 transition-colors opacity-0 group-hover/comment-item:opacity-100">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                    <p class="text-sm text-neutral-700 leading-relaxed">{{ $comment->content }}</p>
                                    <div class="flex items-center space-x-4 mt-3 pt-3 border-t border-neutral-100">
                                        <button class="text-xs text-neutral-400 hover:text-primary-600 transition-colors">
                                            <i class="far fa-thumbs-up mr-1"></i> Like
                                        </button>
                                        <button class="text-xs text-neutral-400 hover:text-primary-600 transition-colors">
                                            <i class="far fa-comment mr-1"></i> Reply
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <!-- Empty Comments State -->
                    <div class="text-center py-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-neutral-100 to-neutral-200 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
                            <i class="fas fa-comment-slash text-neutral-400 text-2xl"></i>
                        </div>
                        <p class="text-base font-medium text-neutral-500 mb-2">No comments yet</p>
                        <p class="text-sm text-neutral-400 max-w-sm mx-auto">Be the first to share your thoughts and start the conversation!</p>
                    </div>
                    @endif
                </div>

                <!-- Load More Comments -->
                @if($post->comments_count > 5)
                <div class="mt-6 text-center">
                    <button class="text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center justify-center mx-auto group/loadmore px-4 py-2 rounded-lg hover:bg-primary-50/50 transition-all duration-300">
                        <i class="fas fa-chevron-down mr-2 group-hover/loadmore:translate-y-1 transition-transform"></i>
                        Load more comments ({{ $post->comments_count - 5 }} more)
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Enhanced custom styles */
    [x-cloak] { display: none !important; }
    
    /* Smooth gradient animations */
    .gradient-border {
        position: relative;
        border: double 1px transparent;
        background-image: linear-gradient(white, white), 
                          linear-gradient(135deg, #0ea5e9 0%, #8b5cf6 100%);
        background-origin: border-box;
        background-clip: padding-box, border-box;
    }
    
    /* Enhanced hover effects */
    .hover-lift {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hover-lift:hover {
        transform: translateY(-3px);
    }
    
    /* Pulse animation for notifications */
    @keyframes gentle-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    .gentle-pulse {
        animation: gentle-pulse 2s ease-in-out infinite;
    }
    
    /* Custom scrollbar enhancement */
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #0ea5e9 #f1f1f1;
    }
    
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f8fafc;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #0ea5e9, #8b5cf6);
        border-radius: 10px;
        border: 2px solid #f8fafc;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #0284c7, #7c3aed);
    }
    
    /* Glass morphism effect */
    .glass-effect {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* Shimmer effect for loading */
    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    
    .shimmer {
        background: linear-gradient(90deg, 
            rgba(255,255,255,0) 0%, 
            rgba(255,255,255,0.8) 50%, 
            rgba(255,255,255,0) 100%);
        background-size: 200% auto;
        animation: shimmer 2s infinite linear;
    }
</style>

<script>
    // Enhanced toggleLike function with Alpine.js integration
    function toggleLike(postId, element, data) {
        const likeIcon = element.querySelector('i');
        const likeCount = element.querySelector('span:last-child');
        
        // Add loading shimmer effect
        element.classList.add('opacity-70', 'pointer-events-none');
        
        fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'liked') {
                data.isLiked = true;
                data.likesCount = result.likes_count;
                element.classList.add('text-red-500');
                element.classList.remove('text-neutral-500');
                
                // Add celebration effect
                const particles = createParticles(element);
                setTimeout(() => particles.remove(), 1000);
            } else {
                data.isLiked = false;
                data.likesCount = result.likes_count;
                element.classList.remove('text-red-500');
                element.classList.add('text-neutral-500');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error toast
            showToast('Failed to update like. Please try again.', 'error');
        })
        .finally(() => {
            element.classList.remove('opacity-70', 'pointer-events-none');
        });
    }
    
    // Create particle effect for likes
    function createParticles(element) {
        const rect = element.getBoundingClientRect();
        const particles = document.createElement('div');
        particles.className = 'fixed pointer-events-none z-50';
        
        for (let i = 0; i < 8; i++) {
            const particle = document.createElement('div');
            particle.className = 'absolute w-2 h-2 bg-red-500 rounded-full';
            particle.style.left = `${rect.left + rect.width/2}px`;
            particle.style.top = `${rect.top + rect.height/2}px`;
            particle.style.animation = `particle-${i} 1s ease-out forwards`;
            
            // Add animation style
            const style = document.createElement('style');
            style.textContent = `
                @keyframes particle-${i} {
                    0% {
                        transform: translate(0, 0) scale(1);
                        opacity: 1;
                    }
                    100% {
                        transform: translate(${Math.cos(i * 45 * Math.PI/180) * 50}px, 
                                           ${Math.sin(i * 45 * Math.PI/180) * 50}px) scale(0);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
            
            particles.appendChild(particle);
        }
        
        document.body.appendChild(particles);
        return particles;
    }
    
    // Toast notification system
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-4 py-3 rounded-xl shadow-lg z-50 transform transition-all duration-300 translate-x-full ${type === 'error' ? 'bg-red-50 border border-red-200 text-red-700' : 'bg-emerald-50 border border-emerald-200 text-emerald-700'}`;
        toast.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'} mr-3"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    // Image zoom modal
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('cursor-zoom-in') || e.target.closest('.group/media img')) {
            const img = e.target.tagName === 'IMG' ? e.target : e.target.closest('img');
            if (img) {
                showImageModal(img.src);
            }
        }
    });
    
    function showImageModal(src) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4 backdrop-blur-sm';
        modal.innerHTML = `
            <div class="relative max-w-4xl max-h-[90vh]">
                <img src="${src}" class="max-w-full max-h-[90vh] object-contain rounded-lg">
                <button class="absolute -top-12 right-0 text-white hover:text-gray-300 text-2xl transition-colors">
                    <i class="fas fa-times"></i>
                </button>
                <button class="absolute bottom-4 right-4 p-3 bg-white/20 backdrop-blur-sm rounded-full hover:bg-white/30 transition-colors">
                    <i class="fas fa-download text-white"></i>
                </button>
            </div>
        `;
        
        modal.querySelector('button').onclick = () => modal.remove();
        document.body.appendChild(modal);
    }
</script>
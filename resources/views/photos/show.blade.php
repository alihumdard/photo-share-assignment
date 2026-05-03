<x-app-layout>
    <div class="container">
        <div class="row">
            <!-- Main Photo Section -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <img src="{{ asset('storage/' . $photo->image_path) }}" class="card-img-top" alt="{{ $photo->title }}" style="max-height: 600px; object-fit: contain; background: #000;">
                    
                    <div class="card-body">
                        <!-- Photo Info -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 class="fw-bold mb-2">{{ $photo->title }}</h3>
                                <p class="text-muted mb-2">
                                    <i class="bi bi-person-circle"></i> 
                                    <strong>{{ $photo->user->name }}</strong>
                                    <span class="badge badge-creator ms-2">Creator</span>
                                </p>
                                <p class="text-muted small">
                                    <i class="bi bi-clock"></i> {{ $photo->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            @if(auth()->id() === $photo->user_id)
                            <div class="btn-group">
                                <a href="{{ route('photos.edit', $photo) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('photos.destroy', $photo) }}" method="POST" 
                                      onsubmit="return confirm('Delete this photo permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>

                        <!-- Caption -->
                        @if($photo->caption)
                        <p class="mb-3">{{ $photo->caption }}</p>
                        @endif

                        <!-- Metadata -->
                        <div class="row g-3 mb-3">
                            @if($photo->location)
                            <div class="col-auto">
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-geo-alt-fill text-danger"></i> {{ $photo->location }}
                                </span>
                            </div>
                            @endif
                            
                            @if($photo->people)
                            <div class="col-auto">
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-people-fill text-primary"></i> {{ $photo->people }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Rating Display -->
                        <div class="d-flex align-items-center gap-3 p-3 bg-light rounded">
                            <div class="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= round($photo->avg_rating) ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                            <span class="fw-semibold">
                                {{ number_format($photo->avg_rating, 1) }} / 5.0
                            </span>
                            <span class="text-muted small">({{ $photo->rating_count }} {{ Str::plural('rating', $photo->rating_count) }})</span>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="bi bi-chat-dots-fill"></i> Comments ({{ $photo->comments->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Add Comment Form -->
                        @auth
                        <form action="{{ route('comments.store', $photo) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <textarea name="body" class="form-control @error('body') is-invalid @enderror" 
                                          rows="3" placeholder="Write a comment..." required>{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-send-fill"></i> Post Comment
                            </button>
                        </form>
                        @else
                        <div class="alert alert-info">
                            <a href="{{ route('login') }}">Login</a> to post a comment
                        </div>
                        @endauth

                        <!-- Comments List -->
                        @forelse($photo->comments as $comment)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $comment->user->name }}</strong>
                                    <span class="badge badge-{{ $comment->user->isCreator() ? 'creator' : 'consumer' }} ms-2 small">
                                        {{ ucfirst($comment->user->role) }}
                                    </span>
                                    <p class="text-muted small mb-1">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                                
                                @if(auth()->id() === $comment->user_id)
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" 
                                      onsubmit="return confirm('Delete this comment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                            <p class="mb-0">{{ $comment->body }}</p>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3">
                            <i class="bi bi-chat"></i> No comments yet. Be the first to comment!
                        </p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Rate This Photo -->
                @auth
                @if(auth()->id() !== $photo->user_id)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-star-fill text-warning"></i> Rate This Photo
                        </h5>
                        
                        @if($userRating)
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill"></i> You rated this photo <strong>{{ $userRating->score }}/5</strong>
                        </div>
                        @endif

                        <form action="{{ route('ratings.store', $photo) }}" method="POST">
                            @csrf
                            <div class="star-rating star-rating-clickable text-center mb-3" id="ratingStars">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $userRating && $i <= $userRating->score ? '-fill' : '' }}" 
                                   data-rating="{{ $i }}" 
                                   onclick="setRating({{ $i }})"></i>
                                @endfor
                            </div>
                            <input type="hidden" name="score" id="ratingInput" value="{{ $userRating ? $userRating->score : '' }}">
                            <button type="submit" class="btn btn-primary w-100" id="submitRating" 
                                    {{ !$userRating && !old('score') ? 'disabled' : '' }}>
                                <i class="bi bi-send-fill"></i> {{ $userRating ? 'Update Rating' : 'Submit Rating' }}
                            </button>
                        </form>
                    </div>
                </div>
                @endif
                @endauth

                <!-- Photo Stats -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-bar-chart-fill"></i> Statistics
                        </h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Views</span>
                            <strong>-</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Comments</span>
                            <strong>{{ $photo->comments->count() }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Ratings</span>
                            <strong>{{ $photo->rating_count }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast show" role="alert">
                <div class="toast-header bg-success text-white">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong class="me-auto">Success</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function setRating(rating) {
            document.getElementById('ratingInput').value = rating;
            document.getElementById('submitRating').disabled = false;
            
            // Update star display
            const stars = document.querySelectorAll('#ratingStars i');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('bi-star');
                    star.classList.add('bi-star-fill');
                } else {
                    star.classList.remove('bi-star-fill');
                    star.classList.add('bi-star');
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
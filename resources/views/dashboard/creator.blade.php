<x-app-layout>
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">My Photos</h2>
                        <p class="text-muted">Manage your uploaded content</p>
                    </div>
                    <a href="{{ route('photos.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Upload New Photo
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Photos Grid -->
        @if($photos->count() > 0)
        <div class="row g-4">
            @foreach($photos as $photo)
            <div class="col-md-4 col-sm-6">
                <div class="card">
                    <img src="{{ Storage::url($photo->image_path) }}" class="photo-card-img" alt="{{ $photo->title }}">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $photo->title }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($photo->caption, 80) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= round($photo->avg_rating) ? '-fill' : '' }}"></i>
                                @endfor
                                <span class="text-muted small ms-1">({{ $photo->ratings_count }})</span>
                            </div>
                            <span class="text-muted small">
                                <i class="bi bi-chat-fill"></i> {{ $photo->comments_count }}
                            </span>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('photos.show', $photo) }}" class="btn btn-sm btn-outline-primary flex-fill">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('photos.edit', $photo) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this photo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $photos->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-images display-1 text-muted"></i>
            <h3 class="mt-3">No photos yet</h3>
            <p class="text-muted">Start sharing your amazing photos with the world!</p>
            <a href="{{ route('photos.create') }}" class="btn btn-primary mt-3">
                <i class="bi bi-upload"></i> Upload Your First Photo
            </a>
        </div>
        @endif
    </div>
</x-app-layout>
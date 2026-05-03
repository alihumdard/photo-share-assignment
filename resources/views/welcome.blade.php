<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PhotoShare - Share Your Moments</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .feature-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        .feature-icon {
            font-size: 3rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .btn-hero {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: transform 0.3s;
        }
        
        .btn-hero:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 fw-bold mb-4">
                        <i class="bi bi-camera-fill"></i> PhotoShare
                    </h1>
                    <p class="lead mb-5">
                        Share your amazing photos with the world. Upload, discover, and connect through visual storytelling.
                    </p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                        @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-hero">
                            <i class="bi bi-house-fill"></i> Go to Dashboard
                        </a>
                        @else
                        <a href="{{ route('register') }}" class="btn btn-light btn-hero">
                            <i class="bi bi-person-plus-fill"></i> Get Started
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-hero">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6 text-center mt-5 mt-lg-0">
                    <i class="bi bi-images display-1"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <h2 class="text-center fw-bold mb-5">Why Choose PhotoShare?</h2>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-upload"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Easy Upload</h4>
                        <p class="text-muted">
                            Upload your photos with rich metadata including title, caption, location, and tags.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-search"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Discover Content</h4>
                        <p class="text-muted">
                            Search and explore amazing photos from talented creators around the world.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-chat-dots-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Engage & Rate</h4>
                        <p class="text-muted">
                            Comment on photos, rate them, and connect with other photography enthusiasts.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5">
        <div class="container py-5 text-center">
            <h2 class="fw-bold mb-4">Ready to Share Your Moments?</h2>
            <p class="lead text-muted mb-4">Join our community of creators and photography lovers today!</p>
            @guest
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg btn-hero">
                <i class="bi bi-person-plus-fill"></i> Create Free Account
            </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 PhotoShare. Built with Laravel & Bootstrap.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
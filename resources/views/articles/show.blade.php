@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Article Title -->
            <h1 class="mb-4">{{ $article->title }}</h1>
            
            <!-- Category and Date -->
            <div class="mb-4 text-muted">
                <span class="badge bg-primary me-2">{{ $article->category->name }}</span>
                <small>Dibuat pada {{ $article->created_at->format('d M Y') }}</small>
            </div>

            <!-- Cover Image -->
            @if($article->image)
                <div class="mb-5">
                    <img src="{{ asset('storage/'.$article->image) }}" class="img-fluid rounded shadow-sm" alt="{{ $article->title }}">
                </div>
            @endif

            <!-- Article Content -->
            <div class="mb-5">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Author Profile Box -->
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        @if($article->user->profile && $article->user->profile->avatar)
                            <img src="{{ asset('storage/'.$article->user->profile->avatar) }}" class="rounded-circle me-4" width="100" height="100" alt="{{ $article->user->name }}">
                        @else
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-4" style="width: 100px; height: 100px; font-size: 2rem;">
                                {{ strtoupper(substr($article->user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="mb-1">{{ $article->user->name }}</h4>
                            @if($article->user->profile)
                                @if($article->user->profile->phone)
                                    <p class="mb-1 text-muted"><i class="fas fa-phone me-2"></i>{{ $article->user->profile->phone }}</p>
                                @endif
                                @if($article->user->profile->bio)
                                    <p class="mb-0">{{ $article->user->profile->bio }}</p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
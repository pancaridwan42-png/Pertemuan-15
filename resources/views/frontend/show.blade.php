@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold mb-4">{{ $article->title }}</h1>
            
            <div class="mb-4 d-flex flex-wrap align-items-center gap-2">
                @if($article->category)
                    <span class="badge bg-primary rounded-pill px-3 py-2">{{ $article->category->name }}</span>
                @endif
                
                @if($article->tags->count() > 0)
                    @foreach($article->tags as $tag)
                        <span class="badge bg-secondary rounded-pill px-3 py-2">{{ $tag->name }}</span>
                    @endforeach
                @endif
                
                <span class="text-muted ms-auto">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ $article->created_at->format('d M Y') }}
                </span>
            </div>

            @if($article->image)
                <div class="mb-5">
                    <img 
                        src="{{ asset('storage/' . $article->image) }}" 
                        alt="{{ $article->title }}" 
                        class="img-fluid rounded-4 shadow-lg w-100"
                    >
                </div>
            @endif

            <article class="mb-5 fs-5 lh-lg">
                {!! $article->content !!}
            </article>

            @if($article->user)
                <div class="card border-0 bg-light rounded-4 shadow-sm">
                    <div class="card-body p-5">
                        <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                            @if($article->user->profile && $article->user->profile->avatar)
                                <img 
                                    src="{{ asset('storage/' . $article->user->profile->avatar) }}" 
                                    class="rounded-circle border border-3 border-white shadow" 
                                    alt="{{ $article->user->name }}"
                                    width="120"
                                    height="120"
                                >
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow" style="width: 120px; height: 120px; font-size: 3rem;">
                                    {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                </div>
                            @endif
                            
                            <div class="flex-grow-1 text-center text-md-start">
                                <h3 class="fw-bold mb-2">{{ $article->user->name }}</h3>
                                
                                @if($article->user->profile)
                                    @if($article->user->profile->phone)
                                        <p class="text-muted mb-2">
                                            <i class="bi bi-telephone me-2"></i>{{ $article->user->profile->phone }}
                                        </p>
                                    @endif
                                    
                                    @if($article->user->profile->bio)
                                        <p class="mb-0">{{ $article->user->profile->bio }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h2 class="section-title" style="margin-bottom: 0.5rem;">
                Success <span class="text-gradient">Stories</span>
            </h2>
            <p class="lead text-secondary">Real people achieving real financial success</p>
        </div>
    </x-slot>

    <section class="modern-section" style="background: var(--bg-light); padding-top: 2rem;">
        <div class="container">
            <div class="row g-4">
                @foreach($stories as $story)
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        @if($story->image)
                        <img src="{{ asset('storage/' . $story->image) }}" 
                             alt="{{ $story->name }}"
                             class="img-fluid rounded-modern mb-3"
                             style="width: 100%; height: 250px; object-fit: cover;">
                        @else
                        <div class="rounded-modern mb-3" style="height: 250px; background: var(--gradient-primary); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-circle" style="font-size: 5rem; color: white; opacity: 0.5;"></i>
                        </div>
                        @endif
                        
                        <h3 class="feature-title" style="font-size: 1.5rem;">{{ $story->name }}</h3>
                        @if($story->location)
                        <p class="text-muted mb-2">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $story->location }}
                        </p>
                        @endif
                        @if($story->title)
                        <p class="text-primary mb-3" style="font-weight: 600; font-size: 1.1rem;">
                            <i class="fas fa-trophy me-1"></i>{{ $story->title }}
                        </p>
                        @endif
                        <p class="feature-description">{{ Str::limit($story->story, 150) }}</p>
                        
                        @if($story->amount || $story->timeframe_months)
                        <div class="d-flex gap-2 mb-3 flex-wrap">
                            @if($story->amount)
                            <span class="badge rounded-pill" style="background: var(--gradient-success); color: white; padding: 0.5rem 1rem;">
                                <i class="fas fa-dollar-sign me-1"></i>${{ number_format($story->amount, 0) }}
                            </span>
                            @endif
                            @if($story->timeframe_months)
                            <span class="badge rounded-pill" style="background: var(--gradient-info); color: white; padding: 0.5rem 1rem;">
                                <i class="fas fa-clock me-1"></i>{{ $story->timeframe_months }} months
                            </span>
                            @endif
                        </div>
                        @endif
                        
                        <a href="{{ route('success-stories.show', $story->id) }}" class="btn btn-modern btn-modern-primary w-100 mt-3">
                            Read Full Story <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                @endforeach

                @if($stories->isEmpty())
                <div class="col-12">
                    <div class="modern-card text-center py-5">
                        <i class="fas fa-trophy" style="font-size: 4rem; color: var(--text-secondary); opacity: 0.3; margin-bottom: 1rem;"></i>
                        <h4 class="text-secondary">No success stories yet</h4>
                        <p class="text-muted">Check back soon for inspiring stories!</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h2 class="section-title" style="margin-bottom: 0.5rem;">
                Success <span class="text-gradient">Story</span>
            </h2>
        </div>
    </x-slot>

    <section class="modern-section" style="background: var(--bg-light); padding-top: 2rem;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="modern-card">
                        @if($story->image)
                        <img src="{{ asset('storage/' . $story->image) }}" 
                             alt="{{ $story->name }}"
                             class="img-fluid rounded-modern mb-4"
                             style="width: 100%; height: 400px; object-fit: cover;">
                        @endif

                        <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1rem;">
                            {{ $story->name }}
                        </h1>

                        @if($story->title)
                        <div class="alert alert-info mb-4" style="background: rgba(102, 126, 234, 0.1); border-left: 4px solid var(--primary-color);">
                            <h4 class="mb-0" style="color: var(--primary-color);">
                                <i class="fas fa-trophy me-2"></i>{{ $story->title }}
                            </h4>
                        </div>
                        @endif

                        <div class="d-flex gap-4 mb-4" style="font-size: 1rem; color: var(--text-secondary); flex-wrap: wrap;">
                            @if($story->location)
                            <span>
                                <i class="fas fa-map-marker-alt me-2"></i>{{ $story->location }}
                            </span>
                            @endif
                            @if($story->amount)
                            <span>
                                <i class="fas fa-dollar-sign me-2"></i>${{ number_format($story->amount, 0) }}
                            </span>
                            @endif
                            @if($story->timeframe_months)
                            <span>
                                <i class="fas fa-clock me-2"></i>{{ $story->timeframe_months }} months
                            </span>
                            @endif
                            <span>
                                <i class="fas fa-calendar-alt me-2"></i>{{ $story->created_at->format('M d, Y') }}
                            </span>
                        </div>

                        <div class="story-content" style="font-size: 1.125rem; line-height: 1.8; color: var(--text-primary); white-space: pre-line;">
                            {{ $story->story }}
                        </div>

                        <div class="mt-5 pt-4" style="border-top: 2px solid var(--border-color);">
                            <a href="{{ route('success-stories.index') }}" class="btn btn-modern btn-modern-primary">
                                <i class="fas fa-arrow-left me-2"></i>Back to All Stories
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if($relatedStories->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4" style="font-weight: 700; color: var(--text-primary);">
                        <i class="fas fa-book-open me-2"></i>Related Success Stories
                    </h3>
                    <div class="row g-4">
                        @foreach($relatedStories as $relatedStory)
                        <div class="col-md-4">
                            <div class="feature-card">
                                @if($relatedStory->image)
                                <img src="{{ asset('storage/' . $relatedStory->image) }}" 
                                     alt="{{ $relatedStory->name }}"
                                     class="img-fluid rounded-modern mb-3"
                                     style="width: 100%; height: 200px; object-fit: cover;">
                                @endif
                                <h4 class="feature-title" style="font-size: 1.25rem;">{{ $relatedStory->name }}</h4>
                                @if($relatedStory->title)
                                <p class="text-primary mb-2" style="font-weight: 600;">
                                    {{ $relatedStory->title }}
                                </p>
                                @endif
                                <a href="{{ route('success-stories.show', $relatedStory->id) }}" class="btn btn-modern btn-modern-primary w-100 mt-3">
                                    Read Story <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
</x-app-layout>


@extends('layouts.main')
@section('title', 'Go-Blog - Explore')

@section('content')

@if(session('success'))
    <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg">
        {{ session('success') }}
    </div>
@endif

@if($posts->isEmpty())
    <div class="text-center py-20 text-slate-500">
        <i data-lucide="inbox" class="w-16 h-16 mx-auto mb-4 opacity-50"></i>
        <h3 class="text-xl font-semibold mb-2">No Stories Yet</h3>
        <p>Check back later for new discoveries.</p>
    </div>
@else
    @php
        $featured = $posts->first();
        $others = $posts->slice(1);
    @endphp

    <!-- Featured Post -->
    <div class="mb-12 group cursor-pointer" onclick="window.location='{{ route('posts.show', $featured->slug) }}'">
        <div class="relative h-[400px] rounded-[2.5rem] overflow-hidden shadow-sm group-hover:shadow-xl transition-all duration-300">
            <!-- Random landscape image for the featured post -->
            <img src="https://images.unsplash.com/photo-1512100356356-de1b84283e18?auto=format&fit=crop&q=80&w=1200" alt="{{ $featured->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
            
            <div class="absolute bottom-0 left-0 p-10 text-white w-full md:w-2/3">
                <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold tracking-widest uppercase mb-4 inline-block shadow-sm">{{ $featured->category ?? 'Destination' }}</span>
                <h2 class="text-4xl md:text-5xl font-serif font-bold mb-3 leading-tight drop-shadow-md">{{ $featured->title }}</h2>
                <p class="text-white/90 line-clamp-2 mb-6 max-w-lg drop-shadow-sm">{{ Str::limit($featured->body, 120) }}</p>
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($featured->user->name ?? 'Admin') }}&background=0f4c81&color=fff" class="w-10 h-10 rounded-full border-2 border-white/80 shadow-md">
                    <div>
                        <p class="text-sm font-semibold drop-shadow-sm">{{ $featured->user->name ?? 'Admin' }}</p>
                        <p class="text-[10px] text-white/80 uppercase tracking-wider font-medium">{{ $featured->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($others->isNotEmpty())
        <!-- Latest Discoveries -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-2xl font-serif font-bold text-slate-900">Latest Discoveries</h3>
                <p class="text-sm text-slate-500 mt-1">Curated stories from the world's most remote corners.</p>
            </div>
            <div class="hidden sm:flex space-x-2 text-sm font-semibold">
                <button class="px-4 py-2 text-blue-600 bg-blue-50 rounded-lg">Recent</button>
                <button class="px-4 py-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors">Popular</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($others as $index => $post)
                @php
                    // Using different random images for variety in dummy UI
                    $images = [
                        'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&q=80&w=800',
                        'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&q=80&w=800',
                        'https://images.unsplash.com/photo-1533105079780-92b9be482077?auto=format&fit=crop&q=80&w=800',
                        'https://images.unsplash.com/photo-1548013146-72479768bbaa?auto=format&fit=crop&q=80&w=800',
                        'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?auto=format&fit=crop&q=80&w=800'
                    ];
                    $imgSrc = $images[$index % count($images)];
                @endphp
                <a href="{{ route('posts.show', $post->slug) }}" class="group bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl hover:border-blue-200 transition-all duration-300 flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ $imgSrc }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">{{ $post->category ?? 'Travel' }}</span>
                        <h4 class="font-serif font-bold text-slate-900 text-lg mt-2 mb-3 group-hover:text-blue-700 transition-colors line-clamp-2">{{ $post->title }}</h4>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-6 leading-relaxed">{{ Str::limit($post->body, 90) }}</p>
                        
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-50">
                            <div class="flex items-center space-x-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name ?? 'Admin') }}&background=random" class="w-5 h-5 rounded-full">
                                <span class="text-[11px] font-semibold text-slate-700">{{ $post->user->name ?? 'Admin' }}</span>
                            </div>
                            <span class="text-[10px] text-slate-400 font-medium">{{ $post->views }} Views</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $posts->links() }}
        </div>
    @endif
@endif

@endsection

@extends('layouts.main')
@section('title', $post->title . ' - Go-Blog')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
    <!-- Header -->
    <div class="text-center mb-10">
        <span class="px-4 py-1.5 bg-blue-50 text-blue-700 rounded-full text-xs font-bold tracking-widest uppercase mb-6 inline-block">{{ $post->category ?? 'Destination' }}</span>
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-slate-900 mb-6 leading-tight">{{ $post->title }}</h1>
        <div class="flex items-center justify-center space-x-6 text-sm text-slate-500 font-medium">
            <div class="flex items-center space-x-2">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name ?? 'Admin') }}&background=0f4c81&color=fff" class="w-6 h-6 rounded-full">
                <span class="text-slate-800">{{ $post->user->name ?? 'Admin' }}</span>
            </div>
            <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
            <span>{{ $post->created_at->format('M d, Y') }}</span>
            <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
            <span>{{ $post->views }} Views</span>
            <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
            <span>📍 {{ $post->location }}</span>
        </div>
    </div>

    <!-- Image -->
    <div class="h-[400px] w-full rounded-[2rem] overflow-hidden mb-12 shadow-sm">
        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&q=80&w=1200" alt="{{ $post->title }}" class="w-full h-full object-cover">
    </div>

    <!-- Article Content -->
    <div class="prose prose-lg prose-slate max-w-none mb-16 leading-relaxed text-slate-700 font-serif">
        {!! nl2br(e($post->body)) !!}
    </div>

    <!-- Comments Section -->
    <div class="pt-10 border-t border-slate-200">
        <h3 class="text-2xl font-serif font-bold text-slate-900 mb-8">Comments ({{ $comments->count() }})</h3>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Comment Form --}}
        <div class="bg-slate-50 p-6 rounded-3xl mb-10 border border-slate-100">
            <form action="{{ route('comments.store', $post) }}" method="POST">
                @csrf

                @guest
                    {{-- Guest fields: name and email --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="guest_name" class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Anda <span class="text-red-500">*</span></label>
                            <input type="text" name="guest_name" id="guest_name" value="{{ old('guest_name') }}"
                                   class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                   placeholder="Nama lengkap" required>
                        </div>
                        <div>
                            <label for="guest_email" class="block text-xs font-semibold text-slate-600 mb-1.5">Email (opsional)</label>
                            <input type="email" name="guest_email" id="guest_email" value="{{ old('guest_email') }}"
                                   class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                   placeholder="email@contoh.com">
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3 mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0f4c81&color=fff" class="w-8 h-8 rounded-full">
                        <span class="text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</span>
                    </div>
                @endguest

                <div class="mb-4">
                    <textarea name="content" id="content"
                              class="w-full bg-white border border-slate-200 rounded-2xl p-4 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all resize-none text-sm"
                              rows="3" placeholder="Tulis komentar Anda..." required>{{ old('content') }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                        Kirim Komentar
                    </button>
                </div>
            </form>
        </div>

        {{-- Comments List --}}
        <div class="space-y-6">
            @forelse($comments as $comment)
                <div class="flex space-x-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->author_name) }}&background=random" class="w-10 h-10 rounded-full shrink-0">
                    <div class="flex-1 bg-slate-50 p-5 rounded-2xl rounded-tl-none border border-slate-100">
                        <div class="flex justify-between items-center mb-2">
                            <h5 class="font-semibold text-slate-900 text-sm">{{ $comment->author_name }}</h5>
                            <span class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $comment->content }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-slate-500 text-sm">Jadilah yang pertama berkomentar!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

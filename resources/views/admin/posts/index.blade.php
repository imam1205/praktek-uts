@extends('layouts.admin')

@section('title', 'Post Management - Go-Blog Admin')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Post Management</h1>
            <p class="text-sm text-slate-500 mt-1">Manage and organize your travel stories.</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="flex items-center gap-2 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-50 transition-colors">
                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                Filter
            </button>
            <a href="{{ route('admin.posts.create') }}" class="flex items-center gap-2 px-4 py-2 bg-admin-blue rounded-lg text-xs font-medium text-white hover:bg-blue-700 transition-colors">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                Create New Post
            </a>
        </div>
    </div>

    {{-- Content Overview --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Posts</h3>
            <div class="flex items-end justify-between mt-2">
                <p class="text-2xl font-bold text-slate-800">{{ $posts->total() }}</p>
                <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">All time</span>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Published</h3>
            <div class="flex items-end justify-between mt-2">
                <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Post::where('status', 'published')->count() }}</p>
                <div class="p-1.5 bg-emerald-50 rounded-lg">
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Drafts</h3>
            <div class="flex items-end justify-between mt-2">
                <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Post::where('status', 'draft')->count() }}</p>
                <div class="p-1.5 bg-slate-50 rounded-lg">
                    <i data-lucide="edit-3" class="w-4 h-4 text-slate-400"></i>
                </div>
            </div>
        </div>
        <div class="bg-admin-blue p-5 rounded-xl shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-xs font-semibold text-blue-100 uppercase tracking-wider">Trending Posts</h3>
                <div class="flex items-end justify-between mt-2">
                    <p class="text-2xl font-bold text-white">24</p>
                    <i data-lucide="trending-up" class="w-5 h-5 text-blue-200"></i>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full blur-2xl"></div>
        </div>
    </div>

    {{-- Articles Table --}}
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h2 class="font-bold text-slate-800">Articles</h2>
                <div class="flex bg-slate-100 p-1 rounded-lg">
                    <button class="px-3 py-1 text-[11px] font-bold rounded-md bg-white text-slate-800 shadow-sm">All</button>
                    <button class="px-3 py-1 text-[11px] font-bold text-slate-500 hover:text-slate-700">Published</button>
                    <button class="px-3 py-1 text-[11px] font-bold text-slate-500 hover:text-slate-700">Drafts</button>
                    <button class="px-3 py-1 text-[11px] font-bold text-slate-500 hover:text-slate-700">Scheduled</button>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-[11px] font-bold text-slate-600">
                    <i data-lucide="tag" class="w-3 h-3"></i> Category
                </button>
                <button class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-[11px] font-bold text-slate-600">
                    <i data-lucide="calendar" class="w-3 h-3"></i> Date Range
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Article Title</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Author</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Category</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($posts as $post)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->title) }}&background=random&color=fff" alt="" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700 line-clamp-1 group-hover:text-admin-blue transition-colors">{{ $post->title }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5 font-medium uppercase tracking-wider">ID: #TR-{{ 2940 + $loop->index }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name ?? 'Admin') }}&background=1a3a6b&color=fff" alt="" class="w-6 h-6 rounded-full">
                                <span class="text-xs font-medium text-slate-600">{{ $post->user->name ?? 'Admin' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-purple-100 text-purple-700">
                                {{ $post->category ?? 'Nature' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-500 font-medium">{{ $post->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($post->status === 'published')
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-md transition-colors" title="View">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors" title="Edit">
                                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-md transition-colors" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-slate-400 italic">No articles found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
            <p class="text-xs text-slate-500 font-medium">Showing {{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} posts</p>
            <div>
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>

<div class="fixed bottom-6 right-6">
    <a href="{{ route('admin.posts.create') }}" class="w-12 h-12 bg-admin-blue text-white rounded-full shadow-lg hover:shadow-blue-500/30 hover:scale-110 transition-all flex items-center justify-center">
        <i data-lucide="plus" class="w-6 h-6"></i>
    </a>
</div>
@endsection

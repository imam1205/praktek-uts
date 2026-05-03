@extends('layouts.admin')

@section('title', 'Comment Management - Go-Blog Admin')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Comment Management</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola dan moderasi komentar pengunjung.</p>
        </div>
    </div>

    {{-- Comment Stats --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Komentar</h3>
            <div class="flex items-end justify-between mt-2">
                <p class="text-2xl font-bold text-slate-800">{{ $comments->total() }}</p>
                <div class="p-1.5 bg-blue-50 rounded-lg">
                    <i data-lucide="message-circle" class="w-4 h-4 text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Approved</h3>
            <div class="flex items-end justify-between mt-2">
                <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Comment::where('status', 'approved')->count() }}</p>
                <div class="p-1.5 bg-emerald-50 rounded-lg">
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pending</h3>
            <div class="flex items-end justify-between mt-2">
                <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Comment::where('status', 'pending')->count() }}</p>
                <div class="p-1.5 bg-amber-50 rounded-lg">
                    <i data-lucide="clock" class="w-4 h-4 text-amber-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Rejected</h3>
            <div class="flex items-end justify-between mt-2">
                <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Comment::where('status', 'rejected')->count() }}</p>
                <div class="p-1.5 bg-rose-50 rounded-lg">
                    <i data-lucide="x-circle" class="w-4 h-4 text-rose-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- Comments Table --}}
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-bold text-slate-800">Semua Komentar</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pengirim</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Komentar</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Post</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($comments as $comment)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->author_name) }}&background=random&color=fff" alt="" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="text-sm font-semibold text-slate-700">{{ $comment->author_name }}</p>
                                    <p class="text-[10px] text-slate-400">
                                        {{ $comment->user ? $comment->user->email : ($comment->guest_email ?? 'Guest') }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs text-slate-600 line-clamp-2 max-w-xs">{{ $comment->content }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($comment->post)
                                <a href="{{ route('posts.show', $comment->post->slug) }}" target="_blank" class="text-xs font-medium text-blue-600 hover:underline line-clamp-1">
                                    {{ Str::limit($comment->post->title, 30) }}
                                </a>
                            @else
                                <span class="text-xs text-slate-400 italic">Post dihapus</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-500 font-medium">{{ $comment->created_at->format('d M Y H:i') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($comment->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved
                                </span>
                            @elseif($comment->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                @if($comment->status !== 'approved')
                                    <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-md transition-colors" title="Approve">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                                @if($comment->status !== 'rejected')
                                    <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-md transition-colors" title="Reject">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus komentar ini?')">
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
                        <td colspan="6" class="px-6 py-10 text-center text-slate-400 italic">Belum ada komentar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
            <p class="text-xs text-slate-500 font-medium">Showing {{ $comments->firstItem() ?? 0 }}-{{ $comments->lastItem() ?? 0 }} of {{ $comments->total() }} comments</p>
            <div>
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

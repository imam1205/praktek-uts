@extends('layouts.admin')

@section('title', 'Create New Travel Post - Go-Blog Admin')

@section('content')
<form action="{{ route('admin.posts.store') }}" method="POST" class="max-w-6xl mx-auto pb-12">
    @csrf
    
    {{-- Breadcrumbs & Top Actions --}}
    <div class="flex items-center justify-between mb-8">
        <nav class="flex items-center gap-2 text-xs font-medium">
            <a href="{{ route('admin.posts.index') }}" class="text-slate-400 hover:text-slate-600">Posts</a>
            <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
            <span class="text-slate-800">New Travel Post</span>
        </nav>
        <div class="flex items-center gap-4">
            <button type="button" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
                <i data-lucide="bell" class="w-5 h-5"></i>
            </button>
            <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-white shadow-sm">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=1a3a6b&color=fff" alt="" class="w-full h-full">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-8">
        
        {{-- Left Column: Main Editor --}}
        <div class="col-span-12 lg:col-span-8 space-y-6">
            
            {{-- Post Title --}}
            <div>
                <input type="text" name="title" id="title" placeholder="The Hidden Waterfalls of Northern Thailand" 
                       class="w-full bg-transparent border-none text-4xl font-bold text-slate-800 placeholder:text-slate-200 focus:outline-none focus:ring-0 px-0"
                       value="{{ old('title') }}" required>
            </div>

            {{-- Editor Toolbar --}}
            <div class="bg-white border border-slate-100 rounded-xl shadow-sm overflow-hidden">
                <div class="px-4 py-2 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-1">
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-white hover:text-slate-800 rounded transition-colors"><i data-lucide="bold" class="w-4 h-4"></i></button>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-white hover:text-slate-800 rounded transition-colors"><i data-lucide="italic" class="w-4 h-4"></i></button>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-white hover:text-slate-800 rounded transition-colors"><i data-lucide="underline" class="w-4 h-4"></i></button>
                        <div class="w-px h-4 bg-slate-200 mx-1"></div>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-white hover:text-slate-800 rounded transition-colors"><i data-lucide="align-left" class="w-4 h-4"></i></button>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-white hover:text-slate-800 rounded transition-colors"><i data-lucide="align-center" class="w-4 h-4"></i></button>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-white hover:text-slate-800 rounded transition-colors"><i data-lucide="align-right" class="w-4 h-4"></i></button>
                        <div class="w-px h-4 bg-slate-200 mx-1"></div>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-white hover:text-slate-800 rounded transition-colors"><i data-lucide="image" class="w-4 h-4"></i></button>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-white hover:text-slate-800 rounded transition-colors"><i data-lucide="link" class="w-4 h-4"></i></button>
                        <button type="button" class="p-1.5 text-slate-500 hover:bg-white hover:text-slate-800 rounded transition-colors"><i data-lucide="code" class="w-4 h-4"></i></button>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" class="flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider hover:text-slate-800">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Preview
                        </button>
                        <button type="button" class="flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider hover:text-slate-800">
                            <i data-lucide="maximize-2" class="w-3.5 h-3.5"></i> Zen Mode
                        </button>
                    </div>
                </div>

                {{-- Editor Body --}}
                <div class="p-8">
                    <div class="prose max-w-none">
                        <textarea name="body" id="body" rows="15" 
                                  class="w-full border-none focus:ring-0 text-slate-600 placeholder:text-slate-300 resize-none leading-relaxed"
                                  placeholder="Tucked away beneath the emerald canopy of Chiang Mai's northern provinces lies a secret that few travelers ever witness..." required>{{ old('body') }}</textarea>
                    </div>

                    {{-- Image Placeholder --}}
                    <div class="mt-8 rounded-2xl overflow-hidden bg-slate-100 aspect-video flex flex-col items-center justify-center border-2 border-dashed border-slate-200 group cursor-pointer hover:bg-slate-50 transition-colors">
                        <i data-lucide="image-plus" class="w-12 h-12 text-slate-300 group-hover:text-admin-blue group-hover:scale-110 transition-all"></i>
                        <p class="text-sm font-bold text-slate-400 mt-4 group-hover:text-slate-600">Drop an image here or click to browse</p>
                        <p class="text-[10px] text-slate-300 mt-1 uppercase tracking-widest font-bold">Recommended size: 1200x630px</p>
                    </div>

                    <div class="mt-8">
                        <input type="text" name="location" id="location" placeholder="Location (e.g. Chiang Mai, Thailand)"
                               class="w-full bg-transparent border-none text-xl font-semibold text-slate-800 placeholder:text-slate-200 focus:outline-none focus:ring-0 px-0"
                               value="{{ old('location') }}" required>
                        <div class="h-px bg-slate-100 w-full mt-2"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Sidebars --}}
        <div class="col-span-12 lg:col-span-4 space-y-6">
            
            {{-- Publish Card --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm space-y-4">
                <button type="submit" name="status" value="published" class="w-full flex items-center justify-center gap-2 py-3 bg-admin-blue text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-500/20 hover:bg-blue-700 hover:-translate-y-0.5 transition-all">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    PUBLISH NOW
                </button>
                <div class="grid grid-cols-2 gap-3">
                    <button type="submit" name="status" value="draft" class="flex items-center justify-center gap-2 py-2.5 bg-slate-50 text-slate-600 rounded-xl font-bold text-[11px] hover:bg-slate-100 transition-colors">
                        <i data-lucide="file-edit" class="w-3.5 h-3.5"></i>
                        DRAFT
                    </button>
                    <button type="button" class="flex items-center justify-center gap-2 py-2.5 bg-slate-50 text-slate-600 rounded-xl font-bold text-[11px] hover:bg-slate-100 transition-colors">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        SCHEDULE
                    </button>
                </div>
            </div>

            {{-- Featured Image Card --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Featured Image</h3>
                <div class="aspect-[4/3] rounded-xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center group cursor-pointer hover:bg-slate-100 transition-colors overflow-hidden relative">
                    <div class="text-center p-6 group-hover:scale-95 transition-transform">
                        <div class="w-10 h-10 bg-white rounded-lg shadow-sm flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="upload-cloud" class="w-5 h-5 text-slate-400"></i>
                        </div>
                        <p class="text-[11px] font-bold text-slate-500 leading-tight">Click to upload your cover image</p>
                    </div>
                </div>
            </div>

            {{-- Category Card --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Category</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors has-[:checked]:border-admin-blue has-[:checked]:bg-blue-50/50 group">
                        <input type="radio" name="category" value="Adventure" class="w-4 h-4 text-admin-blue border-slate-200 focus:ring-admin-blue/20" checked>
                        <span class="text-sm font-medium text-slate-600 group-has-[:checked]:text-admin-blue group-has-[:checked]:font-bold">Adventure</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors has-[:checked]:border-admin-blue has-[:checked]:bg-blue-50/50 group">
                        <input type="radio" name="category" value="Luxury Travel" class="w-4 h-4 text-admin-blue border-slate-200 focus:ring-admin-blue/20">
                        <span class="text-sm font-medium text-slate-600 group-has-[:checked]:text-admin-blue group-has-[:checked]:font-bold">Luxury Travel</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors has-[:checked]:border-admin-blue has-[:checked]:bg-blue-50/50 group">
                        <input type="radio" name="category" value="Local Cuisine" class="w-4 h-4 text-admin-blue border-slate-200 focus:ring-admin-blue/20">
                        <span class="text-sm font-medium text-slate-600 group-has-[:checked]:text-admin-blue group-has-[:checked]:font-bold">Local Cuisine</span>
                    </label>
                </div>
            </div>

            {{-- Tags Card --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Tags</h3>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-[10px] font-bold uppercase tracking-wider border border-purple-100">
                        Thailand <i data-lucide="x" class="w-3 h-3 cursor-pointer"></i>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-[10px] font-bold uppercase tracking-wider border border-purple-100">
                        Trekking <i data-lucide="x" class="w-3 h-3 cursor-pointer"></i>
                    </span>
                </div>
                <div class="relative">
                    <input type="text" placeholder="Add tags..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-2.5 text-xs font-medium text-slate-700 placeholder:text-slate-300 focus:ring-2 focus:ring-admin-blue/20">
                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-admin-blue"><i data-lucide="plus" class="w-4 h-4"></i></button>
                </div>
            </div>

            {{-- SEO Config Card --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SEO Config</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5 ml-1">Meta Title</label>
                        <input type="text" placeholder="Hidden Waterfalls Northern Thailand | Wanderlust" class="w-full bg-slate-50 border-none rounded-xl px-4 py-2.5 text-xs font-medium text-slate-700 placeholder:text-slate-300 focus:ring-2 focus:ring-admin-blue/20">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1.5 ml-1">Description</label>
                        <textarea placeholder="Discover the secret cascades of Chiang Mai that tourists miss..." rows="3" class="w-full bg-slate-50 border-none rounded-xl px-4 py-2.5 text-xs font-medium text-slate-700 placeholder:text-slate-300 focus:ring-2 focus:ring-admin-blue/20 resize-none"></textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    // Simple handling for title sync with meta title
    const titleInput = document.getElementById('title');
    titleInput.addEventListener('input', (e) => {
        // Auto-expand textarea for body if needed
        const textarea = document.getElementById('body');
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    });
</script>
@endpush

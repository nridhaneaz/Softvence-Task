@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
    <div class="card">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6">🎓 Create a New Course</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="list-disc ml-4">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="courseForm" method="POST" action="{{ route('courses.store') }}" class="space-y-8">
            @csrf
            <!-- Course Info -->
            <div class="card shadow-sm border-l-4 border-indigo-500">
                <h2 class="text-xl font-semibold mb-4 text-indigo-600">📘 Course Information</h2>
                <div class="form-group">
                    <label>Course Title *</label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           required
                           value="{{ old('title') }}"
                           class="@error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="@error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <input type="text" 
                           name="category" 
                           id="category"
                           value="{{ old('category') }}"
                           class="@error('category') border-red-500 @enderror">
                    @error('category')
                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Modules Section -->
            <div class="card shadow-sm border-l-4 border-green-500">
                <h2 class="text-xl font-semibold mb-4 text-green-600">📂 Course Modules</h2>
                <p class="text-gray-600 mb-4">Add structured modules, each with one or more content items.</p>
                <div id="modulesContainer" class="space-y-4"></div>
                <div class="mt-4">
                    <button type="button" id="addModuleBtn" class="btn btn-secondary">
                        ➕ Add Module
                    </button>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn">
                    ✅ Save Course
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
$(function(){
    // Update input names for correct submission
    function updateNames() {
        $('#modulesContainer .module').each(function(mIdx){
            $(this).find('[data-name="module_title"]').attr('name', `modules[${mIdx}][title]`);
            $(this).find('.contents .content').each(function(cIdx){
                $(this).find('[data-name="content_type"]').attr('name', `modules[${mIdx}][contents][${cIdx}][type]`);
                $(this).find('[data-name="content_title"]').attr('name', `modules[${mIdx}][contents][${cIdx}][title]`);
                $(this).find('[data-name="content_body"]').attr('name', `modules[${mIdx}][contents][${cIdx}][body]`);
                $(this).find('[data-name="content_media"]').attr('name', `modules[${mIdx}][contents][${cIdx}][media_url]`);
            });
        });
    }

    // HTML for Content
    function makeContentHtml(){
        return `
            <div class="content card">
                <div class="form-group">
                    <label>Content Type</label>
                    <select data-name="content_type" class="content-type">
                        <option value="text">Text Content</option>
                        <option value="video">Video Content</option>
                        <option value="image">Image Content</option>
                        <option value="link">External Link</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Content Title *</label>
                    <input type="text" data-name="content_title" required>
                </div>
                <div class="form-group body-section">
                    <label>Content Body</label>
                    <textarea data-name="content_body" rows="3"></textarea>
                </div>
                <div class="form-group media-section" style="display:none">
                    <label>Media URL</label>
                    <input type="text" data-name="content_media">
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" class="btn btn-danger removeContentBtn">🗑 Remove Content</button>
                </div>
            </div>
        `;
    }

    // HTML for Module
    function makeModuleHtml(){
        return `
            <div class="module card">
                <div class="form-group">
                    <label>Module Title *</label>
                    <input type="text" data-name="module_title" required>
                </div>
                <div class="nested-content contents"></div>
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" class="btn btn-secondary addContentBtn">➕ Add Content</button>
                    <button type="button" class="btn btn-danger removeModuleBtn">🗑 Remove Module</button>
                </div>
            </div>
        `;
    }

    // Add Module
    $('#addModuleBtn').on('click', function(){
        const $m = $(makeModuleHtml());
        $('#modulesContainer').append($m);
        $m.hide().slideDown();
        updateNames();
    });

    // Add Content
    $('#modulesContainer').on('click', '.addContentBtn', function(){
        const $module = $(this).closest('.module');
        const $content = $(makeContentHtml());
        $module.find('.contents').append($content);
        $content.hide().slideDown();
        updateNames();
    });

    // Remove Content
    $('#modulesContainer').on('click', '.removeContentBtn', function(){
        $(this).closest('.content').slideUp(function(){
            $(this).remove();
            updateNames();
        });
    });

    // Remove Module
    $('#modulesContainer').on('click', '.removeModuleBtn', function(){
        $(this).closest('.module').slideUp(function(){
            $(this).remove();
            updateNames();
        });
    });

    // Toggle between text vs media fields
    $('#modulesContainer').on('change', '.content-type', function(){
        const val = $(this).val();
        const $c = $(this).closest('.content');
        if(val === 'text'){
            $c.find('.media-section').slideUp();
            $c.find('.body-section').slideDown();
        } else {
            $c.find('.body-section').slideUp();
            $c.find('.media-section').slideDown();
        }
    });

    // Add one module and content by default
    $('#addModuleBtn').click();
    $('#modulesContainer .module').first().find('.addContentBtn').click();
});
</script>
@endpush

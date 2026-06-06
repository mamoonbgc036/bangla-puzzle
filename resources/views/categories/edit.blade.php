@extends('layouts.app')
@section('title', 'Edit Category')
@section('topbar-title', 'Edit Category')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('categories.index') }}">Categories</a>
    <span class="breadcrumb-sep">/</span>
    <span>Edit — {{ $category->name }}</span>
</div>
<div class="page-header">
    <div class="page-header-left">
        <h1>Edit Category</h1>
        <p>Update category information</p>
    </div>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="max-width:580px">
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-pencil" style="color:var(--accent);margin-right:6px"></i> Category Details</span>
            <code style="font-size:.72rem;background:var(--bg-base);padding:3px 9px;border-radius:5px;color:var(--accent)">{{ $category->slug }}</code>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label for="name">Category Name <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                           class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                           placeholder="e.g. Electronics" autocomplete="off">
                    @error('name') <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"
                              class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                              placeholder="Optional short description...">{{ old('description', $category->description) }}</textarea>
                    @error('description') <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <div class="toggle-wrap">
                        <label class="toggle">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label">Active</span>
                    </div>
                </div>
                <div style="display:flex;gap:10px;margin-top:20px">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Update Category</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

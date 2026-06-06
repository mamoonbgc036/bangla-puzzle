@extends('layouts.app')
@section('title', 'Add Subcategory')
@section('topbar-title', 'Add Subcategory')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('subcategories.index') }}">Subcategories</a>
    <span class="breadcrumb-sep">/</span>
    <span>Add New</span>
</div>
<div class="page-header">
    <div class="page-header-left">
        <h1>Add Subcategory</h1>
        <p>Create a subcategory within an existing category</p>
    </div>
    <a href="{{ route('subcategories.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="max-width:580px">
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-code-branch" style="color:var(--accent);margin-right:6px"></i> Subcategory Details</span>
        </div>
        <div class="card-body">
            <form action="{{ route('subcategories.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="category_id">Parent Category <span style="color:var(--danger)">*</span></label>
                    <select id="category_id" name="category_id" class="{{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                        <option value="">— Select Category —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="name">Subcategory Name <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                           placeholder="e.g. Smartphones" autocomplete="off">
                    @error('name') <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                              placeholder="Optional description...">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <div class="toggle-wrap">
                        <label class="toggle">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label">Active</span>
                    </div>
                </div>
                <div style="display:flex;gap:10px;margin-top:20px">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Create Subcategory</button>
                    <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

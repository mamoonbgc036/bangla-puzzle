@extends('layouts.app')
@section('title', 'Add Product')
@section('topbar-title', 'Add Product')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('products.index') }}">Products</a>
    <span class="breadcrumb-sep">/</span>
    <span>Add New</span>
</div>
<div class="page-header">
    <div class="page-header-left">
        <h1>Add Product</h1>
        <p>Fill in the details to create a new product</p>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="max-width:680px">
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-box-open" style="color:var(--accent);margin-right:6px"></i> Product Details</span>
        </div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="category_id">Category <span style="color:var(--danger)">*</span></label>
                        <select id="category_id" name="category_id" class="{{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                            <option value="">— Select Category —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="subcategory_id">Subcategory <span style="color:var(--danger)">*</span></label>
                        <select id="subcategory_id" name="subcategory_id" class="{{ $errors->has('subcategory_id') ? 'is-invalid' : '' }}">
                            <option value="">— Select Subcategory —</option>
                            @foreach($subcategories as $sub)
                                <option value="{{ $sub->id }}" {{ old('subcategory_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                            @endforeach
                        </select>
                        @error('subcategory_id') <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Product Name <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                           placeholder="e.g. Samsung Galaxy S24" autocomplete="off">
                    @error('name') <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                              placeholder="Product description...">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="image">Product Image <span style="color:var(--danger)">*</span></label>
                    <input type="file" id="image" name="image" accept="image/jpeg,image/jpg,image/png,image/webp"
                           class="{{ $errors->has('image') ? 'is-invalid' : '' }}">
                    <div class="form-hint">Accepted: JPG, PNG, WebP — Max size: 2MB</div>
                    @error('image') <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    <div id="image-preview" style="margin-top:10px;display:none">
                        <img id="preview-img" src="" alt="Preview"
                             style="width:110px;height:110px;object-fit:cover;border-radius:var(--radius-md);border:1px solid var(--border)">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="old_price">Original Price (৳)</label>
                        <input type="number" id="old_price" name="old_price" value="{{ old('old_price') }}"
                               class="{{ $errors->has('old_price') ? 'is-invalid' : '' }}"
                               placeholder="0.00" step="0.01" min="0">
                        <div class="form-hint">Leave blank if no discount</div>
                        @error('old_price') <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="new_price">Selling Price (৳) <span style="color:var(--danger)">*</span></label>
                        <input type="number" id="new_price" name="new_price" value="{{ old('new_price') }}"
                               class="{{ $errors->has('new_price') ? 'is-invalid' : '' }}"
                               placeholder="0.00" step="0.01" min="0">
                        @error('new_price') <div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <div class="toggle-wrap">
                        <label class="toggle">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label">Active (visible in store)</span>
                    </div>
                </div>

                <div style="display:flex;gap:10px;margin-top:20px;padding-top:18px;border-top:1px solid var(--border)">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Create Product</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const categorySelect    = document.getElementById('category_id');
const subcategorySelect = document.getElementById('subcategory_id');
const imageInput        = document.getElementById('image');
const imagePreview      = document.getElementById('image-preview');
const previewImg        = document.getElementById('preview-img');

categorySelect.addEventListener('change', function () {
    const id = this.value;
    subcategorySelect.innerHTML = '<option value="">Loading...</option>';
    if (!id) { subcategorySelect.innerHTML = '<option value="">— Select Subcategory —</option>'; return; }
    fetch(`/api/subcategories?category_id=${id}`)
        .then(r => r.json())
        .then(data => {
            subcategorySelect.innerHTML = '<option value="">— Select Subcategory —</option>';
            data.forEach(sub => {
                const opt = document.createElement('option');
                opt.value = sub.id; opt.textContent = sub.name;
                subcategorySelect.appendChild(opt);
            });
        });
});

imageInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => { previewImg.src = e.target.result; imagePreview.style.display = 'block'; };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush

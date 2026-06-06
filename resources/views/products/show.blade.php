@extends('layouts.app')
@section('title', $product->name)
@section('topbar-title', $product->name)

@section('content')
<div class="breadcrumb">
    <a href="{{ route('products.index') }}">Products</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('subcategories.show', $product->subcategory) }}">{{ $product->subcategory->name }}</a>
    <span class="breadcrumb-sep">/</span>
    <span>{{ $product->name }}</span>
</div>

<div class="page-header">
    <div class="page-header-left">
        <h1>{{ $product->name }}</h1>
        <p>Product detail view</p>
    </div>
    <div class="actions">
        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary"><i class="fas fa-pencil"></i> Edit</a>
        <form action="{{ route('products.destroy', $product) }}" method="POST" data-confirm="Delete '{{ $product->name }}'?">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
        </form>
        <a href="{{ route('products.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="detail-grid">
    <div>
        <div class="card" style="overflow:hidden">
            @if($product->image)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                     style="width:100%;aspect-ratio:1;object-fit:cover">
            @else
                <div style="width:100%;aspect-ratio:1;display:flex;align-items:center;justify-content:center;background:var(--bg-base);color:var(--text-sm);font-size:3rem">
                    <i class="fas fa-image"></i>
                </div>
            @endif
        </div>

        @if($product->discount_percentage)
        <div style="margin-top:12px;background:linear-gradient(135deg,var(--accent),#a78bfa);border-radius:var(--radius-md);padding:14px 18px;color:#fff;text-align:center">
            <div style="font-size:.75rem;font-weight:600;opacity:.85;text-transform:uppercase;letter-spacing:.06em">You Save</div>
            <div style="font-size:1.5rem;font-weight:800">{{ $product->discount_percentage }}% OFF</div>
        </div>
        @endif
    </div>

    <div style="display:flex;flex-direction:column;gap:14px">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Pricing</span>
                <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span>
            </div>
            <div class="card-body">
                <div style="display:flex;align-items:baseline;gap:12px;margin-bottom:8px">
                    <span style="font-size:2rem;font-weight:800;color:var(--accent)">৳{{ number_format($product->new_price, 2) }}</span>
                    @if($product->old_price)
                        <span class="price-old" style="font-size:1rem">৳{{ number_format($product->old_price, 2) }}</span>
                    @endif
                </div>
                @if($product->old_price && $product->discount_percentage)
                    <div style="font-size:.8rem;color:var(--success);font-weight:600">
                        <i class="fas fa-tag"></i> Save ৳{{ number_format($product->old_price - $product->new_price, 2) }} ({{ $product->discount_percentage }}% off)
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Details</span></div>
            <div class="card-body" style="padding:0">
                <div class="meta-row" style="padding:12px 20px">
                    <div class="meta-key">Slug</div>
                    <div class="meta-val"><code style="font-size:.78rem;background:var(--accent-lt);padding:2px 8px;border-radius:5px;color:var(--accent)">{{ $product->slug }}</code></div>
                </div>
                <div class="meta-row" style="padding:12px 20px">
                    <div class="meta-key">Category</div>
                    <div class="meta-val"><a href="{{ route('categories.show', $product->category) }}" style="color:var(--accent);font-weight:600">{{ $product->category->name }}</a></div>
                </div>
                <div class="meta-row" style="padding:12px 20px">
                    <div class="meta-key">Subcategory</div>
                    <div class="meta-val"><a href="{{ route('subcategories.show', $product->subcategory) }}" style="color:var(--accent);font-weight:600">{{ $product->subcategory->name }}</a></div>
                </div>
                <div class="meta-row" style="padding:12px 20px">
                    <div class="meta-key">Created</div>
                    <div class="meta-val">{{ $product->created_at->format('d M Y, h:i A') }}</div>
                </div>
                <div class="meta-row" style="padding:12px 20px">
                    <div class="meta-key">Updated</div>
                    <div class="meta-val">{{ $product->updated_at->format('d M Y, h:i A') }}</div>
                </div>
            </div>
        </div>

        @if($product->description)
        <div class="card">
            <div class="card-header"><span class="card-title">Description</span></div>
            <div class="card-body">
                <p style="line-height:1.75;color:var(--text-md);font-size:.875rem">{{ $product->description }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Products')
@section('topbar-title', 'Products')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Products</h1>
        <p>Manage your product catalog</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</a>
</div>

@php
    $totalProducts  = \App\Models\Product::count();
    $activeProducts = \App\Models\Product::where('is_active', true)->count();
    $totalValue     = \App\Models\Product::sum('new_price');
@endphp

<div class="stat-grid" style="margin-bottom:20px">
    <div class="stat-card">
        <div class="stat-icon" style="background:#ede9ff;color:var(--accent)"><i class="fas fa-box-open"></i></div>
        <div class="stat-label">Total Products</div>
        <div class="stat-value">{{ $totalProducts }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;color:#16a34a"><i class="fas fa-check-circle"></i></div>
        <div class="stat-label">Active</div>
        <div class="stat-value">{{ $activeProducts }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef2f2;color:#dc2626"><i class="fas fa-ban"></i></div>
        <div class="stat-label">Inactive</div>
        <div class="stat-value">{{ $totalProducts - $activeProducts }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fffbeb;color:#d97706"><i class="fas fa-tag"></i></div>
        <div class="stat-label">Catalog Value</div>
        <div class="stat-value" style="font-size:1.25rem">৳{{ number_format($totalValue, 0) }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-box-open" style="color:var(--accent);margin-right:6px"></i> All Products</span>
    </div>

    <form method="GET" action="{{ route('products.index') }}" style="padding:14px 16px;border-bottom:1px solid var(--border);background:#fafafb">
        <div class="filter-bar" style="margin-bottom:0">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..." style="flex:1;max-width:240px">
            <select name="category" style="max-width:180px">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="subcategory" style="max-width:180px">
                <option value="">All Subcategories</option>
                @foreach($subcategories as $sub)
                    <option value="{{ $sub->id }}" {{ request('subcategory') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-filter"></i> Filter</button>
            @if(request()->hasAny(['search','category','subcategory']))
                <a href="{{ route('products.index') }}" class="btn btn-secondary"><i class="fas fa-xmark"></i> Clear</a>
            @endif
        </div>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>#</th><th>Image</th><th>Name</th><th>Category</th><th>Subcategory</th><th>Price</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td style="color:var(--text-sm);font-weight:500">{{ $products->firstItem() + $loop->index }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="thumb">
                        @else
                            <div class="thumb-placeholder"><i class="fas fa-image"></i></div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" style="font-weight:700;color:var(--text)">{{ $product->name }}</a>
                        <div style="font-size:.68rem;color:var(--text-sm);margin-top:1px">{{ $product->slug }}</div>
                    </td>
                    <td>
                        <span style="font-size:.78rem;color:var(--text-md);background:var(--bg-base);padding:2px 8px;border-radius:99px;border:1px solid var(--border)">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td>
                        <span style="font-size:.78rem;color:var(--text-md)">{{ $product->subcategory->name }}</span>
                    </td>
                    <td>
                        <div class="price-new">৳{{ number_format($product->new_price, 2) }}</div>
                        @if($product->old_price)
                            <div class="price-old">৳{{ number_format($product->old_price, 2) }}</div>
                        @endif
                        @if($product->discount_percentage)
                            <span class="pill-discount">-{{ $product->discount_percentage }}%</span>
                        @endif
                    </td>
                    <td><span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary btn-sm"><i class="fas fa-pencil"></i></a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" data-confirm="Delete '{{ $product->name }}'?">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8">
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-box-open"></i></div>
                        <h3>No products found</h3>
                        <p><a href="{{ route('products.create') }}" style="color:var(--accent)">Add your first product</a></p>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $products->links('vendor.pagination.custom') }}
@endsection

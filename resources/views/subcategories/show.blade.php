@extends('layouts.app')
@section('title', $subcategory->name)
@section('topbar-title', $subcategory->name)

@section('content')
<div class="breadcrumb">
    <a href="{{ route('categories.index') }}">Categories</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('categories.show', $subcategory->category) }}">{{ $subcategory->category->name }}</a>
    <span class="breadcrumb-sep">/</span>
    <span>{{ $subcategory->name }}</span>
</div>
<div class="page-header">
    <div class="page-header-left">
        <h1>{{ $subcategory->name }}</h1>
        <p><code style="font-size:.72rem;background:var(--accent-lt);padding:2px 8px;border-radius:5px;color:var(--accent)">{{ $subcategory->slug }}</code></p>
    </div>
    <div class="actions">
        <a href="{{ route('subcategories.edit', $subcategory) }}" class="btn btn-secondary"><i class="fas fa-pencil"></i> Edit</a>
        <a href="{{ route('subcategories.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-box-open" style="color:var(--accent);margin-right:6px"></i> Products ({{ $subcategory->products->count() }})</span>
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Image</th><th>Name</th><th>New Price</th><th>Old Price</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($subcategory->products as $product)
                <tr>
                    <td>
                        @if($product->image)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="thumb">
                        @else
                            <div class="thumb-placeholder"><i class="fas fa-image"></i></div>
                        @endif
                    </td>
                    <td style="font-weight:700">{{ $product->name }}</td>
                    <td><span class="price-new">৳{{ number_format($product->new_price, 2) }}</span></td>
                    <td>@if($product->old_price)<span class="price-old">৳{{ number_format($product->old_price, 2) }}</span>@else<span style="color:var(--text-sm)">—</span>@endif</td>
                    <td><span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary btn-sm"><i class="fas fa-pencil"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6">
                    <div class="empty-state" style="padding:2rem">
                        <div class="empty-icon"><i class="fas fa-box-open"></i></div>
                        <p>No products yet. <a href="{{ route('products.create') }}" style="color:var(--accent)">Add one</a></p>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

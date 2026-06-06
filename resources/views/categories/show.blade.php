@extends('layouts.app')
@section('title', $category->name)
@section('topbar-title', $category->name)

@section('content')
<div class="breadcrumb">
    <a href="{{ route('categories.index') }}">Categories</a>
    <span class="breadcrumb-sep">/</span>
    <span>{{ $category->name }}</span>
</div>
<div class="page-header">
    <div class="page-header-left">
        <h1>{{ $category->name }}</h1>
        <p><code style="font-size:.72rem;background:var(--accent-lt);padding:2px 8px;border-radius:5px;color:var(--accent)">{{ $category->slug }}</code></p>
    </div>
    <div class="actions">
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary"><i class="fas fa-pencil"></i> Edit</a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

@if($category->description)
<p style="color:var(--text-md);margin-bottom:20px;font-size:.875rem">{{ $category->description }}</p>
@endif

<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-sitemap" style="color:var(--accent);margin-right:6px"></i> Subcategories ({{ $category->subcategories->count() }})</span>
        <a href="{{ route('subcategories.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Subcategory</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Name</th><th>Slug</th><th>Products</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($category->subcategories as $sub)
                <tr>
                    <td style="font-weight:700">{{ $sub->name }}</td>
                    <td><code style="font-size:.72rem;background:var(--bg-base);padding:2px 7px;border-radius:5px;color:var(--accent)">{{ $sub->slug }}</code></td>
                    <td><span style="font-weight:600">{{ $sub->products_count }}</span></td>
                    <td><span class="badge {{ $sub->is_active ? 'badge-success' : 'badge-danger' }}">{{ $sub->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('subcategories.show', $sub) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('subcategories.edit', $sub) }}" class="btn btn-secondary btn-sm"><i class="fas fa-pencil"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5">
                    <div class="empty-state" style="padding:2rem">
                        <div class="empty-icon"><i class="fas fa-sitemap"></i></div>
                        <p>No subcategories yet. <a href="{{ route('subcategories.create') }}" style="color:var(--accent)">Add one</a></p>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

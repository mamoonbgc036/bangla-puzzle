@extends('layouts.app')
@section('title', 'Categories')
@section('topbar-title', 'Categories')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Categories</h1>
        <p>Manage your product categories</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Category
    </a>
</div>

<div class="stat-grid" style="grid-template-columns:repeat(auto-fit,minmax(140px,1fr));margin-bottom:20px">
    @php
        $total = $categories->total();
        $active = \App\Models\Category::where('is_active',true)->count();
    @endphp
    <div class="stat-card">
        <div class="stat-icon" style="background:#ede9ff;color:var(--accent)"><i class="fas fa-layer-group"></i></div>
        <div class="stat-label">Total</div>
        <div class="stat-value">{{ $total }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;color:#16a34a"><i class="fas fa-check-circle"></i></div>
        <div class="stat-label">Active</div>
        <div class="stat-value">{{ $active }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef2f2;color:#dc2626"><i class="fas fa-ban"></i></div>
        <div class="stat-label">Inactive</div>
        <div class="stat-value">{{ $total - $active }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-layer-group" style="color:var(--accent);margin-right:6px"></i> All Categories</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Subcategories</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td style="color:var(--text-sm);font-weight:500">{{ $categories->firstItem() + $loop->index }}</td>
                    <td>
                        <a href="{{ route('categories.show', $category) }}" style="font-weight:700;color:var(--text)">
                            {{ $category->name }}
                        </a>
                    </td>
                    <td><code style="font-size:.72rem;background:var(--bg-base);padding:2px 7px;border-radius:5px;color:var(--accent)">{{ $category->slug }}</code></td>
                    <td><span style="font-weight:600">{{ $category->subcategories_count }}</span></td>
                    <td><span style="font-weight:600">{{ $category->products_count }}</span></td>
                    <td>
                        <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td style="color:var(--text-sm)">{{ $category->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary btn-sm"><i class="fas fa-pencil"></i></a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                  data-confirm="Delete '{{ $category->name }}'? This will also remove subcategories and products.">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8">
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-layer-group"></i></div>
                        <h3>No categories yet</h3>
                        <p><a href="{{ route('categories.create') }}" style="color:var(--accent)">Create your first category</a></p>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $categories->links('vendor.pagination.custom') }}
@endsection

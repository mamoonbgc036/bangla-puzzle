@extends('layouts.app')
@section('title', 'Subcategories')
@section('topbar-title', 'Subcategories')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Subcategories</h1>
        <p>Manage subcategories within your categories</p>
    </div>
    <a href="{{ route('subcategories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Subcategory</a>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-sitemap" style="color:var(--accent);margin-right:6px"></i> All Subcategories</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>#</th><th>Name</th><th>Category</th><th>Slug</th><th>Products</th><th>Status</th><th>Created</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($subcategories as $sub)
                <tr>
                    <td style="color:var(--text-sm);font-weight:500">{{ $subcategories->firstItem() + $loop->index }}</td>
                    <td><a href="{{ route('subcategories.show', $sub) }}" style="font-weight:700;color:var(--text)">{{ $sub->name }}</a></td>
                    <td>
                        <a href="{{ route('categories.show', $sub->category) }}"
                           style="display:inline-flex;align-items:center;gap:5px;font-size:.8rem;color:var(--text-md);background:var(--bg-base);padding:3px 9px;border-radius:99px;border:1px solid var(--border)">
                            <i class="fas fa-layer-group" style="font-size:10px"></i> {{ $sub->category->name }}
                        </a>
                    </td>
                    <td><code style="font-size:.72rem;background:var(--bg-base);padding:2px 7px;border-radius:5px;color:var(--accent)">{{ $sub->slug }}</code></td>
                    <td><span style="font-weight:600">{{ $sub->products_count }}</span></td>
                    <td><span class="badge {{ $sub->is_active ? 'badge-success' : 'badge-danger' }}">{{ $sub->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td style="color:var(--text-sm)">{{ $sub->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('subcategories.show', $sub) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('subcategories.edit', $sub) }}" class="btn btn-secondary btn-sm"><i class="fas fa-pencil"></i></a>
                            <form action="{{ route('subcategories.destroy', $sub) }}" method="POST" data-confirm="Delete '{{ $sub->name }}'?">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8">
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-sitemap"></i></div>
                        <h3>No subcategories yet</h3>
                        <p><a href="{{ route('subcategories.create') }}" style="color:var(--accent)">Create your first subcategory</a></p>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $subcategories->links('vendor.pagination.custom') }}
@endsection

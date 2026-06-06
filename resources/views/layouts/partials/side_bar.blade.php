<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-store"></i></div>
        <div class="brand-name">Bangla<span>Puzzle</span></div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Main Menu</div>
        <a href="{{ route('products.index') }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="fas fa-box-open"></i> Products
            @php $pc = \App\Models\Product::count(); @endphp
            @if ($pc)
                <span class="nav-badge">{{ $pc }}</span>
            @endif
        </a>
        <a href="{{ route('categories.index') }}"
            class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i> Categories
            @php $cc = \App\Models\Category::count(); @endphp
            @if ($cc)
                <span class="nav-badge">{{ $cc }}</span>
            @endif
        </a>
        <a href="{{ route('subcategories.index') }}"
            class="nav-item {{ request()->routeIs('subcategories.*') ? 'active' : '' }}">
            <i class="fas fa-sitemap"></i> Subcategories
            @php $sc = \App\Models\Subcategory::count(); @endphp
            @if ($sc)
                <span class="nav-badge">{{ $sc }}</span>
            @endif
        </a>
        <div class="nav-label">Quick Add</div>
        <a href="{{ route('products.create') }}"
            class="nav-item {{ request()->is('products/create') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> Add Product
        </a>
        <a href="{{ route('categories.create') }}"
            class="nav-item {{ request()->is('categories/create') ? 'active' : '' }}">
            <i class="fas fa-folder-plus"></i> Add Category
        </a>
        <a href="{{ route('subcategories.create') }}"
            class="nav-item {{ request()->is('subcategories/create') ? 'active' : '' }}">
            <i class="fas fa-code-branch"></i> Add Subcategory
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar">AD</div>
            <div>
                <div class="user-name">Admin</div>
                <div class="user-role">ShopNest Admin</div>
            </div>
        </div>
    </div>
</aside>

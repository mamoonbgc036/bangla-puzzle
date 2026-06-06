# ShopNest — Laravel E-Commerce Platform

A simplified e-commerce platform built with Laravel featuring full CRUD operations for Categories, Subcategories, and Products. Submitted for the Mid Laravel Developer position at Bangla Puzzle Limited.

---

Live Demo

🔗 Live Website: https://gngtexint.com/

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Project Structure](#project-structure)
- [Database Design](#database-design)
- [Features & Routes](#features--routes)
- [Code Architecture](#code-architecture)
- [Slug System](#slug-system)
- [Image Handling](#image-handling)
- [Validation](#validation)

---

## Requirements

- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Laravel 10.x or 11.x

---

## Installation

```bash
# 1. Clone / copy the project files into a new Laravel installation
composer create-project laravel/laravel shopnest
cd shopnest

# 2. Copy all provided source files into the project

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Edit .env — set your database credentials
DB_DATABASE=shopnest
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations
php artisan migrate

# 6. Create image upload directory
mkdir -p public/uploads/products

# 7. Serve
php artisan serve
```

Visit `http://127.0.0.1:8000` — it redirects to the Products listing.

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── CategoryController.php       # CRUD for categories
│   │   ├── SubcategoryController.php    # CRUD for subcategories
│   │   └── ProductController.php        # CRUD for products + AJAX subcategory fetch
│   └── Requests/
│       ├── CategoryRequest.php          # Validation rules for category forms
│       ├── SubcategoryRequest.php       # Validation rules for subcategory forms
│       └── ProductRequest.php           # Validation rules for product forms
├── Models/
│   ├── Category.php                     # Model with slug auto-generation & relationships
│   ├── Subcategory.php                  # Model with slug auto-generation & relationships
│   └── Product.php                      # Model with image URL accessor, discount % accessor
database/
└── migrations/
    ├── ..._create_categories_table.php
    ├── ..._create_subcategories_table.php
    └── ..._create_products_table.php
resources/views/
├── layouts/
│   └── app.blade.php                    # Shared layout: nav, alerts, styles
├── categories/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── subcategories/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── products/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── vendor/pagination/
    └── custom.blade.php                 # Custom pagination component
routes/
└── web.php                              # All application routes
```

---

## Database Design

### `categories`
| Column       | Type         | Notes                    |
|-------------|--------------|--------------------------|
| id           | bigint PK    |                          |
| name         | varchar(255) | Unique (non-deleted)     |
| slug         | varchar(255) | Unique, auto-generated   |
| description  | text         | Nullable                 |
| is_active    | boolean      | Default true             |
| created_at   | timestamp    |                          |
| updated_at   | timestamp    |                          |
| deleted_at   | timestamp    | Soft delete              |

### `subcategories`
| Column       | Type         | Notes                          |
|-------------|--------------|--------------------------------|
| id           | bigint PK    |                                |
| category_id  | bigint FK    | → categories.id (cascade del) |
| name         | varchar(255) | Unique (non-deleted)           |
| slug         | varchar(255) | Unique, auto-generated         |
| description  | text         | Nullable                       |
| is_active    | boolean      | Default true                   |
| created_at   | timestamp    |                                |
| updated_at   | timestamp    |                                |
| deleted_at   | timestamp    | Soft delete                    |

### `products`
| Column         | Type           | Notes                               |
|---------------|----------------|-------------------------------------|
| id             | bigint PK      |                                     |
| category_id    | bigint FK      | → categories.id (cascade del)      |
| subcategory_id | bigint FK      | → subcategories.id (cascade del)   |
| name           | varchar(255)   | Unique (non-deleted)                |
| slug           | varchar(255)   | Unique, auto-generated              |
| description    | text           | Nullable                            |
| image          | varchar(255)   | Filename stored in uploads/products |
| old_price      | decimal(10,2)  | Nullable                            |
| new_price      | decimal(10,2)  | Required                            |
| is_active      | boolean        | Default true                        |
| created_at     | timestamp      |                                     |
| updated_at     | timestamp      |                                     |
| deleted_at     | timestamp      | Soft delete                         |

**Relationships:**
- `Category` → hasMany `Subcategory`, hasMany `Product`
- `Subcategory` → belongsTo `Category`, hasMany `Product`
- `Product` → belongsTo `Category`, belongsTo `Subcategory`

---

## Features & Routes

### Routes (`routes/web.php`)

```
GET    /                          → redirect to /products
GET    /categories                → CategoryController@index
GET    /categories/create         → CategoryController@create
POST   /categories                → CategoryController@store
GET    /categories/{slug}         → CategoryController@show
GET    /categories/{slug}/edit    → CategoryController@edit
PUT    /categories/{slug}         → CategoryController@update
DELETE /categories/{slug}         → CategoryController@destroy

GET    /subcategories             → SubcategoryController@index
GET    /subcategories/create      → SubcategoryController@create
POST   /subcategories             → SubcategoryController@store
GET    /subcategories/{slug}      → SubcategoryController@show
GET    /subcategories/{slug}/edit → SubcategoryController@edit
PUT    /subcategories/{slug}      → SubcategoryController@update
DELETE /subcategories/{slug}      → SubcategoryController@destroy

GET    /products                  → ProductController@index  (+ search/filter)
GET    /products/create           → ProductController@create
POST   /products                  → ProductController@store
GET    /products/{slug}           → ProductController@show
GET    /products/{slug}/edit      → ProductController@edit
PUT    /products/{slug}           → ProductController@update
DELETE /products/{slug}           → ProductController@destroy

GET    /api/subcategories?category_id={id}  → AJAX: subcategories by category
```

All resource routes use **slug** as the route key (`getRouteKeyName()` returns `'slug'`).

---

## Code Architecture

### Form Requests (Validation Layer)
Each entity has a dedicated `FormRequest` class in `app/Http/Requests/`. This keeps controllers slim and validation logic centralized:

- `CategoryRequest` — name required/unique/length, description optional
- `SubcategoryRequest` — category_id must exist, name required/unique/length
- `ProductRequest` — category+subcategory must exist, name unique, image required on create / optional on update, prices numeric

### Controllers
Each controller follows standard Laravel resource conventions. Methods:

| Method    | Action                                         |
|-----------|------------------------------------------------|
| `index`   | Paginated listing with eager-loaded counts     |
| `create`  | Show form (passes dropdown data)               |
| `store`   | Validate → create → redirect with flash        |
| `show`    | Load model with relations → detail view        |
| `edit`    | Show pre-filled form                           |
| `update`  | Validate → update → redirect with flash        |
| `destroy` | Soft-delete → redirect with flash              |

`ProductController` also has `getSubcategories()` for AJAX-driven subcategory filtering when a category is selected in forms.

### Models
All three models share a `generateUniqueSlug()` static method that ensures collision-free slugs by appending a counter suffix when needed. Slugs are auto-generated on `creating` and regenerated on `updating` only if `name` changed.

`Product` has two Eloquent accessors:
- `discount_percentage` — calculated from old/new price
- `image_url` — full public URL for the stored image filename

---

## Slug System

Slugs are generated automatically via Model boot events using `Str::slug()`. Uniqueness is guaranteed:

```
"Samsung Galaxy S24"  →  samsung-galaxy-s24
"Samsung Galaxy S24"  →  samsung-galaxy-s24-1   (if already taken)
"Samsung Galaxy S24"  →  samsung-galaxy-s24-2   (if both taken)
```

On update, the slug only regenerates if the `name` field changed, preserving existing URLs.

All routes bind models by slug via `getRouteKeyName()` returning `'slug'`.

---

## Image Handling

- Images are stored in `public/uploads/products/`
- Filename pattern: `{timestamp}_{original_filename}` to avoid collisions
- On product update: old image file is deleted from disk before saving the new one
- On product delete: associated image file is deleted from disk
- The `image_url` accessor returns the full asset URL; a placeholder icon is shown when no image exists

---

## Validation Summary

| Field          | Rules                                                          |
|---------------|----------------------------------------------------------------|
| Category name  | required, string, min:2, max:100, unique (ignores soft-deleted)|
| Sub. name      | required, string, min:2, max:100, unique                      |
| Sub. category  | required, exists in categories table                          |
| Product name   | required, string, min:2, max:200, unique                      |
| Product image  | required on create / optional on update, image, max 2MB, jpeg/png/webp |
| new_price      | required, numeric, min:0                                      |
| old_price      | nullable, numeric, min:0                                      |
| category_id    | required, exists                                              |
| subcategory_id | required, exists                                              |

All validation errors display inline beneath their fields with a red indicator.

---

## Additional Notes

- **Soft Deletes** are enabled on all three models — records are not permanently removed from the database, allowing for potential restoration.
- **Cascade Deletes** are set at the database level: deleting a Category removes its Subcategories and Products; deleting a Subcategory removes its Products.
- **Pagination** uses a custom Blade view (`vendor/pagination/custom.blade.php`) styled to match the dark UI.
- **AJAX Subcategory Loading**: When editing/creating products, selecting a Category dynamically fetches its Subcategories via `/api/subcategories` without a page reload.
- **Search & Filter** on the Products index supports filtering by Category, Subcategory, and a name keyword simultaneously.

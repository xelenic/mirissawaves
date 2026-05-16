# Admin Panel Styling Guide - Mirissawaves

## 📍 **Where to Find Admin Styles**

### **1. Main Admin Layout**
- **File:** `resources/views/layouts/admin.blade.php`
- **Contains:** Inline styles + Tailwind CSS + FontAwesome
- **Purpose:** Base admin layout styling

### **2. Dedicated Admin CSS**
- **File:** `resources/css/admin.css`
- **Contains:** Comprehensive admin-specific styles
- **Purpose:** Reusable admin components and utilities

### **3. Global Styles**
- **File:** `resources/css/app.css`
- **Contains:** Tailwind CSS + custom animations
- **Purpose:** Global application styles

## 🎨 **Available Admin CSS Classes**

### **Page Layout**
```html
<!-- Page Header -->
<div class="admin-page-header">
    <h1 class="admin-page-title">Page Title</h1>
    <p class="admin-page-subtitle">Page Description</p>
</div>

<!-- Main Container -->
<div class="container-fluid">
    <!-- Your content here -->
</div>
```

### **Cards**
```html
<!-- Basic Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title">Card Title</h5>
    </div>
    <div class="admin-card-body">
        <!-- Card content -->
    </div>
</div>

<!-- Stats Card -->
<div class="admin-stats-card">
    <div class="admin-stats-icon">
        <i class="fas fa-users"></i>
    </div>
    <div class="admin-stats-number">1,234</div>
    <div class="admin-stats-label">Total Users</div>
</div>

<!-- Filter Card -->
<div class="admin-filter-card">
    <!-- Filter form content -->
</div>
```

### **Tables**
```html
<div class="admin-card">
    <div class="admin-card-body">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Column 1</th>
                    <th>Column 2</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Data 1</td>
                    <td>Data 2</td>
                    <td>
                        <button class="admin-btn admin-btn-sm admin-btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
```

### **Badges**
```html
<span class="admin-badge admin-badge-success">Active</span>
<span class="admin-badge admin-badge-warning">Pending</span>
<span class="admin-badge admin-badge-danger">Inactive</span>
<span class="admin-badge admin-badge-info">Info</span>
<span class="admin-badge admin-badge-secondary">Secondary</span>
```

### **Buttons**
```html
<!-- Primary Button -->
<button class="admin-btn admin-btn-primary">
    <i class="fas fa-save"></i> Save
</button>

<!-- Secondary Button -->
<button class="admin-btn admin-btn-secondary">
    <i class="fas fa-cancel"></i> Cancel
</button>

<!-- Success Button -->
<button class="admin-btn admin-btn-success">
    <i class="fas fa-check"></i> Confirm
</button>

<!-- Danger Button -->
<button class="admin-btn admin-btn-danger">
    <i class="fas fa-trash"></i> Delete
</button>

<!-- Warning Button -->
<button class="admin-btn admin-btn-warning">
    <i class="fas fa-exclamation"></i> Warning
</button>

<!-- Outline Buttons -->
<button class="admin-btn admin-btn-outline-primary">Outline Primary</button>
<button class="admin-btn admin-btn-outline-danger">Outline Danger</button>

<!-- Button Sizes -->
<button class="admin-btn admin-btn-sm admin-btn-primary">Small</button>
<button class="admin-btn admin-btn-primary">Normal</button>
<button class="admin-btn admin-btn-lg admin-btn-primary">Large</button>
```

### **Forms**
```html
<div class="admin-form-group">
    <label class="admin-form-label">Field Label</label>
    <input type="text" class="admin-form-control" placeholder="Enter value">
    <div class="invalid-feedback">Error message</div>
</div>

<div class="admin-form-group">
    <label class="admin-form-label">Select Field</label>
    <select class="admin-form-control">
        <option>Option 1</option>
        <option>Option 2</option>
    </select>
</div>

<div class="admin-form-group">
    <label class="admin-form-label">Textarea</label>
    <textarea class="admin-form-control" rows="4"></textarea>
</div>
```

### **Alerts**
```html
<div class="admin-alert admin-alert-success">
    <i class="fas fa-check-circle"></i> Success message
</div>

<div class="admin-alert admin-alert-danger">
    <i class="fas fa-exclamation-circle"></i> Error message
</div>

<div class="admin-alert admin-alert-warning">
    <i class="fas fa-exclamation-triangle"></i> Warning message
</div>

<div class="admin-alert admin-alert-info">
    <i class="fas fa-info-circle"></i> Info message
</div>
```

### **Empty States**
```html
<div class="admin-empty-state">
    <div class="admin-empty-state-icon">
        <i class="fas fa-inbox"></i>
    </div>
    <h3 class="admin-empty-state-title">No Data Found</h3>
    <p class="admin-empty-state-text">There are no items to display.</p>
    <button class="admin-btn admin-btn-primary">
        <i class="fas fa-plus"></i> Add New Item
    </button>
</div>
```

### **Pagination**
```html
<div class="admin-pagination">
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link" href="#">Previous</a>
        </li>
        <li class="page-item active">
            <a class="page-link" href="#">1</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</div>
```

### **Utility Classes**
```html
<!-- Text Alignment -->
<div class="admin-text-center">Centered text</div>
<div class="admin-text-right">Right aligned text</div>
<div class="admin-text-left">Left aligned text</div>

<!-- Margins -->
<div class="admin-mb-0">No bottom margin</div>
<div class="admin-mb-1">Small bottom margin</div>
<div class="admin-mb-2">Medium bottom margin</div>
<div class="admin-mb-3">Large bottom margin</div>
<div class="admin-mb-4">Extra large bottom margin</div>
<div class="admin-mb-5">Maximum bottom margin</div>

<!-- Flexbox -->
<div class="admin-d-flex admin-align-items-center admin-justify-content-between">
    <span>Left content</span>
    <span>Right content</span>
</div>

<!-- Gaps -->
<div class="admin-d-flex admin-gap-2">
    <button class="admin-btn admin-btn-primary">Button 1</button>
    <button class="admin-btn admin-btn-secondary">Button 2</button>
</div>
```

### **Animations**
```html
<div class="admin-fade-in">Fade in animation</div>
<div class="admin-slide-in">Slide in animation</div>
```

## 🎯 **How to Style Other Admin Pages**

### **Step 1: Use the Admin Layout**
```php
@extends('layouts.admin')

@section('title', 'Your Page Title - Admin Panel')

@section('content')
<!-- Your content here -->
@endsection
```

### **Step 2: Apply Admin CSS Classes**
Use the classes from the guide above to style your content consistently.

### **Step 3: Example Page Structure**
```html
@extends('layouts.admin')

@section('title', 'Users Management - Admin Panel')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="admin-page-header">
        <h1 class="admin-page-title">Users Management</h1>
        <p class="admin-page-subtitle">Manage system users</p>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="admin-stats-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="admin-stats-number">1,234</div>
                <div class="admin-stats-label">Total Users</div>
            </div>
        </div>
        <!-- More stats cards... -->
    </div>

    <!-- Filter Card -->
    <div class="admin-filter-card">
        <form class="row g-3">
            <div class="col-md-3">
                <input type="text" class="admin-form-control" placeholder="Search users...">
            </div>
            <div class="col-md-2">
                <select class="admin-form-control">
                    <option>All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="admin-btn admin-btn-primary">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h5 class="admin-card-title">Users List</h5>
        </div>
        <div class="admin-card-body">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>john@example.com</td>
                        <td><span class="admin-badge admin-badge-success">Active</span></td>
                        <td>
                            <button class="admin-btn admin-btn-sm admin-btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="admin-btn admin-btn-sm admin-btn-outline-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="admin-pagination">
        <!-- Pagination links -->
    </div>
</div>
@endsection
```

## 🎨 **Customization**

### **Adding Custom Styles**
1. **Add to admin.css:** For reusable components
2. **Add to admin layout:** For page-specific styles
3. **Use @push('styles'):** For individual page styles

### **Color Scheme**
- **Primary:** #3b82f6 (Blue)
- **Success:** #10b981 (Green)
- **Warning:** #f59e0b (Orange)
- **Danger:** #ef4444 (Red)
- **Secondary:** #6b7280 (Gray)

### **Typography**
- **Font Family:** Inter (sans-serif)
- **Headings:** Playfair Display (serif)
- **Font Sizes:** Responsive scaling

This comprehensive styling system ensures consistent, professional-looking admin pages throughout your application!

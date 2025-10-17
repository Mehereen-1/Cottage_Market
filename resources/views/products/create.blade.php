<!DOCTYPE html>
<html>
<head>
    <title>Create Product</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; max-width: 600px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        textarea { height: 100px; }
        button { background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .error { color: red; margin-top: 5px; }
    </style>
</head>
<body>
    <h1>Create New Product</h1>
    
    <p><a href="{{ route('products.index') }}">← Back to My Products</a></p>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title">Product Title *</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price ($) *</label>
            <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category *</label>
            <select id="category" name="category" class="form-select" onchange="toggleNewCategory(this)">
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
                <option value="custom">➕ Add New Category</option>
            </select>

            <input type="text" id="newCategory" name="new_category" placeholder="Enter new category"
                class="form-control mt-2" style="display:none;">
        </div>


        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" id="image" name="image" accept="image/*">
            <small>Maximum file size: 2MB</small>
        </div>

        <button type="submit">Create Product</button>
    </form>

    <script>
        function toggleNewCategory(select) {
            const newCatInput = document.getElementById('newCategory');
            if (select.value === 'custom') {
                newCatInput.style.display = 'block';
            } else {
                newCatInput.style.display = 'none';
                newCatInput.value = '';
            }
        }
    </script>
</body>
</html>

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Create Product</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf
        <div class="col-12">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control form-control-sm" name="product_name" value="{{ old('product_name') }}" required>
        </div>
        
        <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control form-control-sm" name="description">{{ old('description') }}</textarea>
        </div>

        <div class="col-12 col-md-6">
            <label for="genre" class="form-label">Genre</label>
            <select name="genre" id="genre" class="form-select form-select-sm">
                <option value="Sci-Fi">Sci-Fi</option>
                <option value="Romance">Romance</option>
                <option value="Horror">Horror</option>
                <option value="Comedy">Comedy</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Action">Action</option>
            </select>
        </div>

        <div class="col-12 col-md-6">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control form-control-sm" name="price" value="{{ old('price') }}" required id="price">
        </div>

        <div class="col-12 col-md-6">
            <label for="discount" class="form-label">Discount Percentage</label>
            <select id="discount" name="discount" class="form-select form-select-sm">
                <option value="0">No Discount</option>
                <option value="10" {{ old('discount') == 10 ? 'selected' : '' }}>10%</option>
                <option value="20" {{ old('discount') == 20 ? 'selected' : '' }}>20%</option>
                <option value="30" {{ old('discount') == 30 ? 'selected' : '' }}>30%</option>
                <option value="50" {{ old('discount') == 50 ? 'selected' : '' }}>50%</option>
            </select>
        </div>

        <div class="col-12 col-md-6">
            <label for="discounted_price" class="form-label">Discounted Price</label>
            <input type="text" id="discounted_price" class="form-control form-control-sm" value="{{ old('discounted_price') }}" readonly>
        </div>

        <div class="col-12 col-md-6">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control form-control-sm" name="stock" value="{{ old('stock') }}" required>
        </div>

        <div class="col-12">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control form-control-sm" name="image">
        </div>

        <div class="col-12 text-center">
        <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </div>
    </form>
</div>

<script>
    function calculateDiscount() {
        let price = parseFloat(document.getElementById('price').value);
        let discount = parseFloat(document.getElementById('discount').value);
        if (!isNaN(price) && !isNaN(discount)) {
            let discountedPrice = price - (price * (discount / 100));
            document.getElementById('discounted_price').value = discountedPrice.toFixed(2);
        } else {
            document.getElementById('discounted_price').value = '';
        }
    }

    document.getElementById('price').addEventListener('input', calculateDiscount);
    document.getElementById('discount').addEventListener('change', calculateDiscount);

    window.onload = function() {
        calculateDiscount();
    };
</script>

@endsection

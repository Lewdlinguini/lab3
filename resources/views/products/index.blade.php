@extends('layouts.app')

@section('title', 'Products List')

@section('content')

<div class="d-flex justify-content-center align-items-start" style="min-height: 90vh;">
    <div class="card w-100">
        <div class="card-header bg-light">
            <div class="card-header bg-light">
                <h3 class="d-flex align-items-center gap-2" style="font-size: 1.5rem; font-weight: bold; color: #444;">
                    <span>📖༄</span>
                    <div class="d-flex flex-wrap gap-2 flex-grow-1">
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary flex-fill text-center">All</a>
                        <a href="{{ route('products.index', ['genre' => 'Sci-Fi']) }}" class="btn btn-sm btn-outline-success flex-fill text-center">Sci-Fi</a>
                        <a href="{{ route('products.index', ['genre' => 'Romance']) }}" class="btn btn-sm btn-outline-danger flex-fill text-center">Romance</a>
                        <a href="{{ route('products.index', ['genre' => 'Horror']) }}" class="btn btn-sm btn-outline-dark flex-fill text-center">Horror</a>
                        <a href="{{ route('products.index', ['genre' => 'Comedy']) }}" class="btn btn-sm btn-outline-warning flex-fill text-center">Comedy</a>
                        <a href="{{ route('products.index', ['genre' => 'Fantasy']) }}" class="btn btn-sm btn-outline-info flex-fill text-center">Fantasy</a>
                        <a href="{{ route('products.index', ['genre' => 'Action']) }}" class="btn btn-sm btn-outline-secondary flex-fill text-center">Action</a>
                    </div>
                </h3>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" id="successMessage">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('products.index') }}" method="GET" class="mb-3">
                <div class="input-group" style="max-width: 300px; margin: 0 auto;">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search Products" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary btn-sm" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- Only show 'Add New Product' button if the user is an admin -->
            @if(auth()->user()->role->name === 'Admin')
                <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Add New Product</a>
            @endif

            <table class="table table-striped text-center align-middle">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" 
                                 alt="{{ $product->product_name }}" 
                                 class="img-fluid product-image">
                        @else
                            <img src="https://via.placeholder.com/150x150" 
                                 alt="No Image" 
                                 class="img-fluid product-image">
                        @endif
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="product-title" onclick="showProductDetails(
                            '{{ $product->product_name }}', 
                            '{{ $product->description }}', 
                            {{ $product->price }},
                            '{{ asset('images/' . $product->image) }}', 
                            {{ $product->discount ? $product->discount : 0 }},
                            '{{ $product->genre }}'
                        )">
                            {{ $product->product_name }}
                        </a>
                    </td>
                    <td>
                        @if ($product->discount)
                            <span class="text-muted text-decoration-line-through">${{ number_format($product->price, 2) }}</span>
                            <br>
                            <span class="text-success">${{ number_format($product->price * (1 - $product->discount / 100), 2) }} ({{ $product->discount }}% off)</span>
                        @else
                            ${{ number_format($product->price, 2) }}
                        @endif
                    </td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Product Actions">
                            @if($product->stock > 0)
                                <form action="{{ route('products.buy', $product) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm mx-2">
                                        <i class="bi bi-cart"></i> Buy
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn btn-secondary btn-sm mx-2" onclick="showOutOfStockModal()">
                                    <i class="bi bi-cart"></i> Out of Stock
                                </button>
                            @endif

                            <!-- Show Edit and Delete buttons only for Admin -->
                            @if(auth()->user()->role->name === 'Admin')
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm mx-2">
                                    <i class="bi bi-brush"></i> Edit
                                </a>

                                <button type="button" class="btn btn-danger btn-sm mx-2" onclick="showDeleteModal('{{ route('products.destroy', $product) }}')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        </div>
    </div>
</div>
<div class="modal" id="productDetailsModal" tabindex="-1" role="dialog" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productDetailsModalLabel">Book Details</h5>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center">
                <div class="d-flex">
                    <!-- Product Image -->
                    <img id="productImage" src="" alt="Product Image" class="img-fluid" style="width: 200px; height: 200px; object-fit: cover; margin-right: 20px;">
                    <div>
                        <!-- Product Info -->
                        <h5 id="productTitle"></h5>
                        <p id="productDescription"></p>
                        <p id="productGenre"></p>
                        <p id="productPrice"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="hideProductDetailsModal()">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Delete Modal -->
<div class="modal" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="hideDeleteModal()">Cancel</button>
                <form id="deleteForm" method="POST" action="" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Out of Stock Modal -->
<div class="modal" id="outOfStockModal" tabindex="-1" role="dialog" aria-labelledby="outOfStockModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="outOfStockModalLabel">Out of Stock</h5>
            </div>
            <div class="modal-body">
                Sorry, this product is currently out of stock.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="hideOutOfStockModal()">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .product-image {
        width: 75px; 
        height: 75px;
        object-fit: cover;
        border-radius: 5px; 
    }

    .table th, .table td {
        vertical-align: middle; 
        text-align: center; 
    }

    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5) !important; 
    }

    .modal {
        display: none; 
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(8px); 
    }

    .modal-content {
        border-radius: 10px;
        width: 90%; 
        max-width: 1200px; 
    }

    .modal.show {
        display: flex; 
    }

    .modal-header {
        font-size: 1.25rem;
    }

    .modal-body {
        font-size: 1.1rem;
    }

    .product-title {
        text-decoration: none;
        color: inherit;
    }

    .product-title:hover {
        cursor: pointer;
    }
</style>

<script>
    function showProductDetails(title, description, price, imageUrl, discount, genre) {
    document.getElementById('productTitle').textContent = title;
    document.getElementById('productDescription').textContent = description;
    document.getElementById('productPrice').textContent = '$' + price;

    if (discount) {
        const discountedPrice = price * (1 - discount / 100);
        document.getElementById('productPrice').innerHTML = 
            `<span style="text-decoration: line-through;">$${price.toFixed(2)}</span> 
            <br><span style="color: green;">$${discountedPrice.toFixed(2)} (${discount}% off)</span>`;
    } else {
        document.getElementById('productPrice').textContent = `$${price.toFixed(2)}`;
    }

    // Set the genre
    document.getElementById('productGenre').textContent = 'Genre: ' + genre; // Display the genre

    document.getElementById('productImage').src = imageUrl;
    document.getElementById('productDetailsModal').classList.add('show');
}


    function hideProductDetailsModal() {
        document.getElementById('productDetailsModal').classList.remove('show');
    }

    function showDeleteModal(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteModal').classList.add('show');
    }

    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.remove('show');
    }

    window.onload = function() {
        var successMessage = document.getElementById('successMessage');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.transition = 'opacity 1s ease-out';
                successMessage.style.opacity = 0;
            }, 3000); 
        }
    };

    function showOutOfStockModal() {
        document.getElementById('outOfStockModal').classList.add('show');
    }

    function hideOutOfStockModal() {
        document.getElementById('outOfStockModal').classList.remove('show');
    }
</script>

@endsection

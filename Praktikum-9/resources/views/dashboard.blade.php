@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">Kategori</h4>
                        <h2>{{ \App\Models\Category::count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-tags fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">Gudang</h4>
                        <h2>{{ \App\Models\Warehouse::count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-warehouse fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">Produk</h4>
                        <h2>{{ \App\Models\Product::count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">Total Stok</h4>
                        <h2>{{ \App\Models\ProductWarehouse::sum('quantity') }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-cubes fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Produk dengan Stok Rendah</h5>
            </div>
            <div class="card-body">
                @php
                    $lowStockProducts = \App\Models\Product::with(['warehouses'])
                        ->get()
                        ->filter(function($product) {
                            $total = $product->warehouses->sum('pivot.quantity');
                            return $total > 0 && $total < 10;
                        })
                        ->take(5);
                @endphp
                
                @if($lowStockProducts->count() > 0)
                    <div class="list-group">
                        @foreach($lowStockProducts as $product)
                        @php
                            $totalStock = $product->warehouses->sum('pivot.quantity');
                        @endphp
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $product->name }}</h6>
                                <small class="text-muted">{{ $product->category->name ?? 'No Category' }}</small>
                            </div>
                            <span class="badge bg-warning rounded-pill">{{ $totalStock }}</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Tidak ada produk dengan stok rendah</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ route('categories.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus"></i> Tambah Kategori
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('warehouses.create') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-plus"></i> Tambah Gudang
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('products.create') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-plus"></i> Tambah Produk
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('stocks.transfer') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-exchange-alt"></i> Transfer Stok
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
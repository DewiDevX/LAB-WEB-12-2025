<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Product Management</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('categories.index') }}">Kategori</a>
                <a class="nav-link" href="{{ route('warehouses.index') }}">Gudang</a>
                <a class="nav-link" href="{{ route('products.index') }}">Produk</a>
                <a class="nav-link" href="{{ route('stocks.index') }}">Stok</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manajemen Stok</h1>
            <a href="{{ route('stocks.transfer') }}" class="btn btn-success">
                <i class="fas fa-exchange-alt"></i> Transfer Stok
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter Gudang -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-6">
                        <label for="warehouse_id" class="form-label">Filter berdasarkan Gudang</label>
                        <select class="form-select" id="warehouse_id" name="warehouse_id" onchange="this.form.submit()">
                            <option value="">Semua Gudang</option>
                            @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ $warehouseId == $warehouse->id ? 'selected' : '' }}>
                                {{ $warehouse->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                @if(!$warehouseId)
                                    <th>Gudang</th>
                                @endif
                                <th>Stok</th>
                                <th>Total Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                @php
                                    $totalStock = 0;
                                    $displayWarehouses = $warehouseId ? 
                                        [$product->warehouses->firstWhere('id', $warehouseId)] : 
                                        $product->warehouses;
                                    
                                    foreach($product->warehouses as $warehouse) {
                                        $totalStock += $warehouse->pivot->quantity;
                                    }
                                @endphp
                                
                                @if($warehouseId && $product->warehouses->where('id', $warehouseId)->isEmpty())
                                    @continue
                                @endif

                                @if($warehouseId)
                                    <!-- Tampilkan per gudang tertentu -->
                                    @foreach($product->warehouses->where('id', $warehouseId) as $warehouse)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $warehouse->pivot->quantity == 0 ? 'danger' : ($warehouse->pivot->quantity < 10 ? 'warning' : 'success') }} fs-6">
                                                {{ $warehouse->pivot->quantity }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info fs-6">{{ $totalStock }}</span>
                                        </td>
                                        <td>
                                            @if($warehouse->pivot->quantity == 0)
                                                <span class="text-danger"><i class="fas fa-times-circle"></i> Stok Habis</span>
                                            @elseif($warehouse->pivot->quantity < 10)
                                                <span class="text-warning"><i class="fas fa-exclamation-triangle"></i> Stok Rendah</span>
                                            @else
                                                <span class="text-success"><i class="fas fa-check-circle"></i> Stok Aman</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <!-- Tampilkan semua gudang -->
                                    @foreach($product->warehouses as $warehouse)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name ?? '-' }}</td>
                                        <td>{{ $warehouse->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $warehouse->pivot->quantity == 0 ? 'danger' : ($warehouse->pivot->quantity < 10 ? 'warning' : 'success') }}">
                                                {{ $warehouse->pivot->quantity }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $totalStock }}</span>
                                        </td>
                                        <td>
                                            @if($warehouse->pivot->quantity == 0)
                                                <span class="text-danger">Stok Habis</span>
                                            @elseif($warehouse->pivot->quantity < 10)
                                                <span class="text-warning">Stok Rendah</span>
                                            @else
                                                <span class="text-success">Stok Aman</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-cubes fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data stok</p>
                    <a href="{{ route('stocks.transfer') }}" class="btn btn-primary">Transfer Stok Pertama</a>
                </div>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="/" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
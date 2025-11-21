<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Stok</title>
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
            <h1>Transfer Stok</h1>
            <a href="{{ route('stocks.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Stok
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Form Transfer Stok</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('stocks.process-transfer') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Pilih Produk</label>
                                <select class="form-select" id="product_id" name="product_id" required>
                                    <option value="">Pilih Produk</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="warehouse_id" class="form-label">Pilih Gudang</label>
                                <select class="form-select" id="warehouse_id" name="warehouse_id" required>
                                    <option value="">Pilih Gudang</option>
                                    @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah Stok</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i> 
                                    Masukkan angka positif untuk menambah stok, angka negatif untuk mengurangi stok.
                                    Contoh: +10 (tambah 10) atau -5 (kurangi 5)
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-exchange-alt"></i> Proses Transfer
                            </button>
                            <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Info Stok Saat Ini</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $currentStocks = \App\Models\Product::with(['warehouses'])->get();
                        @endphp
                        
                        @if($currentStocks->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Gudang</th>
                                            <th>Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($currentStocks as $product)
                                            @foreach($product->warehouses as $warehouse)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $warehouse->name }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $warehouse->pivot->quantity == 0 ? 'danger' : ($warehouse->pivot->quantity < 10 ? 'warning' : 'success') }}">
                                                        {{ $warehouse->pivot->quantity }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">Menampilkan semua data stok yang tersedia</small>
                        @else
                            <p class="text-muted">Belum ada data stok</p>
                        @endif
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Aturan Transfer Stok</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i> Stok tidak boleh minus</li>
                            <li><i class="fas fa-check text-success me-2"></i> Tidak bisa mengurangi stok jika produk belum ada di gudang</li>
                            <li><i class="fas fa-check text-success me-2"></i> Quantity 0 tidak diperbolehkan</li>
                            <li><i class="fas fa-check text-success me-2"></i> Sistem akan otomatis menambah/mengurangi stok</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
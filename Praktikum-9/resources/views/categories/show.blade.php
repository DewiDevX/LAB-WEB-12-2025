<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
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
            <h1>Detail Kategori</h1>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nama Kategori</th>
                        <td>{{ $category->name }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $category->description ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $category->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diupdate</th>
                        <td>{{ $category->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Kategori
                    </a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Hapus kategori {{ $category->name }}?')">
                            <i class="fas fa-trash"></i> Hapus Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
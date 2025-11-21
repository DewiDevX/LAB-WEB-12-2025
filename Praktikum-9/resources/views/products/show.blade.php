<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Product Management</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Detail Produk</h1>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nama Produk</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $product->category->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Berat</th>
                        <td>{{ $product->detail->weight ?? '-' }} kg</td>
                    </tr>
                    <tr>
                        <th>Ukuran</th>
                        <td>{{ $product->detail->size ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $product->detail->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $product->created_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
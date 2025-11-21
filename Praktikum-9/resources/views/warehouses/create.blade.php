<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Product Management</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Tambah Gudang Baru</h1>

        <form method="POST" action="{{ route('warehouses.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Gudang</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <textarea class="form-control" id="location" name="location" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
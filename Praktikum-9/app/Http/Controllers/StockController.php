<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\ProductWarehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $warehouseId = $request->get('warehouse_id');
        
        $query = Product::with(['category', 'warehouses']);
        
        if ($warehouseId) {
            $query->whereHas('warehouses', function ($q) use ($warehouseId) {
                $q->where('warehouse_id', $warehouseId);
            });
        }
        
        $products = $query->get();
        $warehouses = Warehouse::all();
        
        return view('stocks.index', compact('products', 'warehouses', 'warehouseId'));
    }

    public function transfer()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        return view('stocks.transfer', compact('products', 'warehouses'));
    }

    public function processTransfer(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $productId = $request->product_id;
                $warehouseId = $request->warehouse_id;
                $quantity = $request->quantity;

                // Validasi quantity tidak boleh 0
                if ($quantity == 0) {
                    throw new \Exception("Quantity tidak boleh 0");
                }

                $stock = ProductWarehouse::where('product_id', $productId)
                                        ->where('warehouse_id', $warehouseId)
                                        ->first();

                if ($stock) {
                    $newQuantity = $stock->quantity + $quantity;
                    
                    if ($newQuantity < 0) {
                        throw new \Exception("Stok tidak boleh minus. Stok saat ini: " . $stock->quantity);
                    }
                    
                    $stock->update(['quantity' => $newQuantity]);
                } else {
                    if ($quantity < 0) {
                        throw new \Exception("Tidak bisa mengurangi stok karena produk belum ada di gudang ini");
                    }
                    
                    ProductWarehouse::create([
                        'product_id' => $productId,
                        'warehouse_id' => $warehouseId,
                        'quantity' => $quantity,
                    ]);
                }
            });

            return redirect()->route('stocks.transfer')
                             ->with('success', 'Stok berhasil diupdate!');
                             
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', $e->getMessage())
                             ->withInput();
        }
    }
}
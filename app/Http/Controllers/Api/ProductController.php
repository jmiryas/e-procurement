<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $data = Product::whereHas("vendor", function ($uqery) use ($user) {
            $uqery->where("user_id", $user->id);
        })
            ->orderBy("vendor_id")
            ->orderBy("name")
            ->get()
            ->map(function ($product) {
                return [
                    "id" => $product->id,
                    "vendorId" => $product->vendor_id,
                    "unit" => $product->unit,
                    "name" => $product->name,
                    "qty" => $product->qty,
                    "price" => $product->price,
                    "createdAt" => $product->created_at
                ];
            });

        return response()->json([
            "success" => true,
            "message" => "Produk berhasil didapatkan",
            "data" => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'vendorId' => 'required|exists:vendors,id',
            'unit' => 'required|in:pcs,box',
            'name' => 'required|string|max:50',
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::create([
            'vendor_id' => $validatedData['vendorId'],
            'unit' => $validatedData['unit'],
            'name' => $validatedData['name'],
            'qty' => $validatedData['qty'],
            'price' => $validatedData['price'],
        ]);

        return response()->json([
            "success" => true,
            "message" => "Produk berhasil ditambahkan",
            "data" => [
                "id" => $product->id,
                "vendorId" => $product->vendor_id,
                "unit" => $product->unit,
                "name" => $product->name,
                "qty" => $product->qty,
                "price" => $product->price,
                "createdAt" => $product->created_at,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($productId)
    {
        $product = Product::where("id", $productId)
            ->whereHas("vendor", function ($query) {
                $query->where("user_id", auth()->id());
            })
            ->first();

        if (!$product) {
            return response()->json([
                "success" => true,
                "message" => "Produk tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Produk berhasil didapatkan",
            "data" => [
                "id" => $product->id,
                "vendorId" => $product->vendor_id,
                "unit" => $product->unit,
                "name" => $product->name,
                "qty" => $product->qty,
                "price" => $product->price,
                "createdAt" => $product->created_at,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $productId)
    {
        $product = Product::where("id", $productId)
            ->whereHas("vendor", function ($query) {
                $query->where("user_id", auth()->id());
            })
            ->first();

        if (!$product) {
            return response()->json([
                "success" => false,
                "message" => "Produk tidak ditemukan",
            ], 404);
        }

        $validatedData = $request->validate([
            "unit" => "sometimes|in:pcs,box",
            "name" => "sometimes|string|max:50",
            "qty" => "sometimes|integer|min:1",
            "price" => "sometimes|numeric|min:0",
        ]);

        $validatedData["updated_at"] = now();
        $product->update($validatedData);

        return response()->json([
            "success" => true,
            "message" => "Produk berhasil diperbarui",
            "data" => [
                "id" => $product->id,
                "vendorId" => $product->vendor_id,
                "unit" => $product->unit,
                "name" => $product->name,
                "qty" => $product->qty,
                "price" => $product->price,
                "updatedAt" => $product->updated_at,
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($productId)
    {
        $product = Product::where("id", $productId)
            ->whereHas("vendor", function ($query) {
                $query->where("user_id", auth()->id());
            })
            ->first();

        if (!$product) {
            return response()->json([
                "success" => false,
                "message" => "Produk tidak ditemukan",
            ], 404);
        }

        $product->delete();

        return response()->json([
            "success" => true,
            "message" => "Produk berhasil dihapus",
        ]);
    }
}

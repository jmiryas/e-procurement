<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:vendors,name',
            'address' => 'nullable|string|max:255',
        ]);

        $user = $request->user();

        if (!$user) {
            return response()->json([
                "message" => "Unauthorized",
                "status" => false
            ], 401);
        }

        $vendor = Vendor::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'address' => $validatedData['address'] ?? null,
        ]);

        return response()->json([
            "message" => "Vendor berhasil dibuat",
            "status" => true,
            "data" => [
                "id" => $vendor->id,
                "name" => $vendor->name,
                "address" => $vendor->address,
            ]
        ]);
    }
}

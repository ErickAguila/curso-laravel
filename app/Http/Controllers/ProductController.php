<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ProductController extends Controller
{
    public function index(Request $request) {
        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 0);
        $offset = $page * $perPage;

        $products = Product::skip($offset)->take($perPage)->get();
        return response()->json($products);
    }

    public function store(Request $request) {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
            ], [
                'name.required' => 'El nombre es obligatorio',
                'price.required' => 'El precio es obligatorio',
                'price.numeric' => 'El precio debe ser un número',
                'price.min' => 'El precio no puede ser negativo',
            ]);
            $product = Product::create($validatedData);
            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ProductController extends Controller
{
    // Metodo que lista los productos con paginacion
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 0);
        $offset = $page * $perPage;

        $products = Product::skip($offset)->take($perPage)->get();
        return response()->json($products);
    }

    // Metodo que crea un nuevo producto
    public function store(Request $request)
    {
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

    // Metodo que actualiza un producto
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $validatedData = $request->validated();
            $product->update($validatedData);
            return response()->json(['message' => 'Producto actualizado correctamente', 'product' => $product]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product'], 500);
        }
    }

    // Metodo que elimina un producto
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json(['message' => 'Producto eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product'], 500);
        }
    }
}

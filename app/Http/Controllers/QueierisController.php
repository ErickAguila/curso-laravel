<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class QueierisController extends Controller
{
    public function get()
    {
        $products = Product::all(); //Obtenemos los productos de la base datos
        return response()->json($products); //Retornamos los productos en formato JSON
    }

    public function getById(int $int)
    {
        $products = Product::find($int); //Obtenemos los productos de la base datos
        if ($products) {
            return response()->json($products); //Retornamos los productos en formato JSON
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function getNames()
    {
        $products = Product::select('name') //Selecciona solo el campo 'name' de la tabla 'products'
            ->orderBy('name', 'asc')
            ->get();
        return response()->json($products);
    }

    public function searchName(string $name, float $price)
    {
        $products = Product::where('name', $name)
            ->where('price', '>=', $price)
            ->select('name', 'price')
            ->orderBy('price', 'desc')
            ->get();
        return response()->json($products);
    }

    //Metodo POST para busquedas avanzadas
    public function advancedSearch(Request $request)
    {
        $products = Product::where(function ($query) use ($request) {
            if ($request->input('name')) {
                $query->where('name', 'like', '%' . $request->input('name') . '%');
            }
        })
        ->where(function($query) use ($request) {
            if ($request->input('description')) {
                $query->where('description', 'like', '%' . $request->input('description') . '%');
            }
        })
        ->where(function($query) use ($request) {
            if ($request->input('price_min')) {
                $query->where('price', '>=', $request->input('price_min'));
            }
        })
        ->get();

        return response()->json($products);
    }

    public function join(){
        $products = Product::join('category', 'products.category_id', '=', 'category.id')
            ->select('product.*', 'category.name as category')
            ->get();

        return response()->json($products);
    }

    public function groupBy(){
        $products = Product::join('category', 'products.category_id', '=', 'category.id')
            ->select('product.id', 'category.name', DB::raw('COUNT(product.id) as total'))
            ->groupBy('product.id', 'category.name')
            ->get();

        return response()->json($products);
    }
}

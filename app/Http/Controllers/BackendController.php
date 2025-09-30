<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BackendController extends Controller
{
    private $names = [
        1 => ['name' => 'Ana', 'age' => 28],
        2 => ['name' => 'Luis', 'age' => 34],
        3 => ['name' => 'Maria', 'age' => 22],
    ];

    public function getAll() {
        return response()->json($this->names);
    }

    public function get(int $id = 0){
        if(isset($this->names[$id])){
            return response()->json($this->names[$id]);
        }
        return response()->json(['error' => 'Persona no existe'], Response::HTTP_NOT_FOUND);
    }

    public function create(Request $request){
        $person = [
            'id' => count($this->names) + 1,
            'name' => $request->input('name'),
            'age' => $request->input('age')
        ];
        $this->names[$person['id']] = $person;
        return response()->json([
            'message' => 'Persona creada exitosamente',
            'person' => $person
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id) {
        if(isset($this->names[$id])){
            $this->names[$id]['name'] = $request->input('name', $this->names[$id]['name']);
            $this->names[$id]['age'] = $request->input('age', $this->names[$id]['age']);
            return response()->json([
                'message' => 'Persona actualizada exitosamente',
                'person' => $this->names[$id]
            ]);
        }
        return response()->json(['error' => 'Persona no existe'], Response::HTTP_NOT_FOUND);
    }

    public function delete(int $id) {
        if(isset($this->names[$id])){
            unset($this->names[$id]); //Eliminar un elemento con unset
            return response()->json(['message' => 'Persona eliminada exitosamente']);
        }
        return response()->json(['error' => 'Persona no existe'], Response::HTTP_NOT_FOUND);
    }
}

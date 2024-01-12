<?php

//Funcionalidad de la API

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index() //Metodo GET
    {
        return response()->json(['data' => Tarea::all()]);
     }

    public function store(Request $request) //Metodo POST
    {
        $request->validate([
            'name' => 'required',
        ]);

        return Tarea::create($request->all());
    }

    public function destroy(Tarea $tarea) //Metodo DELETE
    {
        $tarea->delete();

        return response()->json(['message' => 'Tarea eliminada con éxito']);
    }

    public function update(Request $request, Tarea $tarea) //Metodo PUT
    {
        $request->validate([
            'name' => 'required',
            'status' => 'boolean',
        ]);

        $tarea->update($request->all());

        return $tarea->fresh();
    }
}


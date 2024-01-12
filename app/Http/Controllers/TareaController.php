<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Tarea::all()]);
     }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        return Tarea::create($request->all());
    }

    public function destroy(Tarea $tarea)
    {
        $tarea->delete();

        return response()->json(['message' => 'Tarea eliminada con éxito']);
    }

    public function update(Request $request, Tarea $tarea)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'boolean',
        ]);

        $tarea->update($request->all());

        return $tarea->fresh();
    }
}


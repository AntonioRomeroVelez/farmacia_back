<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return Producto::all();
    }

    public function store(Request $request)
    {
        $producto = Producto::create($request->only(
            'NombreProducto',
            'Presentacion',
            'PrincipioActivo',
            'PrecioFarmacia',
            'PVP',
            'Promocion',
            'Descuento',
            'Marca',
            'IVA'
        ));

        return response()->json($producto, 201);
    }

    public function show($id)
    {
        return Producto::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->update($request->only(
            'NombreProducto',
            'Presentacion',
            'PrincipioActivo',
            'PrecioFarmacia',
            'PVP',
            'Promocion',
            'Descuento',
            'Marca',
            'IVA'
        ));

        return response()->json($producto, 200);
    }

    public function destroy($id)
    {
        Producto::destroy($id);

        return response()->json(null, 204);
    }
}

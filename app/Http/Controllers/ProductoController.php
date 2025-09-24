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

    public function registrarLote(Request $request)
    {
        $productos = $request->all();
        $errores = [];

        foreach ($productos as $index => $producto) {
            try {
                // Validación básica por producto
                $validado = validator($producto, [
                    'NombreProducto' => 'required|string|max:255',
                    'Presentacion' => 'nullable|string|max:255',
                    'PrincipioActivo' => 'nullable|string|max:255',
                    'PrecioFarmacia' => 'nullable|numeric|min:0',
                    'PVP' => 'nullable|numeric|min:0',
                    'Promocion' => 'nullable|string|max:255',
                    'Descuento' => 'nullable|integer|min:0',
                    'Marca' => 'nullable|string|max:255',
                    'IVA' => 'nullable|integer|min:0',
                ]);

                if ($validado->fails()) {
                    $errores[] = [
                        'fila' => $index + 1,
                        'errores' => $validado->errors()->all()
                    ];
                    continue;
                }

                Producto::create($validado->validated());
            } catch (\Exception $e) {
                $errores[] = [
                    'fila' => $index + 1,
                    'error' => $e->getMessage()
                ];
            }
        }

        if (count($errores) > 0) {
            return response()->json([
                'mensaje' => 'Algunos productos no se pudieron registrar',
                'errores' => $errores
            ], 422);
        }

        return response()->json(['mensaje' => '✅ Todos los productos fueron registrados correctamente'], 201);
    }
}

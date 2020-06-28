<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoFormRequest;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $productos = DB::table('producto AS p')
            ->join('categoria AS c', 'p.idcategoria', '=', 'c.idcategoria')
            ->select('p.idproducto','p.nombre','p.codigo','p.stock','c.nombre AS categoria','p.descripcion','p.imagen','p.estado')
            ->where('p.nombre', 'LIKE', '%' . $query . '%')
            ->orwhere('p.codigo', 'LIKE', '%' . $query . '%')
            ->orderBy('p.idproducto', 'desc')
            ->paginate(5);
            return view('almacen.producto.index', ["productos" => $productos, "searchText" => $query]);
        }
    }

    public function create()
    {
        $categorias = DB::table('categoria')->where('condicion','=','1')->get();
        return view("almacen.producto.create",['categorias'=>$categorias]);
    }

    public function store(ProductoFormRequest $request)
    {
        $producto = new Producto();
        $producto->idcategoria = $request->get('idcategoria');
        $producto->codigo = $request->get('codigo');
        $producto->nombre = $request->get('nombre');
        $producto->stock = $request->get('stock');
        $producto->descripcion = $request->get('descripcion');
        $producto->estado = 'Activo';

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $file->move(public_path().'/imagenes/productos/',$file->getClientOriginalName());
            $producto->imagen = $file->getClientOriginalName();
        }

        $producto->save();
        return redirect('almacen/producto');
    }

    public function show($id)
    {
        return view("almacen.producto.show", ["producto" => Producto::findOrFail($id)]);
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = DB::table('categoria')->where('condicion','=','1')->get();
        return view("almacen.producto.edit", ["producto" => $producto, "categorias" => $categorias]);
    }

    public function update(ProductoFormRequest $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->idcategoria = $request->get('idcategoria');
        $producto->codigo = $request->get('codigo');
        $producto->nombre = $request->get('nombre');
        $producto->stock = $request->get('stock');
        $producto->descripcion = $request->get('descripcion');

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $file->move(public_path().'/imagenes/productos/',$file->getClientOriginalName());
            $producto->imagen = $file->getClientOriginalName();
        }

        $producto->update();
        return redirect('almacen/producto');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = 'Inactivo';
        $producto->update();
        return redirect('almacen/producto');
    }
}

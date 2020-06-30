<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngresoController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $ingresos = DB::table('ingreso AS i')
            ->join('persona AS p', 'i.idproveedor', '=', 'p.idpersona')
            ->join('detalle_ingreso AS di', 'i.idingreso', '=', 'di.idingreso')
            ->select('i.id_ingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado', DB::raw('SUM(di.cantidad * precio_compra) AS total'))
            ->where('i.num_comprobante', 'LIKE', '%' .$query .'%')
            ->orderBy('i.idingreso', 'desc')
            ->groupBy('i.id_ingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado')
            ->paginate(7);
            return view('compras.ingreso.index', ["ingresos" => $ingresos, "searchText" => $query]);
        }
    }

    public function create()
    {
        $personas = DB::table('persona')->where('tipo_persona', '=', 'Proveedor')->get();
        $productos = DB::table('producto AS prod')
            ->select(DB::raw('CONCAT(prod.codigo, " ", prod.nombre) AS producto'), 'prod.idproducto')
            ->where('prod.estado', '=', 'Activo')
            ->get();
            return view('compras.ingreso.create', ["personas" => $personas, "productos" => $productos]);
    }
}

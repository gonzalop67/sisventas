<?php

namespace App\Http\Controllers;

use App\DetalleIngreso;
use App\Http\Requests\IngresoFormRequest;
use App\Ingreso;
use Carbon\Carbon;
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

    public function store(IngresoFormRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $ingreso = new Ingreso();
            $ingreso->idproveedor = $request->get('idproveedor');
            $ingreso->tipo_comprobante = $request->get('tipo_comprobante');
            $ingreso->serie_comprobante = $request->get('serie_comprobante');
            $ingreso->num_comprobante = $request->get('num_comprobante');
            $mytime = Carbon::now('America/Guayaquil');
            $ingreso->fecha_hora = $mytime->toDateTimeString();
            $ingreso->impuesto = '12';
            $ingreso->estado = 'A';
            $ingreso->save();

            $idproducto = $request->get('idproducto');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');

            $cont = 0;

            while ($cont < count($idproducto)) {
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->idingreso;
                $detalle->idproducto = $idproducto[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio_compra = $precio_compra[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save();
                $cont++;
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }

        return redirect('compras/ingreso');
    }

    public function show($id)
    {
        $ingreso = DB::table('ingreso AS i')
            ->join('persona AS p', 'i.idproveedor', '=', 'p.idpersona')
            ->join('detalle_ingreso AS di', 'i.id_ingreso', '=', 'di.idingreso')
            ->select('i.id_ingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado', DB::raw('SUM(di.cantidad * precio_compra) AS total'))
            ->where('i.idingreso', '=', $id)
            ->first();

        $detalles = DB::table('detalle_ingreso AS d')
            ->join('producto AS p', 'd.idproducto', '=', 'p.idproducto')
            ->select('p.nombre AS producto', 'd.cantidad', 'd.precio_compra', 'd.precio_venta')
            ->where('d.idingreso', '=', $id)
            ->get();

        return view("compras.ingreso.show", ["ingreso" => $ingreso, "detalles" => $detalles]);
    }

    public function destroy($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->estado = 'C';
        $ingreso->update();

        return redirect('compras/ingreso');
    }
}

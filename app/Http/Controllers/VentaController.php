<?php

namespace App\Http\Controllers;

use App\DetalleVenta;
use App\Http\Requests\VentaFormRequest;
use App\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $ventas = DB::table('venta AS v')
            ->join('persona AS p', 'v.idcliente', '=', 'p.idpersona')
            ->join('detalle_venta AS dv', 'v.idventa', '=', 'dv.idventa')
            ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
            ->where('v.num_comprobante', 'LIKE', '%' .$query .'%')
            ->orderBy('v.idventa', 'desc')
            ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado')
            ->paginate(7);
            return view('ventas.venta.index', ["ventas" => $ventas, "searchText" => $query]);
        }
    }

    public function create()
    {
        $personas = DB::table('persona')->where('tipo_persona', '=', 'Cliente')->get();
        $productos = DB::table('producto AS prod')
            ->select(DB::raw('CONCAT(prod.codigo, " ", prod.nombre) AS producto'), 'prod.idproducto', 'prod.stock', DB::raw('AVG(di.precio_venta) AS precio_promedio'))
            ->join('detalle_ingreso AS di', 'prod.idproducto', '=', 'di.idproducto')
            ->where('prod.estado', '=', 'Activo')
            ->where('prod.stock', '>', '0')
            ->groupBy('producto', 'prod.idproducto', 'prod.stock')
            ->get();
            return view('ventas.venta.create', ["personas" => $personas, "productos" => $productos]);
    }

    public function store(VentaFormRequest $request)
    {
        try {
            DB::beginTransaction();

            $venta = new Venta();
            $venta->idcliente = $request->get('idcliente');
            $venta->tipo_comprobante = $request->get('tipo_comprobante');
            $venta->serie_comprobante = $request->get('serie_comprobante');
            $venta->num_comprobante = $request->get('num_comprobante');
            $venta->total_venta = $request->get('total_venta');

            $mytime = Carbon::now('America/Guayaquil');
            $venta->fecha_hora = $mytime->toDateTimeString();
            $venta->impuesto = '12';
            $venta->estado = 'A';
            $venta->save();

            $idproducto = $request->get('idproducto');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento');
            $precio_venta = $request->get('precio_venta');

            $cont = 0;

            while ($cont < count($idproducto)) {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->idventa;
                $detalle->idproducto = $idproducto[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->descuento = $descuento[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save();
                $cont++;
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }

        return redirect('ventas/venta');
    }

    public function show($id)
    {
        $venta = DB::table('venta AS v')
            ->join('persona AS p', 'v.idcliente', '=', 'p.idpersona')
            ->join('detalle_venta AS dv', 'v.idventa', '=', 'dv.idventa')
            ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
            ->where('v.idventa', '=', $id)
            ->first();

        $detalles = DB::table('detalle_venta AS d')
            ->join('producto AS p', 'd.idproducto', '=', 'p.idproducto')
            ->select('p.nombre AS producto', 'd.cantidad', 'd.descuento', 'd.precio_venta')
            ->where('d.idventa', '=', $id)
            ->get();

        return view("ventas.venta.show", ["venta" => $venta, "detalles" => $detalles]);
    }

    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->estado = 'C';
        $venta->update();

        return redirect('ventas/venta');
    }
}

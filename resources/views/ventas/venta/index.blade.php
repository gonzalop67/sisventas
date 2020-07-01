@extends('layouts.admin')
@section('contenido')
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3>Listado de Ventas <a href="venta/create"><button class="btn btn-success">Nuevo</button></a></h3>
        @include('ventas.venta.search')
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Comprobante</th>
                        <th>Impuesto</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->fecha_hora }}</td>
                            <td>{{ $venta->nombre }}</td>
                            <td>{{ $venta->tipo_comprobante.': '.$venta->serie_comprobante.'-'.$venta->num_comprobante }}</td>
                            <td>{{ $venta->impuesto }}</td>
                            <td>{{ $venta->total_venta }}</td>
                            <td>{{ $venta->estado }}</td>
                            <td>
                                <a href="{{route('mostrar_venta', ['id' => $venta->idventa])}}"><button class="btn btn-primary">Detalles</button></a>
                                <a href="" data-target="#modal-delete-{{$venta->idventa}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
                            </td>
                        </tr>
                        @include('ventas.venta.modal')
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$ventas->render()}}
    </div>
</div>
@endsection

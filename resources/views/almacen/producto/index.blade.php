@extends('layouts.admin')
@section('contenido')
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3>Listado de Productos <a href="producto/create"><button class="btn btn-success">Nuevo</button></a></h3>
        @include('almacen.producto.search')
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>
                                <img src="{{asset('imagenes/productos/'.$producto->imagen)}}" alt="{{$producto->nombre}}" width="100px" class="img-thumbnail">
                            </td>
                            <td>{{ $producto->idproducto }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->categoria }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ $producto->estado }}</td>
                            <td>
                                <a href="{{route('editar_producto', ['id' => $producto->idproducto])}}"><button class="btn btn-info">Editar</button></a>
                                <a href="" data-target="#modal-delete-{{$producto->idproducto}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
                            </td>
                        </tr>
                        @include('almacen.producto.modal')
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$productos->render()}}
    </div>
</div>
@endsection

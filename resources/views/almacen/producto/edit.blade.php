@extends('layouts.admin')
@section('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Editar Producto: {{$producto->nombre}}</h3>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <form action="{{route('actualizar_producto', ['id' => $producto->idproducto])}}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf @method('put')
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" required value="{{old('nombre', $producto->nombre ?? '')}}" class="form-control">
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="">Categoría</label>
                    <select name="idcategoria" class="form-control">
                        @foreach ($categorias as $categoria)
                            @if ($categoria->idcategoria == $producto->idcategoria)
                                <option value="{{$categoria->idcategoria}}" selected>{{$categoria->nombre}}</option>
                            @else
                                <option value="{{$categoria->idcategoria}}">{{$categoria->nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="codigo">Código</label>
                    <input type="text" name="codigo" required value="{{old('codigo', $producto->codigo ?? '')}}" class="form-control">
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="text" name="stock" required value="{{old('stock', $producto->stock ?? '')}}" class="form-control">
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" name="descripcion" value="{{old('descripcion', $producto->descripcion ?? '')}}" class="form-control" placeholder="Descripción del producto...">
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="imagen">Imagen</label>
                    <input type="file" name="imagen" class="form-control">
                    @if (($producto->imagen)!="")
                        <img src="{{asset('imagenes/productos/'.$producto->imagen)}}" width="200px">
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <button class="btn btn-danger" type="reset">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
@endsection

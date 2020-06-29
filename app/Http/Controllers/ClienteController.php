<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaFormRequest;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $personas = DB::table('persona')
            ->where('nombre', 'LIKE', '%' . $query . '%')
            ->where('tipo_persona', '=', 'Cliente')
            ->orwhere('num_documento', 'LIKE', '%' . $query . '%')
            ->where('tipo_persona', '=', 'Cliente')
            ->orderBy('idpersona', 'desc')
            ->paginate(5);
            return view('ventas.cliente.index', ["personas" => $personas, "searchText" => $query]);
        }
    }

    public function create()
    {
        return view("ventas.cliente.create");
    }

    public function store(PersonaFormRequest $request)
    {
        $persona = new Persona();
        $persona->tipo_persona = 'Cliente';
        $persona->nombre = $request->get('nombre');
        $persona->num_documento = $request->get('num_documento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->save();
        return redirect('ventas/cliente');
    }

    public function show($id)
    {
        return view("ventas.cliente.show", ["persona" => Persona::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("ventas.cliente.edit", ["persona" => Persona::findOrFail($id)]);
    }

    public function update(PersonaFormRequest $request, $id)
    {
        $persona = Persona::findOrFail($id);
        $persona->nombre = $request->get('nombre');
        $persona->num_documento = $request->get('num_documento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->update();
        return redirect('ventas/cliente');
    }

    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->tipo_persona = 'Inactivo';
        $persona->update();
        return redirect('ventas/cliente');
    }
}
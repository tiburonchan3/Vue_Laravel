<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductoResource;
use App\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductoController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function show()
    {
        //retorna todos los productos en la base datos
        return ProductoResource::collection(Producto::latest()->paginate(8));
    }
    //funcion para guardar en la base de datos
    public function store(Request $request)
    {
        //valida los campos que contiene el request
        $this->validate($request, [
            'image' => 'required',
            'nombre' => 'required',
            'id_tipo' => 'required',
            'stock' => 'required',
            'precio' => 'required'
        ]);
        //valida que contenga una imagen
        if ($request->get('image')) {
            //creamos una variable con la imagen que recibimos
            $image = $request->get('image');
            //le asigamos un nombre con el se guardara en la carpeta
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            //se guarda la imagen en la carpeta public y le cambia de tamaño
            Image::make($request->get('image'))->resize(510, 510)->save(public_path('images/productos/') . $name);
        } else {
            //si no se contiene una imagen se le asigna una por defecto
            $name = 'producto.jpg';
        }
        //se crea el producto y se guarda en la base de datos
        $producto = Producto::create([
            'nombre' => request('nombre'),
            'precio' => request('precio'),
            'stock' => request('stock'),
            'image' => $name,
            'id_tipo' => request('id_tipo')
        ]);
        //retornamos el producto que creamos
        return ProductoResource::make($producto);
    }
    //funcion que retona un producto por id
    public function edit($id)
    {
        //retornmaos el producto que encontramos con el id
        return ProductoResource::make(Producto::findOrFail($id));
    }
    //funcion para editar un producto
    public function update($id)
    {
        //buscamos el producto por el id y lo actualizamos
        $producto = Producto::findOrFail($id)->update([
            'id' => $id,
            'nombre' => request('nombre'),
            'precio' => request('precio'),
            'stock' => request('stock'),
            'id_tipo' => request('id_tipo'),
            'updated_at' => Carbon::now()
        ]);
        //retornamos el producto en formato json
        return json_encode($producto);
    }
    //funcion para eliminar un producto
    public function destroy($id)
    {
        //elimina el producto por el id
        Producto::destroy($id);
        //no retorna nada
        return;
    }
    //funcion para buscar productos
    public function search(Request $request)
    {
        //creamos una variable con el valor de lo que queremos buscar
        $search = $request->get('nombre');
        //buscamos el producto y  lo devolvemos en formato de coleccion
        $producto = ProductoResource::collection(Producto::where('nombre', 'LIKE', "%$search%")->get());
        //retornamos el producto
        return $producto;
    }
}

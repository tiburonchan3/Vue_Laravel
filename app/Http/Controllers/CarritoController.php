<?php

namespace App\Http\Controllers;

use App\Order;
use App\Producto;
use Illuminate\Http\Request;

use function GuzzleHttp\json_decode;

class CarritoController extends Controller
{
    public function index(){
        return view('cart.index');
    }
    public function store(Request $request){
        #se recorre cada item que viene en al arreglo de productos
        foreach($request->data['data'] as $data){
            #see crea una instancia del modelo de orden y de agrega la nueva orden
            $order= new Order([
                #se guardara el id del usuario autenticado
                'id_cliente'=>auth()->user()->id,
                #se guarda el id del producto
                'id_producto'=>$data['id'],
                #se guarda y calcula el total de la orden
                'total'=>$data['cantidad']*$data['precio'],
                #se guarda la cantidad del producto
                'cantidad'=>$data['cantidad']
            ]);
            #se busca el producto en la tabla segun el id del producto que esta en la orden
            $producto = Producto::find($data['id']);
            #se resta la cantidad de la orden a la cantidad de productos en inventario
            $producto->decrement('stock',$data['cantidad']);
            #se guarda en la base de datos la orden
            $order->saveOrFail();
        }
    return response()->json('exito');
    }
}

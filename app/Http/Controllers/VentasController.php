<?php

namespace App\Http\Controllers;

use App\Order;

use App\Http\Resources\VentasResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentasController extends Controller
{
    public function index(){
        return view('ventas.index');
    }
    public function show(){
        return VentasResource::collection(Order::latest()->paginate(5));
    }
    public function orderByUser()
    {
        $id_user = auth()->user()->id;
        $producto = VentasResource::collection(Order::where('id_cliente', $id_user)->get());
        return $producto;
    }
}

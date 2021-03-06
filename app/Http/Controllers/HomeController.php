<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = \App\Product::paginate();
        return view('home', compact('products'));
    }
    
    public function index2()
    {
        /*$listas_reproduccion = \App\Listas_reproduccion::pluck("nombre");
        return view('home2')->with('listas_reproduccion', $listas_reproduccion);*/
        $listas_reproduccion = \App\Listas_reproduccion::paginate();
        return view('home2', compact('listas_reproduccion'));
    }

    public function getVideos(Request $request, $id)
    {
        if($request->ajax()){            
            $videos = \App\Video::videos($id);
            return response()->json($videos);   
        }
    }

    public function destroyProduct(Request $request, $id)
    {
        if($request->ajax()){            
            $product = \App\Product::find($id);
            $product->delete();
            $products_total = \App\Product::all()->count();
            
            return response()->json([
                'total' => $products_total,
                'message' =>  $product->name . ' fue eliminado correctamente'
            ]);
           
        }
    }
}

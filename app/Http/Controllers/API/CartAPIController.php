<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $role = auth()->user()->user_role;
            abort_if(!in_array($role, ['user', 'student']), 403);
            return $next($request);
        });
    }

    public function index()
    {
        $t = [];
        $tot = 0;
        $n = 0;
        foreach (auth()->user()->carts()->get() as $el) {
            $o  = (object) [];
            $o->id = $el->id;
            $o->product = $el->product->name;
            $o->product_id = $el->product->id;
            $o->qty = $el->qty;
            $n += $o->qty;
            $o->price = v($el->product->price, 'CDF');
            $o->total = $el->qty * $el->product->price;
            $tot += $o->total;
            $o->total = v($o->total, 'CDF');

            $img = $el->product->images;
            $i = [];
            if ($img) {
                $i = (array) @json_decode($img);
                $img =   asset('storage/' . @$i[0]);
            } else {
                $img =   asset('/assets/images/faces/9.jpg');
            }
            $o->image = $img;
            $t[] = $o;
        }
        $tot = v($tot, 'CDF');
        return ['cart' => $t, 'total' => $tot, 'n' => $n];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $qty = request('qty');
        if (!$qty) {
            $qty = 1;
        }
        $item = request('item');
        $prod = Product::where('id', $item)->where('forsale', 1)->first();
        if (!$prod) {
            abort(403);
        }
        $p = Cart::where(['users_id' => auth()->user()->id, 'product_id' => $item])->first();

        if ($p) {
            if (!request()->has('qty')) {
                $qty =  1 + (int) $p->qty;
            }
            $p->update(['qty' => $qty]);
        } else {
            Cart::create(['users_id' => auth()->user()->id, 'product_id' => $item, 'qty' => 1]);
        }
        return ['success' => true, 'message' => "Article ajouté au panier"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        abort_if($cart->users_id != auth()->user()->id, 403);
        $cart->delete();
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $t = Product::orderBy('name')->with('category')->get();
        $data = [];

        foreach ($t as $el) {
            $o = (object)$el->toArray();

            $img = $el->images;
            $i = [];
            if ($img) {
                $i = (array) @json_decode($img);
                $img =   asset('storage/' . @$i[0]);
            } else {
                $img =   asset('/assets/images/faces/9.jpg');
            }

            $o->image = $img;
            $o->images = $i;

            $o->price = v($el->price, 'CDF');
            $o->pricev = $el->price;
            $data[] = $o;
        }
        return [
            'success' => true,
            'data' => $data
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =  [
            'category_id' => 'required|exists:category,id',
            'name' => 'required',
            'description' => 'sometimes',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'project_id' => 'sometimes',
            'image' => 'sometimes|array',
            'image.*' => 'mimes:jpeg,jpg,png|max:500',
            'forsale' => 'sometimes',
        ];

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }

        $data  = $validator->validated();

        if ($request->hasFile('image')) {
            $i = [];
            foreach (request('image') as $file) {
                $i[] = $file->store('image', 'public');
            }
            $data['images'] = json_encode($i);
        }

        $data['forsale'] = request()->has('forsale');
        $data['name'] = ucfirst($data['name']);
        Product::create($data);

        return ['success' => true, 'message' => 'Article créé.'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules =  [
            'category_id' => 'required|exists:category,id',
            'name' => 'required',
            'description' => 'sometimes',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'project_id' => 'sometimes',
            'image' => 'sometimes|array',
            'image.*' => 'mimes:jpeg,jpg,png|max:500',
            'forsale' => 'sometimes',
        ];

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }

        $data  = $validator->validated();

        if ($request->hasFile('image')) {
            $i = [];
            foreach (request('image') as $file) {
                $i[] = $file->store('image', 'public');
            }
            $data['images'] = json_encode($i);
            $img = (array) json_decode($product->images);
            foreach ($img as $i) {
                File::delete('storage/' . $i);
            }
        }

        $data['forsale'] = request()->has('forsale');
        $data['name'] = ucfirst($data['name']);
        $product->update($data);

        return ['success' => true, 'message' => 'Article mis à jour.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $img = (array) json_decode($product->images);
        foreach ($img as $i) {
            File::delete('storage/' . $i);
        }
        $product->delete();
        return ['success' => true, 'message' => 'Article supprimé'];
    }
}

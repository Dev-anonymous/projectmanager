<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $t = Category::orderBy('category')->withCount('products')->get();
        $data = [];
        foreach ($t as $el) {
            $o = (object)$el->toArray();
            $o->image = userimage($el);
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
            'category' => 'required|unique:category',
        ];

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }
        $data  = $validator->validated();
        if ($request->hasFile('image')) {
            $data['image'] = request()->file('image')->store('image', 'public');
        }
        Category::create($data);

        return ['success' => true, 'message' => 'Catégorie créé.'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $rules =  [
            'category' => 'required|unique:category,category,' . $category->id,
        ];

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }
        $data  = $validator->validated();
        if ($request->hasFile('image')) {
            File::delete('storage/' . $category->image);
            $data['image'] = request()->file('image')->store('image', 'public');
        }
        $category->update($data);

        return ['success' => true, 'message' => 'Catégorie mise à jour.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $n = $category->products()->count();
        if ($n > 0) {
            return ['success' => false, 'message' => 'Catégorie associée à ' . $n . ' article(s).'];
        }
        $category->delete();
        return ['success' => true, 'message' => 'Catégorie supprimée'];
    }
}

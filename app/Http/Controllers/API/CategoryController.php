<?php

namespace App\Http\Controllers\API;

use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Category;
use Validator;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return $this->sendResponse($category->toArray(), 'category retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if ($request->has('icon_cat')) {
            // Get image file
            $image = $request->file('icon_cat');
            $path = public_path() . '/CategoryIcons';
            $image->move($path, $image->getClientOriginalName());
            // Make a image name based on user name and current timestamp
        }
        $validator = Validator::make($input, [
            'name_cat' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $category = Category::create([
            'name_cat' => $request->get('name_cat'),
            'icon_cat' => $path.$image->getClientOriginalName()
        ]);
        return $this->sendResponse($category->toArray(), 'category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
       if (is_null($category))
        {
            return $this->sendError('category not found.');
        }
        return $this->sendResponse($category->toArray(), 'category retrieved successfully.');
    }

    public function showSubcategories($id)
    {
        $subcategories=Subcategory::where('idcat','=',$id)->get();
        return $this->sendResponse($subcategories, 'category retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if ($request->has('icon_cat')) {
            $image = $request->file('icon_cat');
            $path = public_path() . '/CategoryIcons/';
            $image->move($path,$image->getClientOriginalName());
            $category->icon_cat= $path.$image->getClientOriginalName();
        }

        $category->name_cat = is_null($request->input('name_cat') )? $category->name_cat: $request->input('name_cat');
        $category->save();
        return $this->sendResponse($category->toArray(), 'category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->sendResponse($category->toArray(), ' category deleted successfully.');
    }
}

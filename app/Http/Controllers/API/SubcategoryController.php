<?php

namespace App\Http\Controllers\API;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Subcategory;
use Validator;

class SubcategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategory = Subcategory::all();
        return $this->sendResponse($subcategory->toArray(), 'subcategory retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getCategory(Request $request,$id)
    {
        $categorie=Category::find($id);
        if (is_null($categorie))
        {
            return $this->sendError('category not found.');
        }
        return $this->sendResponse($categorie->toArray(), 'category retrieved successfully.');
    }



    public function store(Request $request,$id)
    {
        $input = $request->all();
        $name=$request->get('name_subcat');
        if ($request->has('icon_subcat')) {
            $image = $request->file('icon_subcat');
            $path = public_path() . '/SubcategoryIcons/';
            $image->move($path,$image->getClientOriginalName());
        }
        $validator = Validator::make($input, [
            'name_subcat' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $subcategory= new Subcategory;
        $subcategory->name_subcat = $name;
        $subcategory->icon_subcat= $path.$image->getClientOriginalName();
        $subcategory->idcat = $id;

        $subcategory->save();
        return $this->sendResponse($subcategory->toArray(), 'subcategory created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$id1)
    {
        $subcategory = Subcategory::find($id1);

        if (is_null($subcategory)) {
            return $this->sendError('subcategory not found.');
        }
        return $this->sendResponse($subcategory->toArray(), 'subcategory retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$id1)
    {

        $subcategory = Subcategory::find($id1);
        if ($request->has('icon_subcat')) {
            $image = $request->file('icon_subcat');
            $path = public_path() . '/SubcategoryIcons/';
            $image->move($path,$image->getClientOriginalName());
            $subcategory->icon_subcat= $path.$image->getClientOriginalName();
        }
        $subcategory->name_subcat = is_null($request->input('name_subcat') )? $subcategory->name_cat: $request->input('name_subcat');
        $subcategory->idcat=$id;
        $subcategory->save();

        return $this->sendResponse($subcategory->toArray(), 'subcategory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$id1)
    {
        $subc=Subcategory::find($id1);
        $subc->delete();
        return $this->sendResponse($subc->toArray(), ' subcategory deleted successfully.');
    }
}

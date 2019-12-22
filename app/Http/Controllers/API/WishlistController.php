<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Product;
use App\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wishlist=Wishlist::all();
        return $this->sendResponse($wishlist->toArray(), 'wishlist retrieved successfully.');

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id,$idproduct)
    {
        $wishlist=Wishlist::where('id_user','=',$id)->first();
        $product=Product::find($idproduct);
        if(is_null($wishlist)){
            $wishlist= Wishlist::create([
                'id_user'=> $id,
                'items'=>[ "0"=>$idproduct]
            ]);}
        else {
            $items = $wishlist->items;
            array_push($items,$idproduct);
            $wishlist->items=$items;
            $wishlist->save();
        }
        return $this->sendResponse($wishlist->toArray(), 'wishlist created or updated successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wishlist=Wishlist::Where('id_user',$id);
        if(is_null($wishlist)){
            return $this->sendResponse($wishlist, 'wishlist not found.');
        }
        else
        {
            return $this->sendResponse($wishlist->get()->toArray(), 'wishlist retrieved successfully.');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();
        return $this->sendResponse($wishlist->toArray(), 'wishlist deleted successfully.');

    }

    public function deleteProductByIdfromwishlist($id,$idproduct)
    {
        $wishlist=Wishlist::where('id_user','=',$id)->first();
        $items = $wishlist->items;
        //$items=array_diff($items,array($idproduct));
        $key = array_search($idproduct, $items);
        unset($items[$key]);
        $wishlist->items=$items;
        $wishlist->save();

        return $this->sendResponse($wishlist->toArray(), 'wishlist update successfully.');
    }
}

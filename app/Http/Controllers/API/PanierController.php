<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Panier;
use App\Product;
use Illuminate\Http\Request;

class PanierController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $panier= Panier::all();
            return $this->sendResponse($panier->toArray(), 'Panier retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id,$idproduct)
    {
        $Panier=Panier::where('id_user','=',$id)->first();
        $product=Product::find($idproduct);
        if(is_null($Panier)){
            $Panier= Panier::create([
                'id_user'=> $id,
                'Price'=>$product->price,
                'items'=>[ "0"=>$idproduct]
        ]);}
        else {
            $items = $Panier->items;
            array_push($items,$idproduct);
            $Panier->items=$items;
            $Panier->Price=$Panier->Price+floatval($product->price);
            $Panier->save();
        }
        return $this->sendResponse($Panier->toArray(), 'panier created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Panier=Panier::where('id_user','=',$id)->first();
        if(is_null($Panier)){
            return $this->sendResponse($Panier, 'panier not found.');
        }
        else {
            return $this->sendResponse($Panier->toArray(), 'panier created successfully.');
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Panier $panier)
    {
        $panier->delete();
        return $this->sendResponse($panier->toArray(), ' panier deleted successfully.');

    }

    public function getAllproductsOfPanierAndTotal($id)
    {
        $Panier=Panier::where('id_user','=',$id)->first();
        $products=[];
        if(is_null($Panier)){
            return $this->sendResponse($Panier, 'panier not found.');
        }
        else {
            foreach ($Panier->items as $productid) {
                $Product = Product::find($productid);
                array_push($products, $Product);
            }
            $response=['price'=>$Panier->Price];
            array_push($response,$products);
            return $this->sendResponse($response, "products retrieved success");
        }
    }

    public function deleteProductByIdfromPanier($id,$idproduct)
    {
        $Panier=Panier::where('id_user','=',$id)->first();
            $items = $Panier->items;
            //$items=array_diff($items,array($idproduct));
            $key = array_search($idproduct, $items);
            unset($items[$key]);
            $Panier->items=$items;
            $Product=Product::find($idproduct);
            $Panier->Price=$Panier->Price-floatval($Product->price);
            $Panier->save();

        return $this->sendResponse($Panier->toArray(), 'panier update successfully.');
    }
}

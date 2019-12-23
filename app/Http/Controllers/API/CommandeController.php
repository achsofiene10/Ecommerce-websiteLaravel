<?php

namespace App\Http\Controllers\API;

use App\Commande;
use App\Panier;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;


class CommandeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $commande= Commande::all();
        return $this->sendResponse($commande->toArray(), 'Commande retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $Panier=Panier::find($id);
        $products=$Panier->items;

        $commande= Commande::create([
            'id_user'=> $Panier->id_user,
            'price_com'=>$Panier->Price,
            'items'=>$products,
            'adresse'=>$request->input('adresse'),
            'phone'=>$request->input('phone'),
        ]);
        $user=User::find($Panier->id_user);
        foreach ($products as $idproduct)
        {
            $product=Product::find($idproduct);
            $product->Nbrvente=($product->Nbrvente)+1;
            $tab=$user->favs;
            if(!(in_array($product->idsouscat,$tab))){
            array_push($tab,$product->idsouscat);
            $user->favs=$tab;
            $user->save();}
            $product->save();
        }
        $Panier->delete();
        return $this->sendResponse($commande->toArray(), 'Commande created successfully.');

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commande=Commande::find($id);
        if(is_null($commande)){
            return $this->sendError('commande not found.');
        }
        else {
            return $this->sendResponse($commande->toArray(), 'commande created successfully.');
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
        //$commande=Commande::find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        $commande->delete();
        return $this->sendResponse($commande->toArray(), 'commande deleted successfully.');
    }

    public function getProductsOfOrder($id)
    {
        $commande=Commande::find($id);
        $products=[];
        if(is_null($commande)){
            return $this->sendError('order not found.');
        }
        else {
            foreach ($commande->items as $productid) {
                $Product = Product::find($productid);
                array_push($products, $Product);
            }
            return $this->sendResponse($products, "products retrieved success");
        }
    }

    public function getAlluserOrders($id)
    {
        $orders=Commande::where('id_user','=',$id)->get();
        if($orders->isEmpty())
        {
            return $this->sendError('there is no orders');
        }
        else
            {
            return $this->sendResponse($orders, "orders retrieved success");
        }

    }
}

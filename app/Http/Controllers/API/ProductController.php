<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        return $this->sendResponse($products->toArray(), 'products retrieved successfully.');
    }

    public function store(Request $request,$id)
    {
        if ($request->has('img_product')) {
            // Get image file
            $image = $request->file('img_product');
            $path = public_path() . '/Prodcutsimgs';
            $image->move($path, $image->getClientOriginalName());
            // Make a image name based on user name and current timestamp
        }
        $product = Product::create([
            'img_product' => $path.$image->getClientOriginalName(),
            'idsouscat'=> $id,
            'title'=>$request->get('title'),
            'details'=> $request->get('details'),
            'price'=> floatval($request->get('price')),
            'os_product'=> $request->get('os_product'),
            'Ram_product'=>$request->get('Ram_product'),
            'compagny'=>$request->get('compagny'),
            'status'=> $request->get('status')
        ]);
        return $this->sendResponse($product->toArray(), 'product created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product))
        {
            return $this->sendError('product not found.');
        }
        return $this->sendResponse($product->toArray(), 'one product retrieved successfully.');
    }


    public function update(Request $request, $id)
    {
        $product=Product::find($id);
        if ($request->has('img_product')) {
            $image = $request->file('img_product');
            $path = public_path() . '/Prodcutsimgs';
            $image->move($path,$image->getClientOriginalName());
            $product->img_product= $path.$image->getClientOriginalName();
        }

        $product->title =  $request->input('title');
        $product->details =  $request->input('details');
        $product->compagny =  $request->input('compagny');
        $product->os_product =  $request->input('os_product');
        $product->Ram_product =  $request->input('Ram_product');
        $product->price =  floatval($request->input('price'));
        $product->status =  $request->input('status');
        $product->save();
        return $this->sendResponse($product->toArray(), 'product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->sendResponse($product->toArray(), ' product deleted successfully.');
    }

    public function getHotdeals(Request $request,$id)
    {
        $Products=Product::all();
        $ArrayP=$Products->toArray();
        $ArrayMax=0;
        $Hotsdeals=[];
        $index=0;
        for($i=0;$i<$id;$i++){
        foreach ($ArrayP as $key=>$item)
        {
               if($item['remise']>$ArrayMax){
                   $ArrayMax=$item['remise'];
                   $index=$key;
               }
        }
            array_push($Hotsdeals,$ArrayP[$index]);
            unset($ArrayP[$index]);
            $ArrayMax=0;
        }
        return $this->sendResponse($Hotsdeals, 'Hotdeals retrieved successfully.');
    }

    public function getTopsellings(Request $request,$id)
    {
        $Products=Product::all();
        $ArrayP=$Products->toArray();
        $ArrayMax=0;
        $Top=[];
        $index=0;
        for($i=0;$i<$id;$i++){
            foreach ($ArrayP as $key=>$item)
            {
                if($item['Nbrvente']>$ArrayMax){
                    $ArrayMax=$item['Nbrvente'];
                    $index=$key;
                }
            }
            array_push($Top,$ArrayP[$index]);
            unset($ArrayP[$index]);
            $ArrayMax=0;
        }
        return $this->sendResponse($Top, 'Top sellings retrieved successfully.');
    }
}

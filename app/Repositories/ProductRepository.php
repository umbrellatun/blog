<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\Models\ProductStock;
/**
 * Class ProductRepository.
 */
class ProductRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
        return ProductStock::class;
    }

    public function plusProduct($product_id, $qty)
    {
         $product = ProductStock::find($product_id);
         $data = [
              "product_id" => $product_id
              ,"plus" => $qty
              ,"stock" => $product->stock + $qty
              ,'created_by' => \Auth::guard('admin')->id()
              ,'created_at' => date('Y-m-d H:i:s')
         ];
         $last_product_id = ProductStock::insertGetId($data):
         return $last_product_id;
    }
}

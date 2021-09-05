<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\Models\ProductStock;
use App\Models\Product;
use App\Models\Order;
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
         if (!isset($product->in_stock)){
              $in_stock = 0;
         } else {
              $in_stock = $product->in_stock;
         }
         $data = [
              "product_id" => $product_id
              ,"plus" => $qty
              ,"delete" => 0
              ,"stock" => $in_stock + $qty
              ,'created_by' => \Auth::guard('admin')->id()
              ,'created_at' => date('Y-m-d H:i:s')
         ];
         $last_product_id = ProductStock::insertGetId($data);

         $data = [
              "in_stock" => $in_stock + $qty
              ,'updated_by' => \Auth::guard('admin')->id()
              ,'updated_at' => date('Y-m-d H:i:s')
         ];
         Product::where('id', '=', $product_id)->update($data);
         return $last_product_id;
    }

    public function deleteProduct($product_id, $order_id)
    {
         $order = Order::find($order_id);
         $product = ProductStock::find($product_id);
         if (!isset($product->in_stock)){
              $in_stock = 0;
         } else {
              $in_stock = $product->in_stock;
         }
         $data = [
              "product_id" => $product_id
              ,"plus" => 0
              ,"delete" => $qty
              ,"stock" => $in_stock - 1
              ,"remark" => "สแกน QRCode หยิบใส่ไปยัง Order : " .$order->order_no
              ,"order_id" => $order_id
              ,'created_by' => \Auth::guard('admin')->id()
              ,'created_at' => date('Y-m-d H:i:s')
         ];
         $last_product_id = ProductStock::insertGetId($data);

         $data = [
              "in_stock" => $in_stock + $qty
              ,'updated_by' => \Auth::guard('admin')->id()
              ,'updated_at' => date('Y-m-d H:i:s')
         ];
         Product::where('id', '=', $product_id)->update($data);
         return $last_product_id;
    }
}

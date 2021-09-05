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

    public function plusProduct($product_id, $qty, $order_id = "")
    {
         $product = Product::find($product_id);
         if (strlen($order_id) > 0) {
              $order = Order::find($order_id);
              $remark = "สแกน QRCode หยิบใส่ไปยัง Order : " .$order->order_no;
         }
         $data = [
              "product_id" => $product_id
              ,"plus" => $qty
              ,"delete" => 0
              ,"stock" => strlen($product->in_stock) > 0 ? $product->in_stock + $qty : $qty
              ,"remark" => $remark
              ,"order_id" => $order_id
              ,'created_by' => \Auth::guard('admin')->id()
              ,'created_at' => date('Y-m-d H:i:s')
         ];
         $last_product_id = ProductStock::insertGetId($data);

         $data = [
              "in_stock" => strlen($product->in_stock) > 0 ? $product->in_stock + $qty : $qty
              ,'updated_by' => \Auth::guard('admin')->id()
              ,'updated_at' => date('Y-m-d H:i:s')
         ];
         Product::where('id', '=', $product_id)->update($data);
         return $last_product_id;
    }

    public function deleteProduct($product_id, $order_id)
    {
         $order = Order::find($order_id);
         $product = Product::find($product_id);
         if (!isset($product->in_stock)){
              $stock = 0;
         } else {
              $stock = $product->in_stock;
         }
         $data = [
              "product_id" => $product_id
              ,"plus" => 0
              ,"delete" => 1
              ,"stock" => $stock - 1
              ,"remark" => "สแกน QRCode หยิบใส่ไปยัง Order : " .$order->order_no
              ,"order_id" => $order_id
              ,'created_by' => \Auth::guard('admin')->id()
              ,'created_at' => date('Y-m-d H:i:s')
         ];
         $last_product_id = ProductStock::insertGetId($data);

         $data = [
              "in_stock" => $product->in_stock - 1
              ,'updated_by' => \Auth::guard('admin')->id()
              ,'updated_at' => date('Y-m-d H:i:s')
         ];
         Product::where('id', '=', $product_id)->update($data);
         return $last_product_id;
    }
}

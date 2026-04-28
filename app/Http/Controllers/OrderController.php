<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function listApi()
    {
        $orderCollection = Order::all();

        return response()->json(["data" => OrderResource::collection($orderCollection)]);
    }

    public function listPage()
    {
        $orderCollection = Order::all();

        return view('admin_orders', ['orders' => $orderCollection]);
    }

    public function create()
    {
    }

    public function store(Request $request, Product $product)
    {
        $paymentResponse = Http::post('http://ejdamjn-m2.web.ru/public/api/payments', [
            "price" => $product->price,
            "webhook_url" => url('api/payment-webhook')
        ]);

        if(!$paymentResponse->successful()) return response()->json(["message" => "Server error"],500);

        Order::create([
            "pay_url" => $paymentResponse["pay_url"],
            "order_id" => $paymentResponse["order_id"],
            "product_id" => $product->id,
            "user_id" => auth()->id()
        ]);

        return response()->json(["pay_url" => $paymentResponse["pay_url"]]);
    }

    public function show(Order $order)
    {
    }

    public function edit(Order $order)
    {
    }

    public function handlePaymentWebhook(Request $request)
    {
        $existingOrder = Order::where("order_id", $request->order_id)->firstOrFail();

        $existingOrder->update(["status" => $request->status]);

        return response()->noContent();
    }

    public function destroy(Order $order)
    {
    }
}
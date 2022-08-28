<?php

namespace App\Http\Controllers;

use App\Events\OrderAdd;
use App\Http\Requests\AddOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Room;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request, Room $room): JsonResponse
    {
        $orders = $room->orders()->with('customer')->get();

        return ResponseResult::success(
            OrderResource::collection($orders)
        )->returnValue;
    }

    public function add(AddOrderRequest $request, Room $room): JsonResponse
    {
        $order = $room->orders()->create([
            'customer_id' => $request->user()->id,
            'video_url' => $request->video_url,
        ]);

        $order_resource = new OrderResource($order);

        broadcast(new OrderAdd($order_resource));

        return ResponseResult::success($order_resource)->returnValue;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Room;
use App\Services\OrderService;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    public function index(Request $request, Room $room): JsonResponse
    {
        return ResponseResult::success(
            OrderResource::collection($this->orderService->getOrders($room)->returnValue)
        )->returnValue;
    }

    public function add(AddOrderRequest $request, Room $room): JsonResponse
    {
        return ResponseResult::success(
            $this->orderService->addOrder($request->user(), $request->video_url, $room)->returnValue
        )->returnValue;
    }

    public function delete(Request $request, Room $room, Order $order): JsonResponse
    {
        return ResponseResult::success(
            $this->orderService->deleteOrder($request->user(), $room, $order)->returnValue
        )->returnValue;
    }

    public function getFirst(Request $request, Room $room): JsonResponse
    {
        return ResponseResult::success(
            $this->orderService->getOrders($room)->returnValue->first()
        )->returnValue;
    }
}

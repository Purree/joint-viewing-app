<?php

namespace App\Http\Controllers;

use App\Helpers\Results\ResponseResult;
use App\Http\Requests\AddOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Room;
use App\Services\OrderService;
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
            OrderResource::collection($this->orderService->getOrders($room))
        );
    }

    public function add(AddOrderRequest $request, Room $room): JsonResponse
    {
        return ResponseResult::success(
            $this->orderService->addOrder($request->user(), $request->video_url, $room)
        );
    }

    public function delete(Request $request, Room $room, Order $order): JsonResponse
    {
        $this->orderService->deleteOrder($request->user(), $room, $order);

        return ResponseResult::success();
    }

    public function getFirst(Request $request, Room $room): JsonResponse
    {
        return ResponseResult::success(
            $this->orderService->getOrders($room)->first()
        );
    }
}

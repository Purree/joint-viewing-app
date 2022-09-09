<?php

namespace App\Services;

use App\Events\OrderAdd;
use App\Events\OrderDelete;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Room;
use App\Models\User;
use App\Services\Results\FunctionResult;

class OrderService
{
    public function __construct(protected ChatService $chatService)
    {
    }

    public function getOrders(Room $room): FunctionResult
    {
        $orders = $room->orders()->with('customer')->get();

        return FunctionResult::success(
            OrderResource::collection($orders)
        );
    }

    public function addOrder(User $user, string $video_url, Room $room): FunctionResult
    {
        $order = $room->orders()->create([
            'customer_id' => $user->id,
            'video_url' => $video_url,
        ]);

        $order_resource = new OrderResource($order);

        broadcast(new OrderAdd($order_resource));

        $this->chatService->sendMessage("User $user->name add new order $video_url", $room);

        return FunctionResult::success($order_resource);
    }

    public function deleteOrder(User $user, Room $room, Order $order): FunctionResult
    {
        $order->delete();

        broadcast(new OrderDelete(new OrderResource($order)));

        $this->chatService->sendMessage("User $user->name delete order $order->video_url", $room);

        return FunctionResult::success();
    }
}

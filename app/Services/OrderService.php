<?php

namespace App\Services;

use App\Events\ChangePlayingVideo;
use App\Events\OrderAdd;
use App\Events\OrderDelete;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Room;
use App\Models\User;
use App\Services\Results\FunctionResult;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderService
{
    public function __construct(protected ChatService $chatService)
    {
    }

    public function getOrders(Room $room): AnonymousResourceCollection
    {
        $orders = $room->orders()->with('customer')->get();

        return OrderResource::collection($orders);
    }

    public function addOrder(User $user, string $videoUrl, Room $room): OrderResource
    {
        $order = $room->orders()->create([
            'customer_id' => $user->id,
            'video_url' => $videoUrl,
        ]);

        $orderResource = new OrderResource($order);

        broadcast(new OrderAdd($orderResource));

        if ($room->orders->count() === 1) {
            broadcast(new ChangePlayingVideo($room, new OrderResource($order)));
        }

        $this->chatService->sendMessage("User $user->name add new order $videoUrl", $room);

        return $orderResource;
    }

    public function deleteOrder(User $user, Room $room, Order $order): void
    {
        $orders = $room->orders()->with('customer')->get();

        $order->delete();

        if ($orders->first()->id === $order->id) {
            if ($orders->count() > 1) {
                $nextOrder = $orders->get(1);
                broadcast(new ChangePlayingVideo($room, new OrderResource($nextOrder)));
            } else {
                broadcast(new ChangePlayingVideo($room, null));
            }
        }

        broadcast(new OrderDelete(new OrderResource($order)));

        $this->chatService->sendMessage("User $user->name delete order $order->video_url", $room);
    }
}

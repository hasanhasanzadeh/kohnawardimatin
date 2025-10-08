<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class MsgSendText
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $product_link;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user,$product_link)
    {
        $this->user = $user;
        $this->product_link = $product_link;
        $this->sendMsg($user,$product_link);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }

    public function sendMsg($user ,$eventProductLink)
    {
        $data = [
            'code' => 'ou4iv455glsagi6',
            'sender' => '+983000505',
            'recipient' => $user->mobile,
            'variable' => [
                'name' => $user->full_name??$user->mobile,
                'product-link' => $eventProductLink,
            ],
        ];
        $response = Http::timeout(120)->withHeaders([
            'apikey' => config('sms.API_SMS_KEY'),
        ])->post(config('sms.API_SMS_URL'), $data);
        if ($response->successful()) {
            return $responseData = $response->json();
        } else {
            return $errorResponse = $response->json();
        }
    }
}

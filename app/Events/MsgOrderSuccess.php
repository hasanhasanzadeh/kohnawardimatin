<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class MsgOrderSuccess implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $code;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user,$code)
    {
        $this->user=$user;
        $this->code=$code;
        $this->send($user,$code);
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

    public function send($user,$code):void
    {
        $data = [
            'code' => 'jaxhxxr7dlfri41',
            'sender' => '+983000505',
            'recipient' => $user->mobile,
            'variable' => [
                'name' => $user->full_name,
                'code' => $code,
            ],
        ];
        $response = Http::timeout(120)->withHeaders([
            'apikey' => config('sms.API_SMS_KEY'),
        ])->post(config('sms.API_SMS_URL'), $data);
        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $errorResponse = $response->json();
        }
    }
}

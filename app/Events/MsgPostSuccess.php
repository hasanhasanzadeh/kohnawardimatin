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

class MsgPostSuccess implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $code;
    public $website;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user,$code,$website)
    {
        $this->user=$user;
        $this->code=$code;
        $this->website=$website;
        $this->send($user,$code,$website);
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

    public function send($user,$code,$website):void
    {
        $data = [
            'code' => '65l95l80bdtyzuy',
            'sender' => '+983000505',
            'recipient' => $user->mobile,
            'variable' => [
                'name' => $user->full_name,
                'code' => $code,
                'website' => $website,
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

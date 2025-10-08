<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class MsgAdminSuccess implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $code;
    public $mobile;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user,$mobile,$code)
    {
        $this->user=$user;
        $this->code=$code;
        $this->mobile=$mobile;
        $this->send($user,$code,$mobile);
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

    public function send($user,$code,$mobile):void
    {
        $data = [
            'code' => 'p0kraqbr6z2sp0s',
            'sender' => '+983000505',
            'recipient' => $user->mobile,
            'variable' => [
                'name' => $user->full_name,
                'code' => $code,
                'mobile'=> $mobile,
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

<?php

namespace App\Events;

use App\Models\Activation_Code;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class MsgVerifyCode implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $activationCode;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user)
    {
        $this->user=$user;
        $this->activationCode=Activation_Code::createCode($user)->code;
        $this->sendCode($user,$this->activationCode);
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

    public function sendCode($user ,$eventCode)
    {
        $data = [
            'code' => 'lukqgxnfeq2shbu',
            'sender' => '+983000505',
            'recipient' => $user->mobile,
            'variable' => [
                'verification-code' => $eventCode,
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

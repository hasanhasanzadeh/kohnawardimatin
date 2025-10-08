<?php

namespace App\Events;

use App\Models\Activation_Code;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class MsgVerifyCodeMobile implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $mobile;
    public $activationCode;
    /**
     * Create a new event instance.
     */
    public function __construct($mobile)
    {
        $this->mobile=$mobile;
        $this->activationCode=Activation_Code::createCodes($this->mobile)->code;
        $this->sendCode($this->mobile,$this->activationCode);
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

    public function sendCode($mobile ,$eventCode)
    {
        $data = [
            'code' => 'lukqgxnfeq2shbu',
            'sender' => '+983000505',
            'recipient' => $mobile,
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

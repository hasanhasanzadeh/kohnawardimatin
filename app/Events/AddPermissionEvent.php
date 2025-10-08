<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddPermissionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $permission;
    /**
     * Create a new event instance.
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
        self::assignPermission();
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


    public function assignPermission(): void
    {
        $role=Role::where('name','superAdmin')->firstOrFail();
        $role->givePermissionTo($this->permission);
    }
}

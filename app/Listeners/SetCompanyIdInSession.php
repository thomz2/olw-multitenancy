<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetCompanyIdInSession
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if (
            $event->user->role_id == \App\Enums\RoleEnum::MANAGER ||
            $event->user->role_id == \App\Enums\RoleEnum::SELLER
        ) {
            session()->put('company_id', $event->user->seller->company_id);
        } else if ($event->user->role_id == \App\Enums\RoleEnum::CLIENT) {
            session()->put('company_id', $event->user->client->company_id); 
        }
        // Admin nao precisa pois vai ver tudo, nao precisa setar escopo para ele
    }
}

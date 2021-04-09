<?php

namespace App\Observers;

use App\Models\Festivity;
use Illuminate\Support\Str;

class FestivityObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param  \App\Models\Festivity  $festivity
     * @return void
     */
    public function creating(Festivity $festivity)
    {
        $festivity->uuid = Str::uuid();
    }
}

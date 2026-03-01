<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use App\Jobs\CreateAbacateAccountJob;

class CreateAbacateAccountListener
{
    public function __construct()
    {}

    public function handle(Verified $event): void {
        CreateAbacateAccountJob::dispatch($event->user);
    }
}

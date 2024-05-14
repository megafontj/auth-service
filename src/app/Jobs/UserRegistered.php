<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserRegistered implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private array $user;

    /**
     * @var User $user
     * Create a new job instance.
     */
    public function __construct($user)
    {
        $this->user = $user->toArray();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}

<?php

namespace App\Jobs;

use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateProfileStatus implements ShouldQueue
{
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $profileIds;
    protected $status;

    public function __construct(array $profileIds, $status)
    {
        $this->profileIds = $profileIds;
        $this->status = $status;
    }

    public function handle()
    {
         Log::info('UpdateProfileStatus Job Started', [
        'profile_ids' => $this->profileIds,
        'status' => $this->status
    ]);

    Profile::whereIn('id', $this->profileIds)->update([
        'status' => $this->status,
    ]);

    Log::info('UpdateProfileStatus Job Completed');
}
}
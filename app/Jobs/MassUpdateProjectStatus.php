<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Project;
use Illuminate\Support\Facades\Log;

class MassUpdateProjectStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $projectIds;
    protected $column;
    protected $value;

    public function __construct(array $projectIds, string $column, $value)
    {
        $this->projectIds = $projectIds;
        $this->column = $column;
        $this->value = $value;
    }

   public function handle()
{
    try {
        // Since your primary key column is 'id' (UUID)
        Project::whereIn('id', $this->projectIds)->update([
            $this->column => $this->value
        ]);
    } catch (\Exception $e) {
        Log::error('MassUpdateProjectStatus failed: '.$e->getMessage(), [
            'ids' => $this->projectIds,
            'column' => $this->column,
            'value' => $this->value
        ]);
        throw $e;
    }
}

}

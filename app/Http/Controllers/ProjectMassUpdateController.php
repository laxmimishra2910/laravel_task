<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Project;

class MassUpdateProjectStatus
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
        Project::whereIn('uuid', $this->projectIds)->update([
            $this->column => $this->value
        ]);
    }
}

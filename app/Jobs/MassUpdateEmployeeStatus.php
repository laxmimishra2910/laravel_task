<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;

class MassUpdateEmployeeStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employeeIds;
    protected $column;
    protected $value;

    public function __construct(array $employeeIds, string $column, $value)
    {
        $this->employeeIds = $employeeIds;
        $this->column = $column;
        $this->value = $value;
    }

    public function handle()
    {
        try {
            Employee::whereIn('id', $this->employeeIds)
                ->update([$this->column => $this->value]);
        } catch (\Exception $e) {
            Log::error('MassUpdateEmployeeStatus failed: '.$e->getMessage(), [
                'ids' => $this->employeeIds,
                'column' => $this->column,
                'value' => $this->value
            ]);
            throw $e;
        }
    }
}

<?php

namespace App\Traits;

use App\Relationships\BelongsToManyWithConstraints;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Model; // Added this import

trait HasAllRelations
{
    protected function getModelClass(string $key)
    {
        return config("relations.models.$key") ?? abort(500, "Model configuration not found for key: {$key}");
    }

    protected function getRelationshipConfig(string $key)
    {
        return config("relations.relationships.$key") ?? abort(500, "Relationship configuration not found for key: {$key}");
    }

    public function profile()
    {
        $config = $this->getRelationshipConfig('user_profile');
        
        if ($config['type'] === 'hasOneThroughPivot') {
            return $this->hasOneThroughPivot(
                $this->getModelClass($config['model']),
                $config['pivot_table'],
                $config['foreign_pivot_key'],
                $config['related_pivot_key']
            );
        }
        
        return $this->hasOne(
            $this->getModelClass($config['model']),
            $config['foreign_key'] ?? 'user_id'
        );
    }

    public function user()
    {
        $config = $this->getRelationshipConfig('profile_user');
        
        if ($config['type'] === 'hasOneThroughPivot') {
            return $this->hasOneThroughPivot(
                $this->getModelClass($config['model']),
                $config['pivot_table'],
                $config['foreign_pivot_key'],
                $config['related_pivot_key']
            );
        }
        
        return $this->belongsTo(
            $this->getModelClass($config['model']),
            $config['foreign_key'] ?? 'user_id'
        );
    }

    public function department()
    {
        $config = $this->getRelationshipConfig('employee_department');
        
        if ($config['type'] === 'belongsToManyWithConstraints') {
            $relation = new BelongsToManyWithConstraints(
                app($this->getModelClass($config['model']))->newQuery(),
                $this,
                $config['pivot_table'],
                $config['foreign_pivot_key'],
                $config['related_pivot_key'],
                $config
            );
            
            return $relation->withPivot('id')->withTimestamps();
        }
        
        return $this->belongsToMany(
            $this->getModelClass($config['model']),
            $config['pivot_table'],
            $config['foreign_pivot_key'],
            $config['related_pivot_key']
        )->withPivot('id')->withTimestamps();
    }

    public function employees()
    {
        $config = $this->getRelationshipConfig('department_employees');
        
        return $this->belongsToMany(
            $this->getModelClass($config['model']),
            $config['pivot_table'],
            $config['foreign_pivot_key'],
            $config['related_pivot_key']
        )->withPivot('id')->withTimestamps();
    }

    public function feedbacks()
    {
        $config = $this->getRelationshipConfig('employee_feedbacks');
        return $this->hasMany(
            $this->getModelClass($config['model']),
            $config['foreign_key'] ?? 'employee_id'
        );
    }

    public function employee()
    {
        $config = $this->getRelationshipConfig('feedback_employee');
        return $this->belongsTo(
            $this->getModelClass($config['model']),
            $config['foreign_key'] ?? 'employee_id'
        );
    }

   public function projects()
{
    $config = $this->getRelationshipConfig('employee_projects');
    
    // Use pivot_table if exists, otherwise fall back to table
    $table = $config['pivot_table'] ?? $config['table'] ?? null;
    
    if (!$table) {
        throw new \InvalidArgumentException(
            "Missing pivot table configuration for employee_projects relationship"
        );
    }

    return $this->belongsToMany(
        $this->getModelClass($config['model']),
        $table,
        $config['foreign_pivot_key'] ?? $config['foreign_key'] ?? 'employee_id',
        $config['related_pivot_key'] ?? $config['related_key'] ?? 'project_id'
    )->withPivot(array_merge(['id'], $config['pivot_fields'] ?? []))
     ->withTimestamps();
}

    /**
     * Custom hasOneThroughPivot implementation
     */
    protected function hasOneThroughPivot($related, $pivotTable, $foreignPivotKey, $relatedPivotKey)
    {
        $instance = new $related;
        $pivot = new class extends Model {
            protected $table;
            public function __construct(array $attributes = []) {
                parent::__construct($attributes);
            }
        };
        $pivot->setTable($pivotTable);

        return new HasOneThrough(
            $instance->newQuery(),
            $this,
            $pivot,
            $foreignPivotKey,  // Foreign key on pivot table
            $instance->getKeyName(), // Local key on related table
            $this->getKeyName(), // Local key on parent table
            $relatedPivotKey    // Foreign key on related table
        );
    }
}
<?php

namespace App\Relationships;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BelongsToManyWithConstraints extends BelongsToMany
{
    protected $customConstraints;

    public function __construct($query, $parent, $table, $foreignPivotKey, $relatedPivotKey, $config)
    {
        $this->customConstraints = $config['constraints'] ?? [];
        
        // Fix: Use proper parent constructor with all required parameters
        parent::__construct(
            $query, 
            $parent, 
            $table, 
            $foreignPivotKey, 
            $relatedPivotKey, 
            $parent->getKeyName(),  // parentKey (should be 'id')
            $query->getModel()->getKeyName() // relatedKey (should be 'id')
        );
    }

    public function addConstraints()
    {
        parent::addConstraints();
        
        if ($this->customConstraints['employee_unique'] ?? false) {
            $this->query->limit(1);
        }
    }

    public function getResults()
    {
        return $this->customConstraints['employee_unique'] ?? false 
            ? $this->query->first() 
            : parent::getResults();
    }
}
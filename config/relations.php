<?php

return [
    'models' => [
        'user' => \App\Models\User::class,
        'profile' => \App\Models\Profile::class,
        'employee' => \App\Models\Employee::class,
        'department' => \App\Models\Department::class,
        'feedback' => \App\Models\Feedback::class,
        'project' => \App\Models\Project::class,
    ],

    'relationships' => [
        // One-to-One
        'user_profile' => [
            'type' => 'hasOneThroughPivot',
            'model' => 'profile',
            'pivot_table' => 'user_profile',
            'foreign_pivot_key' => 'user_id',
            'related_pivot_key' => 'profile_id',
        ],
        'profile_user' => [
            'type' => 'hasOneThroughPivot',
            'model' => 'user',
            'pivot_table' => 'user_profile',
            'foreign_pivot_key' => 'profile_id',
            'related_pivot_key' => 'user_id',
        ],
        
        // One-to-Many
        'employee_feedbacks' => [
    'type' => 'belongsToMany',
    'model' => 'feedback',
    'pivot_table' => 'employee_feedback',
    'foreign_pivot_key' => 'employee_id',
    'related_pivot_key' => 'feedback_id',
    'pivot_fields' => [] // add extra pivot columns if needed
],

'feedback_employees' => [
    'type' => 'belongsToMany',
    'model' => 'employee',
    'pivot_table' => 'employee_feedback',
    'foreign_pivot_key' => 'feedback_id',
    'related_pivot_key' => 'employee_id',
    'pivot_fields' => []
],


        // One-to-Many through pivot
      'employee_department' => [
    'type' => 'belongsToManyWithConstraints',
    'model' => 'department',
    'pivot_table' => 'department_employee',
    'foreign_pivot_key' => 'employee_id',  // Correct: matches pivot table column
    'related_pivot_key' => 'department_id', // Correct: matches pivot table column
    'constraints' => [
        'employee_unique' => true
    ]
],
'department_employees' => [
    'type' => 'belongsToMany',
    'model' => 'employee',
    'pivot_table' => 'department_employee',
    'foreign_pivot_key' => 'department_id', // Correct: matches pivot table column
    'related_pivot_key' => 'employee_id' // Correct: matches pivot table column
],

        // Many-to-Many
      'employee_projects' => [
    'type' => 'belongsToMany',
    'model' => 'project',
    'pivot_table' => 'employee_project',  // Changed from 'table' to 'pivot_table'
    'foreign_pivot_key' => 'employee_id',
    'related_pivot_key' => 'project_id',
    'pivot_fields' => ['assigned_at', 'assigned_by']
],
'project_employees' => [
    'type' => 'belongsToMany',
    'model' => 'employee',
    'pivot_table' => 'employee_project',  // Changed from 'table' to 'pivot_table'
    'foreign_pivot_key' => 'project_id',
    'related_pivot_key' => 'employee_id',
    'pivot_fields' => ['assigned_at', 'assigned_by']
]
    ]
];
<?php

return [

    'employee_form' => [
        [
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text',
            'required' => true,
            'placeholder' => 'Enter employee name'
        ],
        [
            'name' => 'email',
            'label' => 'Email',
            'type' => 'email',
            'required' => true,
            'placeholder' => 'Enter employee email'
        ],
        [
            'name' => 'phone',
            'label' => 'Phone',
            'type' => 'text',
            'required' => true,
            'placeholder' => 'Enter phone number'
        ],
        [
            'name' => 'position',
            'label' => 'Position',
            'type' => 'text',
            'required' => true,
            'placeholder' => 'Enter position'
        ],
        [
            'name' => 'salary',
            'label' => 'Salary',
            'type' => 'number',
            'step' => '0.01',
            'required' => true,
            'placeholder' => 'Enter salary amount'
        ],
        [
            'name' => 'department_id',
            'label' => 'Department',
            'type' => 'select',
            'options' => [], // 🔄 Fill dynamically in controller from DB
            'required' => true
        ],
        [
            'name' => 'photo',
            'label' => 'Photo',
            'type' => 'file',
            'required' => false
        ]
    ],


    // Existing employee_form...

    'project_form' => [
        [
            'name' => 'project_name',
            'label' => 'Project Name',
            'type' => 'text',
            'required' => true,
            'placeholder' => 'Enter project name',
        ],
        [
            'name' => 'description',
            'label' => 'Description',
            'type' => 'textarea',
            'required' => false,
            'placeholder' => 'Enter project description',
        ],
        [
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select',
            'options' => [
                'Pending' => 'Pending',
                'In Process'=>'In Process',
                'Completed' => 'Completed',
                
            ],
            'required' => true,
        ],
        [
            'name' => 'start_date',
            'label' => 'Start Date',
            'type' => 'date',
            'required' => true,
        ],
        [
            'name' => 'end_date',
            'label' => 'End Date',
            'type' => 'date',
            'required' => false,
        ],
    ],

    'feedback_form' => [
        [
            'name' => 'employee_id',
            'label' => 'Employee',
            'type' => 'select',
            'options' => [], // 🔄 Fill dynamically in controller from DB
            'required' => true
        ],
        [

            'name' => 'client_name',
            'label' => 'Client Name',
            'type' => 'text',
            'required' => true,
            'placeholder' => 'Enter client name',
        ],
        [
            'name' => 'email',
            'label' => 'Email',
            'type' => 'email',
            'required' => false,
            'placeholder' => 'Enter email address',
        ],
        [
            'name' => 'message',
            'label' => 'Message',
            'type' => 'textarea',
            'required' => true,
            'placeholder' => 'Enter feedback message',
        ],
        [
            'name' => 'rating',
            'label' => 'Rating',
            'type' => 'select',
            'options' => [
                'Excellent' => 'Excellent',
                'Good' => 'Good',
                'Average' => 'Average',
                'Poor' => 'Poor',
            ],
            'required' => true,
        ],
    ],

];



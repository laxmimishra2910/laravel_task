<?php

namespace App\Interfaces;

interface FeedbackRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function delete($id);
    public function report();
}

<?php

namespace App\Interfaces;

interface EmployeeRepositoryInterface
{
    public function all();
    //  public function paginate($perPage);  
    public function trashed();
    public function getDataTable();
    public function getTrashedDataTable();
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function restore($id);
    public function forceDelete($id);
}

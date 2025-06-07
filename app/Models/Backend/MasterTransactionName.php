<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class MasterTransactionName extends Model
{
    protected $table = 'master_transaction_names';

    protected $fillable = [
        'name',
        'parentid',
        'main_master_parentid',
        'status',
        'created_by',
        'updated_by'
    ];
    public function parent()
    {
        return $this->belongsTo(MasterTransactionName::class, 'parentid');
    }
    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by', 'EmployeeID');
    }
    public function updater()
    {
        return $this->belongsTo(Employee::class, 'updated_by', 'EmployeeID');
    }



}

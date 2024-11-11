<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRequest extends Model
{
    use HasFactory;
    protected $table="hrm_asset_employee_request";
    protected $primaryKey = 'AssetEmpReqId'; 

    protected $fillable = [
        'HODApprovalStatus', 
        'HODRemark',
        'HODSubDate',
        'ITApprovalStatus',
        'ITRemark',
        'ITSubDate',
        'AccPayStatus',
        'AccRemark',
        'AccSubDate',
        'ApprovalStatus',
        'ApprovalDate'
    ];
}

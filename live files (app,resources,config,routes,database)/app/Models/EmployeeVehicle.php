<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeVehicle extends Model
{
    use HasFactory;
    protected $table="hrm_employee_vehicle";

    protected $fillable = [
        'EmployeeID', 'EmpCode', 'brand', 'model_name', 'model_no', 'dealer_name',
        'dealer_contact', 'purchase_date', 'price', 'registration_no', 'registration_date',
        'bill_no', 'invoice', 'fuel_type', 'ownership', 'vehicle_image', 'rc_file', 'insurance',
        'current_odo_meter', 'odo_meter', 'four_brand', 'four_model_name', 'four_model_no',
        'four_dealer_name', 'four_dealer_contact', 'four_purchase_date', 'four_price',
        'four_registration_no', 'four_registration_date', 'four_bill_no', 'four_invoice',
        'four_fuel_type', 'four_ownership', 'four_vehicle_image', 'four_rc_file', 'four_insurance',
        'four_current_odo_meter', 'four_odo_meter', 'remark', 'CreatedBy', 'CreatedDate', 'YearId'
    ];


}

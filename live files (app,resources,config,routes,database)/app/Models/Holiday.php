<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    protected $table="hrm_holiday";
    protected $fillable = ['HolidayName', 'HolidayDate', 'Day', 'State_1', 'State_2', 'State_3', 'State_4', 'status', 'Year'];

}

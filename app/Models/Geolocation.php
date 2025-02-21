<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Geolocation extends Model
{
    protected $connection = 'geolocation_db'; // Use the second database connection
    protected $table = 'data_geolocation';   // Table name
}

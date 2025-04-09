<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['full_name', 'email', 'phone', 'truck_type', 'document_path', 'status'];
}

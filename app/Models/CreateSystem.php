<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreateSystem extends Model
{
    protected $fillable = [
        'date',
        'department',
        'subject',
        'purpose',
        'manager_engineer',
        'project_manager',
        'manager_in_charge',
        'engineer_in_charge',
        'urgent',
        'delivery_time',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MmEmployee extends Model
{
    use HasFactory;

    // Specify the table name if it does not follow Laravel's conventions
    protected $table = 'mmEmployee';

    // If you have any primary key or other properties to define
    protected $primaryKey = 'badgeId'; // Assuming badgeId is the primary key
    public $incrementing = false; // Set to false if your primary key is not an auto-incrementing integer

    // Define any fillable fields for mass assignment
    protected $fillable = [
        'badgeId',
        'EmployeeNumber',
        'EmployeeName',
        'JobPosition',
        'Foreman',
        'DepartmentName',
    ];
}

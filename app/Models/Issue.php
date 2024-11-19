<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Issue extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'issues';

    // Define fillable fields
    protected $fillable = ['date', 'description', 'priority', 'attachment', 'status', 'created_by'];

    /**
     * Define a relationship to the User model
     * Assuming the relationship is that an issue has many participants.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function participants()
    {
        return $this->belongsToMany(User::class);
    }
}

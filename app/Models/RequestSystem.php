<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestSystem extends Model
{
    protected $fillable = [
        'date',
        'department',
        'subject',
        'purpose',
        'manager_engineer',
        'project_manager',
    ];

    public function updateRequestSystem($id, $data)
    {
        $requestSystem = self::find($id);
        if ($requestSystem) {
            $requestSystem->update($data);
            return true;
        }
        return false;
    }

    public function deleteRequestSystem($id)
    {
        $requestSystem = self::find($id);
        if ($requestSystem) {
            $requestSystem->delete();
            return true;
        }
        return false;
    }
}
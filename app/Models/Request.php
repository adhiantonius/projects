<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Request extends Model
{
    // Specify the table name if it's not the plural of the model name
    protected $table = 'requests'; // Update this if your table name differs

    // Specify the fillable properties
    protected $fillable = [
        'date',
        'department',
        'subject',
        'purpose',
        'manager_engineer',
        'priority',
        'attachments', 

    ];

    /**
     * Store the file attachments.
     *
     * @param  array  $attachments
     * @return void
     */
    public function storeAttachments($attachments)
    {
        if ($attachments) {
            foreach ($attachments as $attachment) {
                $filePath = $attachment->store('uploads', 'public');
                $this->attachments()->create(['file_path' => $filePath]);
            }
        }
    }

    /**
     * Get the attachments for the request.
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
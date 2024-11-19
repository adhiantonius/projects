<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
class Request extends Model
{
    // Specify the table name if it's not the plural of the model name
    protected $table = 'requests'; // Change this if your table name differs

    // Specify the fillable properties
    protected $fillable = [
        'date',
        'department',
        'subject',
        'purpose',
        'manager_engineer',
        'priority',
        'attachments', 
        'created_by'
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
            $attachmentNames = [];
            foreach ($attachments as $attachment) {
                $fileName = time() . '_' . $attachment->getClientOriginalName();
                $filePath = $attachment->storeAs('uploads', $fileName, 'public');
                $attachmentNames[] = $filePath; // Collect file paths

                // Save each attachment in the database if there is an Attachment model
                $this->attachments()->create(['file_path' => $filePath]);
            }

            // Store all the paths in the attachments field as a comma-separated string
            $this->attachments = implode(',', $attachmentNames);
            $this->save();
        }
    }

    /**
     * Relationship with the `Attachment` model.
     * Each request can have multiple attachments.
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function participants()
    {
        return $this->belongsToMany(User::class, 'request_user', 'request_id', 'user_id');   
                    
    }

}

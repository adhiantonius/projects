<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestParticipantsTable extends Migration
{
    public function up()
    {
        Schema::create('request_participants', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('request_id')->constrained('requests')->onDelete('cascade'); // Foreign key referencing requests table
            $table->integer('participant_id'); // Assuming this is the badgeId from mmEmployee table
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_participants');
    }
}

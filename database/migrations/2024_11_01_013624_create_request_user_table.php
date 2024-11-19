<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('user_id');
            
            // Foreign key constraints
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action'); // Avoid cascading path conflict
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_user');
    }
}

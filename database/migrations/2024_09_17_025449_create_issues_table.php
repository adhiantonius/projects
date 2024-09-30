<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{

    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->date('date');  
            $table->text('description');
            $table->enum('priority', ['Low', 'Medium', 'High']);
            $table->string('attachment');
            $table->timestamps();
        });
        
    }

public function down()
{
    Schema::dropIfExists('issues');
}
}
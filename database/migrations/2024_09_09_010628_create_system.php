<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystem extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('create_system', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('department', 50);
            $table->string('subject', 255);
            $table->text('purpose');
            $table->string('manager_engineer', 255);
            $table->string('project_manager', 255);
            $table->boolean('manager_in_charge')->default(false);
            $table->boolean('engineer_in_charge')->default(false);
            $table->boolean('urgent')->default(false);
            $table->date('delivery_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('create_system');
    }
}
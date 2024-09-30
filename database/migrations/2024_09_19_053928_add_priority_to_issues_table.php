<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPriorityToIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add a new column 'priority' to the 'issues' table
        DB::statement("ALTER TABLE issues ADD priority NVARCHAR(255) DEFAULT 'low'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the 'priority' column
        DB::statement("ALTER TABLE issues DROP COLUMN priority");
    }
}

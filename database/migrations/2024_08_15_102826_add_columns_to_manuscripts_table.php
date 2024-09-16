<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('manuscripts', function (Blueprint $table) {
            $table->string('project_leader_staff')->nullable();
            $table->string('campus_college')->nullable();
            $table->string('date_started')->nullable();
            $table->string('date_completed')->nullable();
            $table->decimal('fund_amount', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manuscripts', function (Blueprint $table) {
            $table->dropColumn(['project_leader_staff', 'campus_college', 'date_started', 'date_completed', 'fund_amount']);
        });
    }
};

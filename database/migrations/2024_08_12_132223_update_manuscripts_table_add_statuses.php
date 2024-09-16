<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the status column to be an ENUM with the allowed values
        Schema::table('manuscripts', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'declined'])
                ->default('pending')
                ->change();
        });

        // Optionally, update existing records if needed
        DB::table('manuscripts')
            ->whereNotIn('status', ['pending', 'approved', 'declined'])
            ->update(['status' => 'pending']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the status column to its original state (string)
        Schema::table('manuscripts', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }
};

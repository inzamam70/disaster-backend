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
        Schema::table('landingcards', function (Blueprint $table) {
            //
            $table->dropColumn('affected_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landingcards', function (Blueprint $table) {
            //
            $table->string('affected_type')->nullable();
        });
    }
};

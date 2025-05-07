<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('volunteer_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('volunteer_logs', 'landingcard_ids')) {
                $table->string('landingcard_ids')->nullable(); 
            }
        });
    }

    public function down(): void
    {
        Schema::table('volunteer_logs', function (Blueprint $table) {
            $table->dropColumn('landingcard_ids');
        });
    }
};


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
        Schema::table('farmers', function (Blueprint $table) {
            $table->string('name')->nullable()->after('user_id');
            $table->string('profile_image')->nullable()->after('email');
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending')->after('profile_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmers', function (Blueprint $table) {
            $table->dropColumn(['name', 'profile_image', 'status']);
        });
    }
};

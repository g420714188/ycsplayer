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
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

        Schema::table('rooms', function (Blueprint $table) use ($driver) {
            if ($driver === 'sqlite') {
                $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
            } else {
                $table->foreignId('member_id')->after('id')->constrained('users')->cascadeOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('member_id');
        });
    }
};

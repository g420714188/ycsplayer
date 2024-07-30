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

        Schema::table('users', function (Blueprint $table) use ($driver) {
            if ($driver === 'sqlite') {
                $table->string('alias')->default('');
            } else {
                $table->string('alias')->after('email')->default('');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('alias');
        });
    }
};

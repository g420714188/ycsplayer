<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * is_locked 是否锁定1是 0否 默认0
     * status:1 有效,0 已作废；
     */
    public function up(): void
    {
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

        Schema::table('users', function (Blueprint $table) use ($driver) {
            if ($driver === 'sqlite') {
                $table->integer('is_locked')->nullable(false)->default(0);
                $table->integer('status')->nullable(false)->default(1);
            } else {
                $table->integer('is_locked')->nullable(false)->after("vip_end_time")->default(0);
                $table->integer('status')->nullable(false)->after("is_locked")->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('limit_type');
            $table->dropColumn('limit_number');
        });
    }
};

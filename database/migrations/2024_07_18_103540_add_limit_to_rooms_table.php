<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * is_locked 是否允许锁定，多人房间时可以锁定房间，vip可用
     * limit_type:1 双人房间,2 多人房间，受vip限制，非vip最多1个，vip最多5个 svip不受限制；
     * limit_number: 房间人数，受vip限制，非vip最多3人，vip最多10人 svip不受限制；
     */
    public function up(): void
    {
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

        Schema::table('rooms', function (Blueprint $table) use ($driver) {
            if ($driver === 'sqlite') {
                $table->integer('limit_type')->default(2);
                $table->integer('limit_number')->default(0);
            } else {
                $table->integer('limit_type')->after("invite_code")->default(2);
                $table->integer('limit_number')->after("limit_type")->default(0);
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

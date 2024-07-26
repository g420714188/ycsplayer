<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * member_id 用户ID
     * trade_no 订单号
     * type 订单类型1、包月会员、2、季度会员、3、年度会员、4、超级阅读会员
     * money 金额 单位元
     * merchant_id 商户ID
     * out_trade_no 交易支付返回订单号
     * trade_way 交易类型(alipay:支付宝,wxpay:微信支付)
     * trade_status 交易状态 0交易中 1交易完成 2交易失败
     * notify_time 通知时间
     * out_trade_status 外部返回的交易状态
     */
    public function up(): void
    {
        Schema::create('purch_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('users');
            $table->string('trade_no')->unique()->nullable(false);
            $table->integer('type')->nullable(false);
            $table->string('name');
            $table->string('money')->nullable(false);
            $table->text("order_info");
            $table->string('merchant_id')->nullable();
            $table->string('out_trade_no')->nullable();
            $table->string('trade_way')->nullable(false);
            $table->integer('trade_status')->default(0)->nullable(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('update_at')->nullable();
            $table->timestamp('notify_at')->nullable(true);
            $table->string("out_trade_status")->nullable(true);
        });
    }

//    /**
//     * Reverse the migrations.
//     */
//    public function down(): void
//    {
//        Schema::dropIfExists('failed_jobs');
//    }
};

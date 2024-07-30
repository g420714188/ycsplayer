<?php

namespace App\Http\Controllers;

use App\Facades\Flash;
use App\Models\PurchOrders;
use App\Models\User;
use EpayCore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class UserVipController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        Log::info("进入会员购买页面",[$user->id,$user->name]);

        Redis::set("name","1111");
        $vip_1= config('ycsplayer.vip_1');
        $vip_2= config('ycsplayer.vip_2');
        $vip_3= config('ycsplayer.vip_3');

        return Inertia::render('Vip/Index', [
            'user' => [
                'id' => $user->hash_id,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender,
                'vip_type' => $user->vip_type,
                'vip_end_time' => $user->vip_end_time,
                'avatar' => $user->avatar_url,
            ],
            'vip_1'=>$vip_1,
            'vip_2'=>$vip_2,
            'vip_3'=>$vip_3,
        ])->title('Vip');
    }

    /**
     * 加入会员请求
     * @param Request $request
     * type 1、普通包月会员 vip、2、普通季度会员 vip、3、普通年度会员 vip、4、超级月度会员(svip)
     */
    public function purch(Request $request)
    {
        Log::info(1111);
        $type = $request->input('type');
        $user = Auth::user();
        $user_id = $user->id;
        $trade_no = 't'.$user_id.date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        $name = '普通用户会员';

        $money= 0.00;
        if( $type == 1){
            $name = '普通會員(會員有效期30天)';
            $money= config('ycsplayer.vip_1');
        }else if( $type == 2){
            $name = '普通會員(會員有效期90天)';
            $money= config('ycsplayer.vip_2');
        }else if( $type == 3){
            $name = '尊享會員(會員有效期30天)';
            $money= config('ycsplayer.vip_3');
        } else {
            Flash::error('[注册会员校验]会员类型错误!');
            return ;
        }
        $money = number_format($money, 2);
        if(  $money == 0.00 ){
            Flash::error('[注册会员校验]金额错误!');
            return ;
        }

        /**************************请求参数**************************/
        require_once __DIR__."/../../Plugins/epay/lib/epay.config.php";
        require_once __DIR__."/../../Plugins/epay/lib/EpayCore.class.php";
        $notify_url = "https://player.ezfp.cn/pay/notify";
        ////页面跳转同步通知页面路径
        $return_url = "https://player.ezfp.cn/pay/return";
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "pid" => $epay_config['pid'],
            "type" => 'alipay',
            "notify_url" => $notify_url,
            "return_url" => $return_url,
            "out_trade_no" => $trade_no,
            "name" => $name,
            "money"	=> $money
        );

        $purchOrder = PurchOrders::create(
            [
                "member_id"=>$user_id,
                'trade_no' => $trade_no,
                'type' => $type,
                'name' => $name,
                'money' => $money,
                'order_info' => json_encode($parameter),
                'merchant_id' => $epay_config['pid'],
                'trade_way' => 'alipay',
                'trade_status' => 0,
                'created_at' => now()
            ]
        );

        $epay = new EpayCore($epay_config);
        $html_text = $epay->pagePay($parameter);
        echo $html_text;

    }

    /**
     * 支付请求回调
     */
    public function callback_return(Request $request){
        /**************************请求参数**************************/
        Log::info("交易回调返回数据",[$request->all()]);

        require_once __DIR__."/../../Plugins/epay/lib/epay.config.php";
        require_once __DIR__."/../../Plugins/epay/lib/EpayCore.class.php";
        //计算得出通知验证结果
        $epay = new EpayCore($epay_config);
        $verify_result = $epay->verifyReturn();

        // 校验签名
        if(!$verify_result) {
//            Flash::error('会员类型错误，请检查!');
//            return "会员类型错误，请检查!";
            return Inertia::render('Error',[
                'url'=>'',
                'title'=>'返回首页',
                'code' =>'500',
                'message' => '[交易校验错误]签名校验错误!'
            ]);
        }

        //签名正确获取各项参数
        $return = $request->only('pid', 'trade_no', 'out_trade_no','money','trade_status');

        //重点关注位置(订单编号转化)
        $trade_no = $return['out_trade_no'];//本地系统订单编号
        $out_trade_no = $return['trade_no'];//交易平台订单编号

        $money = $return['money'];
        $trade_status = $return['trade_status'];

        $entity = PurchOrders::where('trade_no',$trade_no)->first();
        if(is_null($entity)){
            return Inertia::render('Error',[
                'url'=>'',
                'title'=>'返回首页',
                'code' =>'500',
                'message' => '[交易校验错误]订单不存在!'
            ]);
        }

        if($entity->trade_status == 1){
            return Inertia::render('Error',[
                'url'=>'',
                'title'=>'返回首页',
                'code' =>'500',
                'message' => '[交易校验错误]订单已处理完成，请勿重复处理!'
            ]);
        }

        //判断交易状态
        if(strcmp($trade_status,'TRADE_SUCCESS') !== 0){
            // 交易错误更新订单状态
            PurchOrders::where('trade_no',$trade_no)->update(
                ['notify_at'=> now(),'out_trade_status'=>$trade_status,'trade_status'=>2]
            );

            return Inertia::render('Error',[
                'url'=>'',
                'title'=>'返回首页',
                'code' =>'500',
                'message' => '[交易结果]订单支付未成功!'
            ]);
        }

        //交易成功 进行会员授权
        $member_id = $entity->member_id;
        $type = $entity->type;

        $user = User::where('id',$member_id)->first();
        if(is_null($user)){
            return Inertia::render('Error',[
                'url'=>'',
                'title'=>'返回首页',
                'code' =>'500',
                'message' => '[交易校验错误]用户不存在!'
            ]);
        }
        $vip_end_time = $user->vip_end_time;
        if(is_null($vip_end_time)){
            $vip_end_time = now();
        }

        $vip_type = 'no';
        if( $type == 1){
            $name = '普通會員(會員有效期30天)';
            $vip_type = 'vip';
            $vip_end_time = date('Y-m-d H:i:s',strtotime("$vip_end_time +30 day"));
        }else if( $type == 2){
            $name = '普通會員(會員有效期90天)';
            $vip_type = 'vip';
            $vip_end_time = date('Y-m-d H:i:s',strtotime("$vip_end_time +90 day"));
        }else if( $type == 3){
            $name = '尊享會員(會員有效期30天)';
            $vip_type = 'svip';
            $vip_end_time = date('Y-m-d H:i:s',strtotime("$vip_end_time +30 day"));
        } else {
            return Inertia::render('Error',[
                'url'=>'',
                'title'=>'返回首页',
                'code' =>'500',
                'message' => '[交易校验错误]会员类型错误!'
            ]);
        }
        DB::transaction(function () use($request,$member_id,$vip_type,$vip_end_time,$trade_no,$out_trade_no,$trade_status): void{
            User::where('id',$member_id)->update(
                ['vip_type'=> $vip_type,'vip_end_time'=>$vip_end_time]
            );
            PurchOrders::where('trade_no',$trade_no)->update(
                ['notify_at'=> now(),'out_trade_status'=>$trade_status,'out_trade_no'=>$out_trade_no,'trade_status'=>1]
            );
        });

        Flash::success('处理完成');
        return redirect()->route('user.index');
    }
    /**
     * 支付请求回调
     */
    public function callback_notify(Request $request){
        /**************************请求参数**************************/
        Log::info("交易回调返回数据",[$request->all()]);

        require_once __DIR__."/../../Plugins/epay/lib/epay.config.php";
        require_once __DIR__."/../../Plugins/epay/lib/EpayCore.class.php";
        //计算得出通知验证结果
        $epay = new EpayCore($epay_config);
        $verify_result = $epay->verifyReturn();

        // 校验签名
        if(!$verify_result) {
//            Flash::error('会员类型错误，请检查!');
//            return "会员类型错误，请检查!";
            return '[交易校验错误]签名校验错误!';
        }

        //签名正确获取各项参数
        $return = $request->only('pid', 'trade_no', 'out_trade_no','money','trade_status');

        //重点关注位置(订单编号转化)
        $trade_no = $return['out_trade_no'];//本地系统订单编号
        $out_trade_no = $return['trade_no'];//交易平台订单编号

        $money = $return['money'];
        $trade_status = $return['trade_status'];

        $entity = PurchOrders::where('trade_no',$trade_no)->first();
        if(is_null($entity)){
            return '[交易校验错误]订单不存在!';
        }
        if($entity->trade_status == 1){
            return '[交易校验错误]订单已处理完成，请勿重复处理!';
        }

        //判断交易状态
        if(strcmp($trade_status,'TRADE_SUCCESS') !== 0){
            // 交易错误更新订单状态
            PurchOrders::where('trade_no',$trade_no)->update(
                ['notify_at'=> now(),'out_trade_status'=>$trade_status,'trade_status'=>2]
            );
            return '[交易结果]订单支付未成功!';
        }

        //交易成功 进行会员授权
        $member_id = $entity->member_id;
        $type = $entity->type;

        $user = User::where('id',$member_id)->first();
        if(is_null($user)){
            return '[交易校验错误]用户不存在!';
        }
        $vip_end_time = $user->vip_end_time;
        if(is_null($vip_end_time)){
            $vip_end_time = now();
        }

        $vip_type = 'no';
        if( $type == 1){
            $name = '普通會員(會員有效期30天)';
            $vip_type = 'vip';
            $vip_end_time = date('Y-m-d H:i:s',strtotime("$vip_end_time +30 day"));
        }else if( $type == 2){
            $name = '普通會員(會員有效期90天)';
            $vip_type = 'vip';
            $vip_end_time = date('Y-m-d H:i:s',strtotime("$vip_end_time +90 day"));
        }else if( $type == 3){
            $name = '尊享會員(會員有效期30天)';
            $vip_type = 'svip';
            $vip_end_time = date('Y-m-d H:i:s',strtotime("$vip_end_time +30 day"));
        } else {
            return '[交易校验错误]会员类型错误!';
        }
        DB::transaction(function () use($request,$member_id,$vip_type,$vip_end_time,$trade_no,$out_trade_no,$trade_status): void{
            User::where('id',$member_id)->update(
                ['vip_type'=> $vip_type,'vip_end_time'=>$vip_end_time]
            );
            PurchOrders::where('trade_no',$trade_no)->update(
                ['notify_at'=> now(),'out_trade_status'=>$trade_status,'out_trade_no'=>$out_trade_no,'trade_status'=>1]
            );
        });

        return 'SUCCESS';
    }
}

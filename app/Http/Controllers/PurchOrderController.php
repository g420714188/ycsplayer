<?php

namespace App\Http\Controllers;

use App\Models\PurchOrders;
use App\Presenters\PurchOrderPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PurchOrderController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        Log::info("进入个人订单界面",[$user->id,$user->name]);

        $orders = $user->orders()->orderBy('created_at', 'DESC')->paginate(20);

        return Inertia::render('Order/Index', [
            'record' => $orders->withQueryString()
        ])->title('個人訂單列表');
    }

}

<?php

namespace App\Http\Controllers;

use App\Facades\Flash;
use App\PasswordlessLogin\DestroyUserUrl;
use App\PasswordlessLogin\Notifications\SendPasswordlessDestroyUserLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class UserController extends Controller
{
    public function __construct()
    {
        if (! config('ycsplayer.password_less')) {
            $this->middleware('password.confirm')->only('confirmDestroy');
        }
    }

    /**
     * 用户中心
     * @return \Inertia\Response
     */
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        Log::info($user);

        Log::info("进入用户中心页面",[$user->id,$user->name]);

        return Inertia::render('User/Index', [
            'user' => [
                'id' => $user->hash_id,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender,
                'vip_type' => $user->vip_type,
                'vip_end_time' => $user->vip_end_time,
                'avatar' => $user->avatar_url,
            ],
            'passwordLess' => config('ycsplayer.password_less'),
            'can' => [
                'uploadAvatar' => config('ycsplayer.upload_avatar'),
            ],
        ])->title('用户中心');
    }

    public function show()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        return Inertia::render('User/Settings', [
            'user' => [
                'id' => $user->hash_id,
                'name' => $user->name,
                'email' => $user->email,
                'gender' => $user->gender,
                'vip_type' => $user->vip_type,
                'vip_end_time' => $user->vip_end_time,
                'avatar' => $user->avatar_url,
            ],
            'passwordLess' => config('ycsplayer.password_less'),
            'can' => [
                'uploadAvatar' => config('ycsplayer.upload_avatar'),
            ],
        ])->title('帳號設定');
    }

    public function uploadAvatar(Request $request)
    {
        abort_unless(config('ycsplayer.upload_avatar'), 404);

        $request->validate([
            'avatar' => [
                'nullable',
                File::types(['jpg', 'jpeg', 'png'])
                    ->max(5120), // 5M
            ],
        ]);

        /** @var \App\Models\User */
        $user = Auth::user();

        if ($avatar = $request->file('avatar')) {
            $user->avatar = $avatar->store('avatars');

            /** @phpstan-ignore-next-line */
            Image::load(Storage::path($user->avatar))
                ->fit(Manipulations::FIT_CROP, 250, 250)
                ->save();
        }

        $user->save();

        Flash::success('用戶頭像上傳成功');
    }

    public function removeAvatar()
    {
        abort_unless(config('ycsplayer.upload_avatar'), 404);

        /** @var \App\Models\User */
        $user = Auth::user();

        if ($user->avatar) {
            if (Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }

            $user->update(['avatar' => null]);
        }

        Flash::success('用戶頭像刪除成功，恢復成用戶預設頭像');
    }

    public function confirmDestroy()
    {
        return Inertia::render('User/ConfirmDestroyUser');
    }

    public function destroy(Request $request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        Log::info("用户注销账号",[$user->id,$user->name]);

        // 無密碼模式下，要寄送刪除帳號連結的信件
        if (config('ycsplayer.password_less')) {
            $url = DestroyUserUrl::forUser($user)->generate();

            $user->notify(new SendPasswordlessDestroyUserLink($url));

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('passwordless-destroy-user.send')
                ->with('email', $user->email);
        }

        Auth::logout();

        $user->update(['status' => 0,updated_at=>now()]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Flash::success('帳號刪除成功');

        return redirect()->route('rooms.home');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Events\MsgVerifyCode;
use App\Models\Activation_Code;
use App\Events\MsgVerifyCodeMobile;
use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function resend(Request $request): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('panel.index');
        }
        $auth = $request->session()->get('auth');
        if (isset($auth['mobile'])) {
            $mobile = $this->mobileCheck($auth['mobile']);
            toast(__('front.sendCodeMobile'), 'success');
        } elseif (isset($auth['email'])) {
            $email = $this->emailCheck($auth['email']);
            toast(__('front.sendCodeEmail'), 'success');
        }
        request()->session()->reflash();
        return redirect()->route('verify.show');
    }

    public function showLoginForm(): Factory|Application|View|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (auth()->check()) {
            return redirect()->route('profiles.show');
        }
        $title = __('dashboard.login');
        $setting = Setting::with(['logo', 'favicon'])->first();
        SEOMeta::setTitle($setting->meta ? $setting->meta->meta_title : $setting->title);
        SEOMeta::setDescription($setting->meta ? $setting->meta->meta_description : $setting->about);
        SEOMeta::setKeywords(explode(' ', $setting->meta ? $setting->meta->meta_keywords : $setting->about));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('auth.login', compact(['title', 'setting']));
    }

    private function mobileCheck($mobile)
    {
            $user = User::where('mobile', $mobile)
                ->first();
            if ($user){
                $user->ip_address = request()->ip();
                $user->save();
                event(new MsgVerifyCode($user));
            }
            if (!$user) {
                event(new MsgVerifyCodeMobile($mobile));
            }
            if ($user && !$user->status) {
                toast(__('dashboard.mobile_blocked'), 'error');
                return redirect()->back();
            }
            return $user?$user->mobile:$mobile;
    }

    private function emailCheck($email)
    {
            $user = User::where('email', $email)
                ->first();
            if ($user){
                $user->ip_address = request()->ip();
                $user->save();
            }
            if ($user && !$user->status) {
                toast(__('dashboard.mobile_blocked'), 'error');
                return redirect()->back();
            }
            $result_email = $user->email??$email;
            DB::table('activation_codes')->where('mobile_email',$result_email)->delete();
            $code = Activation_Code::createCodes($result_email)->code;
            $characters = str_split($code);
            $result = implode(' ', $characters);
            Helper::notification('کد تایید', 'ورود / ثبت نام', 'کد تایید شما : ' . strrev($result), $result_email);

            return $result_email;
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $mobile_email = $request->mobile_email;
        if (is_numeric($mobile_email)) {
            $validatorMobile = Validator::make($request->all(), [
                'mobile_email' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
            ]);
            if ($validatorMobile->fails()) {
                toast(__('front.mobile_valid'), 'error');
                return back();
            }
            $user = User::where('mobile', $request->mobile_email)->first();
            if (!$user) {
                Activation_Code::where('mobile_email', $mobile_email)->delete();
                event(new MsgVerifyCodeMobile($mobile_email));
            } else {
                $user->ip_address = request()->ip();
                $user->save();
                Activation_Code::where('user_id', $user->id)->delete();
                event(new MsgVerifyCode($user));
            }

            toast(__('front.sendCodeMobile'), 'success');
            $request->session()->flash('auth', [
                'mobile' => $mobile_email,
                'email' => null,
            ]);
        } else {
            $validatorEmail = Validator::make($request->all(), [
                'mobile_email' => 'required|email',
            ]);

            if ($validatorEmail->fails()) {
                toast(__('front.email_valid'), 'error');
                return back();
            }
            $user = User::where('email', $mobile_email)->first();
            if (!$user) {
                $code = Activation_Code::createCodes($mobile_email)->code;
            } else {
                $user->ip_address = request()->ip();
                $user->save();
                $code = Activation_Code::createCode($user)->code;
            }

            $characters = str_split($code);
            $result = implode(' ', $characters);
            Helper::notification('کد تایید', 'ورود / ثبت نام', 'کد تایید شما : ' . strrev($result), $mobile_email);

            toast(__('front.sendCodeEmail'), 'success');
            $request->session()->flash('auth', [
                'mobile' => null,
                'email' => $request->mobile_email,
            ]);
        }
        return redirect()->route('verify.show');
    }

    public function verifyShow(): Factory|Application|View|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

        $auth = request()->session()->get('auth');
        if (!request() || auth()->check()) {
            return redirect()->route('index.welcome');
        }
        if (auth()->check() || !$auth) {
            toast(__('dashboard.warning'), 'error');
            return redirect()->route('index.welcome');
        }
        request()->session()->reflash();
        $title = __('dashboard.verify');
        $setting = Setting::with(['logo', 'favicon'])->first();
        SEOMeta::setTitle($setting->meta ? $setting->meta->meta_title : $setting->title);
        SEOMeta::setDescription($setting->meta ? $setting->meta->meta_description : $setting->about);
        SEOMeta::setKeywords(explode(' ', $setting->meta ? $setting->meta->meta_keywords : $setting->about));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('auth.verified', compact(['title', 'setting']));
    }

    public function verify(): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('index.welcome');
        }
            $user = null;
            $mobile = null;
            $email = null;

            if (request('mobile')) {
                $user = User::where('mobile', request('mobile'))->first();
                $mobile = request('mobile');
            } elseif (request('email')) {
                $user = User::where('email', request('email'))->first();
                $email = request('email');
            }

            $code = request()->combined_digits;
            if (!$user) {
                $mobile_email = $mobile ?? $email;
                $activationCode = Activation_Code::where('mobile_email', $mobile_email)->where('code', $code)->first();
            } else {
                $activationCode = Activation_Code::where('user_id', $user->id)->where('code', $code)->first();
            }

            if (!$activationCode) {
                request()->session()->reflash();
                toast('کد مورد نظر اشتباه می باشد', 'error');
                return redirect()->route('verify.show');
            } elseif ($activationCode->expired < Carbon::now()) {
                request()->session()->reflash();
                toast(__('dashboard.expiredCode'), 'error');
                return redirect()->route('verify.show');
            } elseif ($activationCode->use) {
                request()->session()->reflash();
                toast(__('dashboard.usedCode'), 'error');
                return redirect()->route('verify.show');
            }

            $activationCode->delete();
            if ((isset($mobile) || isset($email)) && empty($user)) {
                if (isset($mobile)) {
                    $user = User::create([
                        'mobile' => $mobile
                    ]);
                }
                if (isset($email)) {
                    $user = User::create([
                        'email' => $email
                    ]);
                }
            }
            $id = $user->id;
            Auth::loginUsingId($id);
            if ($user->email) {
                $this->sendEmailWelcome($user);
            }
            toast('شما با موفقیت وارد سایت شدید', 'success');
            return redirect()->route('index.welcome');
    }

    public function sendEmailWelcome(User $user): bool
    {
        try {
            $setting = Setting::with(['logo', 'favicon'])->first();
            Helper::notification('ورود به '.$setting->title , __('dashboard.welcome_web'), 'ورود با آدرس آی پی : ' .  request()->ip(), $user);
            return true;
        } catch (\Exception) {
            toast('مشکل در ارتباط با سرور دوباره سعی کنید', 'error');
            return false;
        }
    }

}

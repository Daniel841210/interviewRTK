<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Entity\Member;
use Config;
use Session;

class AuthController extends Controller
{ 
    //登入頁面
    public function loginPage()
    {   
        return view('layouts/login'); //顯示登入頁面
    }
    
    //登入
    public function login(Request $request)
    {
        $account = $request->input('account'); //取得使用者輸入的帳號
        $password = $request->input('password'); //取得使用者輸入的密碼
        $userData = Member::where(['account'=>$account, 'password'=>$password])->get(); //根據上述帳密去資料庫中撈資料
        
        //是否有撈出資料(有:使用者帳密正確；無:帳密錯誤或無此使用者)
        if( $userData->isEmpty() ){ 
            Session::flash('loginError', "登入失敗，請檢查帳號或密碼!"); //將登入錯誤訊息加入Flash Session
            
            return redirect()->back(); //重新導回此頁面(登入)
        }
        else{
            Session::put('userID', $userData[0]['staffID']); //將登入者ID加入Session
            return redirect('otpAuthPage'); //導向OTP認證頁面
            
        } 
    }
    
    //OTP認證頁面
    public function otpAuthPage(){
        return view('layouts/otpAuth'); //顯示OTP認證頁面
    }
    
    //OTP驗證
    public function OtpAuthSuccess(){
        $userData = Member::where('staffID', (string)(Session::get('userID')) )->get(); //根據Session中userID取出對應職員的全部資料
        Session::put('status', $userData[0]['status']);  //將登入者身分加入Session

        //判斷登入者身分(主管或一般員工)
        if( Session::get('status') === 'employee' ){ 
            return redirect('employee'); //導向一般員工頁面
        }
        else if( Session::get('status') === 'manager'){ 
            return redirect('manager'); //導向主管頁面
        }  
    }
    
    //登出
    public function logout()
    {
        Session::flush(); //清除登入狀態的Session資料(status、userID)

        return redirect('login'); //導向登入頁面
    }
}

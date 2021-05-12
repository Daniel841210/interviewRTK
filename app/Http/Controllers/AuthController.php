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
        return view('layouts/login');
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
            Session::put('status', $userData[0]['status']); 
            
            //判斷登入者身分(主管或一般員工)
            if( Session::get('status') === 'employee' ){ 
                Session::put('userID', $userData[0]['staffID']); //將登入者ID加入Session
                return redirect('employee'); //導向一般員工頁面
            }
            else if( Session::get('status') === 'manager'){ 
                Session::put('userID', $userData[0]['staffID']); //將登入者ID加入Session
                return redirect('manager'); //導向主管頁面
            }  
        } 
    }
    
     //登出
    public function logout()
    {
        Session::flush(); //清除登入狀態的Session資料(status、staffID)

        return redirect('login'); //導向登入頁面
    }
}
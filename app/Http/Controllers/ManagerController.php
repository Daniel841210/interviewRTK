<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Entity\Member;
use Config;
use Session;

class managerController extends Controller
{ 
    //顯示個人資料
    public function showProfile()
    {
        $userData = Member::where('staffID', (string)(Session::get('userID')) )->get(); //根據Session中userID取出對應職員的全部資料
        $status = $userData[0]['status']; //取出status(用於設定職位欄位的值)
        $employee = Member::where('status', "employee" )->get(); //取出職位是一般員工的全部資料
        $all_Num = Member::where('status', 'employee')->count(); //所有一般員工數量

        $binding = ['userData'=>$userData,
                    'status'=>$status,
                    'employee'=>$employee,
                    'all_Num'=>$all_Num];
            
        return view('layouts/manager', $binding);
    }
}

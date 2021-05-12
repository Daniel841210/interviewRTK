<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Entity\Member;
use Config;
use Session;

class EmployeeController extends Controller
{ 
    //顯示個人資料
    public function showProfile()
    {
        $userData = Member::where('staffID', (string)(Session::get('userID')) )->get(); //根據Session中staffID取出對應職員的全部資料
        $status = $userData[0]['status']; //取出status(用於設定職位欄位的值)

        $binding = ['userData'=>$userData,
                    'status'=>$status];
            
        return view('layouts/employee', $binding);
    }
}
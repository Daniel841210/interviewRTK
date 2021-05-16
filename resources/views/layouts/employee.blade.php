<!--一般員工個人資料頁面-->

<!DOCTYPE html>
<html lang="en">

<head>
    <!--檢查登入狀態，避免登出後返回上一頁-->
    <script type="text/javascript" src="{{ URL::asset('js/checkLogin.js') }}"></script>
    <script> checkLogin(); </script> 
    
    <!--檢查認證狀態-->
    <script type="text/javascript" src="{{ URL::asset('js/checkOTP.js') }}"></script>
    <script> checkOTP(); </script> 
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>瑞昱IT-SD4面試測驗</title> <!--瀏覽器標題-->
    
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}"> <!--瀏覽器左上角圖示-->
    <link href="{{ asset('css/staff.css') }}" rel="stylesheet" />
    <!--    Bootstrap-->
    <link rel="stylesheet" href="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css') }}">
    <link href="{{ asset('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css') }}" rel="stylesheet"/>
</head>
   
    
<body>
    <div class="container-fluid">
        <!--上方header-->
        <div class="row nvbar">
            <div class="col-md-8" id="title">瑞昱IT-SD4面試測驗-職員資料系統</div>
            <div class="col-md-3" id=logout_btn>
                <!--登出按鈕-->
                <a id="logout" href="/logout" >
                    <span class="spinner-border spinner-border-sm hide" id="loading"></span>登出
                </a>
            </div>
             <div class="col-md-1"></div>
        </div>
        
        <!--職員基本資料-->
        <div class="row">
            <div class="col-md-4"></div>
            
            <div class="col-md-4" id="content_column">
                <div class="title">職員基本資料</div>
                
                <div id="profile_div">
                    <div id="profile">
                        <div class="row">
                            <div style="display:inline-block"> 
                                <i class="fa fa-id-card"></i>
                            </div>
                            <div class="dataTitle"> 工號：</div>
                            <div class="data">
                                <p name="ID" id=""> {{ $userData[0]['staffID'] }} </p>
                            </div>
                        </div>
                        <div class="row">
                            <div style="display:inline-block"> 
                                <i class="fa fa-user-circle"></i>
                            </div>
                            <div class="dataTitle"> 姓名：</div>
                            <div class="data">
                                <p name="Name" id=""> {{ $userData[0]['name'] }} </p>
                            </div>
                        </div>
                        <div class="row">
                            <div style="display:inline-block"> 
                                <i class="fa fa-graduation-cap"></i>
                            </div>
                            <div class="dataTitle" > 職位：</div>
                            <div class="data">
                                <p name="status" id="status"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div style="display:inline-block"> 
                                <i class="fa fa-address-book"></i>
                            </div>
                            <div class="dataTitle" > 帳號：</div>
                            <div class="data">
                                <p name="account"> {{ $userData[0]['account'] }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div style="display:inline-block"> 
                                <i class="fa fa-unlock-alt"></i>
                            </div>
                            <div class="dataTitle" > 密碼：</div>
                            <div class="data">
                                <p class="password_field" id="password_field" name="password"> {{ $userData[0]['password'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        
        <!--下方提示資訊-->
        <div class="row alert alert-primary" id="info_block">
            <ul>
                <li>一般員工僅供檢視個人資料</li>
                <li>主管可檢視所有一般員工資料</li>
                <li>點擊密碼欄位可顯示(隱藏)密碼</li>
            </ul>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script src="https://use.fontawesome.com/cb9ded6874.js"></script>
    
    <script>
        var status = {!! json_encode($status) !!}; //取得來自controller的資料(職位)
        // 設定職位欄位
        $(document).ready(function(){
            if( status == "employee"){
                $("#status").text("一般員工");
            }
            else if(status == "manager"){
                $("#status").text("主管");
            }
            
            //顯示(隱藏)密碼
            $("#password_field").click(function(){
                $("#password_field").toggleClass("password_field");
            });
        });
        //按下登出按鈕
        $( "#logout" ).click(function() {
            $("#loading").removeClass( "hide" ); //顯示laoding樣式
            localStorage.clear(); //移除前端網頁暫存內的登入狀態
        });
    </script>
</body>

</html>

<!--登入頁面-->

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!--
    <script src="https://unpkg.com/otplib@^6.0.0/otplib-browser.js"></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
-->
    
    <!--OTP認證功能-->
    <script type="text/javascript" src="{{ URL::asset('js/otpAuth.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/ycliu666/interviewRTK/public/js/otpAuth.js"></script>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>瑞昱IT-面試測驗</title> <!--瀏覽器標題-->
    
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}"> <!--瀏覽器左上角圖示-->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/otpAuth.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/ycliu666/interviewRTK/public/css/otpAuth.css" rel="stylesheet" />


    
    <!--    Bootstrap-->
    <link rel="stylesheet" href="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css') }}">
    <link href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css') }}" rel="stylesheet"/>
</head>
   
    
<body>
    <div class="container">
        <!--大標題-->
        <div class="row" id="title">
            <div class="col-md-12">
                <p>瑞昱IT-SD4面試測驗-職員資料系統</p>
            </div>
        </div>
        
        <div class="row" id="content">
            <!--圖片-->
            <div class="col-md-7" id="logo_column">
                <img class="svg bigLogo" id="logo_image" src="{{ URL::asset('images/logo.jpg') }}" alt="登入" />
            </div>
            
            <!--帳密欄位表單-->
            <div class="col-md-4" id="form_column">
                <form action="login/submit" method="post" id="login_form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"> <!--表單資安用欄位-->
                    <input type="text" name="account" id="account_text" required="required" oninvalid="invalidInput()" placeholder=" &#61447; 帳號" />
                    <input type="password" name="password" id="password_text" required="required" oninvalid="invalidInput()" placeholder=" &#xf023; 密碼" />
                    <input type="submit" id="submit" name="submit" value="登入" style="display:none" />
                </form>
                
                <div id="submit_div"> 
                    <!--登入按鈕-->
                    <button id="login_btn" >
                        <!--loading圖示(預設隱藏)-->
                        <span class="spinner-border spinner-border-sm hide" id="loading"></span> 登入
                    </button>
                </div>
               
            </div>
            <div class="col-md-1"></div>
        </div>

        <!--帳密錯誤訊息(預設隱藏)-->
        @if (Session::has('loginError'))
        <div class="alert alert-danger alert-dismissible fade show" id="error_block"> 
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{{ Session::get('loginError') }}</strong> 
        </div>
        @endif
        
        <div class="row" style="text-align:center">
            <div class="col-md-1"></div>
            <!--下方說明文字-->
            <div class="col-md-4" style="text-align:center">
                <div class="alert alert-info" id="info_block" >
                    <ul>
                        <li>請輸入提供之帳號與密碼</li>
                        <li>使用者分為主管與一般員工</li>
                        <li>將依據不同身份導向不同頁面</li>
                        <li>請輸入認證電子郵件</li>
                        <li>請於有效時限內完成驗證</li>
                        <li>錯誤過多次將使驗證碼失效</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2"></div>
            
            <!--OTP驗證區-->
            <div class="col-md-4">
                <div id="otp_div"></div>
            </div>
            
            <div class="col-md-1"></div>
        </div>
        
    </div>
    
    <script>
         //網頁完全載入後執行
        $(document).ready(function(){
            //登入錯誤，則清除前端暫存
            @if (Session::has('loginError'))
                localStorage.clear();
            @endif
            
            //在帳密欄按enter後執行之動作
            $('#account_text,#password_text').keypress(function(e){
              if(e.keyCode==13){
                 $('#login_btn').click();  //觸發登入按鈕
              }
            });
        });
    
        //按下登入按紐
        $( "#login_btn" ).click(function() {
            if ( (localStorage.getItem('OTPVerify')) == null){
                alert("請先進行OTP認證")
            }
            else{
                $("#loading").removeClass( "hide" );  //顯示laoding圖示
                localStorage.setItem('login', 'true'); //將登入狀態加入前端網頁的暫存
                $('#submit').click(); //送出表單
            }
        });
        
        //帳密欄位格式不符時
        function invalidInput(){
            $("#loading").addClass( "hide" ); //移除laoding圖示
            localStorage.clear(); //移除前端網頁暫存內的登入狀態
        }
    </script>
</body>

</html>
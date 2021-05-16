<!--opt驗證頁面-->

<!DOCTYPE html>
<html lang="en">

<head>
    <!--檢查登入狀態，避免登出後返回上一頁-->
    <script type="text/javascript" src="{{ URL::asset('js/checkLogin.js') }}"></script>
    <script> checkLogin(); </script> 
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>瑞昱IT-SD4面試測驗</title> <!--瀏覽器標題-->
    
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}"> <!--瀏覽器左上角圖示-->
    <link href="{{ asset('css/staff.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/otpAuth.css') }}" rel="stylesheet" />
    <!--    Bootstrap-->
    <link rel="stylesheet" href="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css') }}">
    <link href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css') }}" rel="stylesheet"/>

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
        
        <!--驗資資料-->
        <div class="row">
            <div class="col-md-4"></div>
            
            <div class="col-md-4" id="content_column">
                <div class="title">驗證電子郵件</div>
                
                <div id="verify_div">
                    <!--電子郵件表單-->
                    <form id="send_email">
                        <div class="row" style="text-align:center; display:block;" >
                            <div style="display:inline-block"> 
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="dataTitle" style="display:inline-block"> 電子郵件：</div>
                            <div class="data" style="display:inline-block">
                                <input type="email" id="email_text" required="required">
                            </div>
                        </div>
                        
                        <div style="text-align:center; display:block">
                            <input class="btn btn-warning" type="submit" id="send_button" value="寄送驗證碼"/>
                        </div>
                    </form>
                    
                    <!--有效期限倒數計時器-->
                    <br>
                    <div id="time_div"> <span id="timeLeft">驗證碼有效時間剩餘: &nbsp  秒</span> </div>
                    <br>
                    
                    <!--驗證表單-->
                    <form id="verify_totp">
                            <input type="text" id="totp_text" maxlength="6" required="required">
                            <input class="btn btn-success" type="submit" id="verify_button" value="確認"  disabled/> 
                    </form>
                    
                    <!--驗證碼錯誤訊息-->
                    <div class="alert alert-danger fade" id="error_block"> 
                        <strong>驗證碼錯誤</strong> 
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        
        <!--下方提示資訊-->
        <div class="row alert alert-primary" id="info_block">
            <ul>
                <li>請輸入正確電子郵件</li>
                <li>請於有效時限內完成驗證</li>
                <li>錯誤過多次將使驗證碼失效</li>
            </ul>
        </div>
    </div>
    
    <!-- The Modal -->
    <div class="modal fade" id="my_modal" role="dialog">
        <div class="modal-dialog modal-lg">
             <!-- Modal內容-->
            <div class="modal-content">
                <div class="modal-header d-block">
                    <!--右上角關閉叉叉-->
                    <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!--標題-->
                    <h4 class="modal-title" style="text-align:center">驗證碼已送出</h4>
                </div>
                <!--內文-->
                <div class="modal-body" style="text-align:center;">
                    <p id="modal_body_content"></p>
                </div>
                <div class="modal-footer" style="justify-content: center; align-items: center;">
                    <!--關閉按鈕-->
                    <button type="button" class="btn btn-danger" data-dismiss="modal" >關閉</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/otplib@^6.0.0/otplib-browser.js"></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    
    <script>
        $(document).ready(function () {
            var validTime = "60"; //totp有效時間
            var secret; //用於產生驗證碼的金鑰
            var token; //驗證碼
            var countDownTimer; //計時器
            var time; //用於計時器之時間

            $("#error_block").hide(); //隱藏錯誤訊息
            $("#error_block").removeClass("fade"); //移除fade屬性(fade屬性用於避免畫面初始時顯示元件)

            //寄信表單送出時
            $('#send_email').submit(function (e) {
                e.preventDefault(); //不跳轉畫面
                sendTotp(); //寄送totp
                return false; //不刷新畫面
            });

            //寄送totp
            function sendTotp(){
                secret = otplib.authenticator.generateSecret(); //產生金鑰
                generateTotpPassword(); //產生totp
                var email = $('#email_text').val(); //取得使用者輸入的email
                sendTotpEmail(email); //寄送totp至Email
            }

            // 藉由金鑰產生totp
            function generateTotpPassword() {
                otplib.authenticator.options = { step: validTime }; //設定totp有效時間
                token = otplib.authenticator.generate(secret); //產生totp
            }


            //寄送電子郵件
            function sendTotpEmail( email ) {
                Email.send({
                    Host: "smtp.gmail.com",
                    Username: "testrealtek123@gmail.com", //寄送者email
                    Password: "realtek123", //寄件人email密碼
                    To: email, //收件人email
                    From: "testrealtek123@gmail.com", //寄件人email
                    Subject: "職員資料系統-驗證碼", //信件標題
                    Body: "您的職員資料系統驗證碼為: " + token + "。" + "<br>請於" + validTime + "秒內完成驗證!", //信件內容
                })
                .then(function (message) { //寄信完成後要執行的事
                    time = validTime; //初始totp有效時間
                    clearInterval(countDownTimer); //停止倒數
                    countDownTimer = setInterval(countDown, 1000); //開始倒數
                    $('#modal_body_content').text("驗證碼已寄送至: "+ email); //顯示寄送成功訊息
                    $("#my_modal").modal(); //建立modal
                    $('#totp_text').val(""); //清除驗證碼輸入欄位
                    $('#verify_button').prop("disabled", false); //移除認證按鈕的禁用屬性
                    $("#verify_button").attr("title", ""); //移除滑鼠移至按鈕顯示訊息
                });
            }

            //倒數計時器
            function countDown() {
                time -= 1 ; //每次進入時間減1
                $('#timeLeft').text("驗證碼有效時間剩餘: " + time + " 秒"); //更新顯示時間
                // 倒數結束
                if (time <= 0) {
                    clearInterval(countDownTimer); //停止倒數
                    $('#timeLeft').text("驗證碼已失效"); 
                    $('#verify_button').prop("disabled", true); //驗證碼失效則禁用確認按鈕
                    $("#verify_button").attr("title", "驗證碼已失效，請重新寄送"); //滑鼠移至按鈕顯示訊息
                }
            }

            //認證表單送出時
            $('#verify_totp').submit(function () {
                var totp_input = $('#totp_text').val() //取得使用者輸入的驗證碼
                verify( totp_input ); //驗證totp
                return false; //不刷新畫面
                
            });

            //認證
            function verify( totp_input ){
                //回傳金鑰與認證碼進行認證
                var result = otplib.authenticator.verify({
                    secret: secret, //要驗證的金鑰
                    token: totp_input, //要驗證的totp
                });
                //認證結果
                if (result) {
                    localStorage.setItem('OTPSuccess', 'true'); //將OTP認證加入前端網頁的暫存
                    alert("驗證成功")
                    window.location.href = "otpAuthPage/success"; //認證成功，導向使用者頁面
                } else {
                    $("#error_block").show(); //顯示登入失敗提示
                    setTimeout(function () { $('#error_block').hide(); }, 1500); //登入失敗提示1.5秒後自動消失
                }
            }
        });
    
    </script>
</body>
</html>
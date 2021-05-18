
function implementOTP(){
    $("#otp_div").html('<!--電子郵件表單-->\
                         <form id="send_email">\
                            <div class="row" style="text-align:center; display:block;" >\
                                <div style="display:inline-block">\
                                    <i class="fa fa-envelope"></i>\
                                </div>\
                                <div class="dataTitle" style="display:inline-block"> 電子郵件：</div>\
                                <div class="data" style="display:inline-block">\
                                    <input type="email" id="email_text" required="required">\
                                </div>\
                            </div>\
                            \
                            <div style="text-align:center; display:block">\
                                <input class="btn btn-warning" type="submit" id="send_button" value="寄送驗證碼"/>\
                            </div>\
                          </form>\
                          \
                          <!--有效期限倒數計時器-->\
                            <div id="time_div"> <span id="timeLeft">驗證碼有效時間剩餘: &nbsp  秒</span> </div>\
                          \
                          <!--驗證表單-->\
                          <form id="verify_totp">\
                            <input type="text" id="totp_text" maxlength="6" required="required">\
                            <input class="btn btn-success" type="submit" id="verify_button" value="確認" disabled/>\ </form>\
                          \
                          <!--驗證碼錯誤訊息-->\
                          <div class="alert alert-danger" id="error_block"> <strong>驗證碼錯誤</strong>  </div>\
                          \
                          <!-- The Modal -->\
                          <div class="modal fade" id="my_modal" role="dialog">\
                            <div class="modal-dialog modal-lg">\
                                <!-- Modal內容-->\
                                <div class="modal-content">\
                                    <div class="modal-header d-block">\
                                        <!--右上角關閉叉叉-->\
                                        <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">\
                                            <span aria-hidden="true">&times;</span>\
                                        </button>\
                                        <!--標題-->\
                                        <h4 class="modal-title" style="text-align:center">驗證碼已送出</h4>\
                                    </div>\
                                    <!--內文-->\
                                    <div class="modal-body" style="text-align:center;">\
                                        <p id="modal_body_content"></p>\
                                    </div>\
                                    <div class="modal-footer" style="justify-content: center; align-items: center;">\
                                        <!--關閉按鈕-->\
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" >關閉</button>\
                                    </div>\
                                </div>\
                            </div>\
                         </div\>\
                        ');
    
    $("#error_block").hide(); //隱藏錯誤訊息
    sessionStorage.removeItem('OTPVerify'); //重整頁面時清除OTP認證
    
    // 引入外部js檔案
    $.getScript('https://unpkg.com/otplib@^6.0.0/otplib-browser.js'); //otp驗證
    $.getScript('https://smtpjs.com/v3/smtp.js'); // 寄信
    
    //引入外部css檔案
    $('<link/>', {
       rel: 'stylesheet',
       type: 'text/css',
       href: 'https://cdn.jsdelivr.net/gh/ycliu666/interviewRTK/public/css/verifyOTP.css'
    }).appendTo('head');
    $('<link/>', {
       rel: 'stylesheet',
       type: 'text/css',
       href: 'https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'
    }).appendTo('head');
    $('<link/>', {
       rel: 'stylesheet',
       type: 'text/css',
       href: 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'
    }).appendTo('head');
}

//畫面載入後執行上述方法
jQuery(document).ready(function($){ implementOTP(); });

$(document).ready(function(){
    var validTime = "120"; //totp有效時間
    var secret; //用於產生驗證碼的金鑰
    var token; //驗證碼
    var countDownTimer; //計時器
    var time; //用於計時器之時間

    $("#error_block").hide(); //隱藏錯誤訊息
    
    //append方式的元素是在整個文件載入完之後開始新增，頁面不會為其初始化事件，故使用$('').submit(function(){})失效，
    //因此將指定的事件繫結在document上，只要append元素符合指定的元素，就會繫結此事件 。
    
    //寄信表單送出時
    $(document).on("submit","#send_email",function(e){
        e.preventDefault(); //不跳轉畫面
        sendTotp(); //寄送totp
        return false; //不刷新畫面
    });

    //寄送totp
    function sendTotp() {
        secret = otplib.authenticator.generateSecret(); //產生金鑰
        generateTotpPassword(); //產生totp
        var email = $('#email_text').val(); //取得使用者輸入的email
        sendTotpEmail(email); //寄送totp至Email
    }

    // 藉由金鑰產生totp
    function generateTotpPassword() {
        otplib.authenticator.options = {
            step: validTime
        }; //設定totp有效時間
        token = otplib.authenticator.generate(secret); //產生totp
    }


    //寄送電子郵件
    function sendTotpEmail(email) {
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
                $('#modal_body_content').text("驗證碼已寄送至: " + email); //顯示寄送成功訊息
                $("#my_modal").modal(); //建立modal
                $('#totp_text').val(""); //清除驗證碼輸入欄位
                $('#verify_button').prop("disabled", false); //移除認證按鈕的禁用屬性
                $("#verify_button").attr("title", ""); //移除滑鼠移至按鈕顯示訊息
            });
    }

    //倒數計時器
    function countDown() {
        time -= 1; //每次進入時間減1
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
    $(document).on("submit","#verify_totp",function(e){
        e.preventDefault(); //不跳轉畫面
        var totp_input = $('#totp_text').val() //取得使用者輸入的驗證碼
        verify(totp_input); //驗證totp
        return false; //不刷新畫面
    });

    //認證
    function verify(totp_input) {
        //回傳金鑰與認證碼進行認證
        var result = otplib.authenticator.verify({
            secret: secret, //要驗證的金鑰
            token: totp_input, //要驗證的totp
        });
        //認證結果
        if (result) {
            sessionStorage.setItem('OTPVerify', true); //將OTP認證加入前端網頁的暫存
            clearInterval(countDownTimer); //停止倒數
            $('#timeLeft').text("認證完成!");
            $('#verify_button').prop("disabled", true); //驗證完成則禁用確認按鈕
            alert("認證完成，請登入!")
        } else {
            $("#error_block").show(); //顯示登入失敗提示
            var msg = document.getElementById("error_block");
            msg.scrollIntoView(); //將畫面移至錯誤訊息
            setTimeout(function () {
                $('#error_block').hide();
            }, 1500); //登入失敗提示1.5秒後自動消失
        }
    }    
});

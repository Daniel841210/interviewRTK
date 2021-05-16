//透過前端檢查OTP認證狀態(避免登出後仍能返回上一頁)

function checkOTP(){
    //檢查登入狀態(透過前端暫存)
    if( (localStorage.getItem('OTPSuccess')) == null ){
        window.location.href = "/otpAuthPage"; //若無OTP認證則強制返回認證頁面
    } 
}

//透過前端檢查登入狀態(避免登出後仍能返回上一頁)

function checkLogin(){
    //檢查登入狀態(透過前端暫存)
    if( (localStorage.getItem('login')) == null ){
        window.location.href = "/login"; //若無登入狀態則強制返回登入頁面
    } 
}

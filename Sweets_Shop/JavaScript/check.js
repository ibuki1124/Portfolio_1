// 確認ダイアログを表示する関数
function check(){
    const result = confirm("アカウントを削除してもよろしいですか？");
    if (result) {
        return true;
    } else {
        alert("キャンセルされました。");
        return false;
        
    }
    document.getElementById("sign_out").addEventListener("click", check);
}
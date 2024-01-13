const password = document.getElementById("password");
const password_e = document.getElementById("password-e");
let display = document.getElementById("display");
let display_e = document.getElementById("display-e");

//表示ボタンでパスワードを表示・非表示で切り替える
display.addEventListener("click", function(){
    if (password.type === "password"){
        password.type = "text";
        display.className = "rabbit-eye-t"
    }else{
        password.type = "password";
        display.className = "rabbit-eye-f"
    }
});

display_e.addEventListener("click", function(){
    if (password_e.type === "password"){
        password_e.type = "text";
        display_e.className = "rabbit-eye-t"
    }else{
        password_e.type = "password";
        display_e.className = "rabbit-eye-f"
    }
});

//パスワードの入力を半角の英数字のみにする
function checkform($this){
    var str = $this.value;
    while(str.match(/[^A-Z^a-z\d\-]/)){
        str = str.replace(/[^A-Z^a-z\d\-]/, "");
    }
    $this.value = str;
}
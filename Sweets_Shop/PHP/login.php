<?php
    session_start();
    $_SESSION["boolean_s"] = 0;
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <!-- <meta name="viewport" content="width-device-width, initial-scale=1, minimum-scale=1, user-scalable=no"> -->
        <link rel = "stylesheet" href = "../CSS/heander.css">
        <link rel = "stylesheet" href = "../CSS/auth.css">
        <title>Rabbit's Confectionery Shop</title>
    </head>
    <body>
        <header>
            <div class="header">
                <div class="nav-left">
                    <form action="top.php" method="POST">
                        <input type="submit" value="トップ">
                    </form>
                </div>
                <div class="nav-center">
                    <h1>Rabbit's Confectionery Shop</h1>
                </div>
                <div class="nav-right">
                    <form action="sign_up.php" method="POST">
                        <input type="submit" value="新規登録">
                    </form>
                </div>
            </div>
        </header>
        <main class="sign">
            <div class="container">
                <form name="login_form" method = "POST" action="user.php">
                    <p class="auth-title">ログイン</p>
                    <div class="user-info-l">
                        <p>お名前</p>
                        <input type="text" name="user_name" maxlength="15" placeholder="15文字以内">
                    </div>
                    <div class="user-info-l">
                        <p>パスワード</p>
                        <input type="password" name="password" id="password" maxlength="8" placeholder="半角8文字以内" oninput="checkform(this)">
                        <span class="rabbit-eye-f" id="display"></span>
                    </div>
                    <div class="button button-l">
                        <input  type="reset" name="reset" value="入力内容の破棄" >
                        <input  type="submit" name="login" value="ログイン" >
                    </div>
                </from>
                <div class="error">
                    <?php
                        if (empty($_SESSION["boolean_l"])){
                            $_SESSION["boolean_l"] = 0;
                        }else if ($_SESSION["boolean_l"] == 1){
                            echo "＊空欄またはスペース(全角・半角)が含まれています";  
                        }else if ($_SESSION["boolean_l"] == 2){
                            echo "＊名前またはパスワードが違います";
                        }
                        $_SESSION["boolean_l"] = 0;
                    ?>
                </div>
            </div>
        </main>
        <script src="../JavaScript/form.js"></script>
    </body>
</html>
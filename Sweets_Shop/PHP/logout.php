<?php
    session_start();
    $_SESSION = array(); //セッションの中身をすべて削除
    session_destroy(); //セッションを破棄
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="3; url=login.php">
        <link rel = "stylesheet" href = "../CSS/heander.css">
        <link rel = "stylesheet" href = "../CSS/session_lost.css">
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
                        <input type="submit" value="サインアップ">
                    </form>
                    <form action="login.php" method="POST">
                        <input type="submit" value="ログイン">
                    </form>
                </div>
            </div>
        </header>
        <main>
            <p>ログアウトしました。</p>
            <p>3秒後に自動的にログイン画面に移動します。</p>
        </main>
    </body>
</html>
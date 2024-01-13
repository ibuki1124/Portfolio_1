<?php
    session_start();
    $_SESSION = array(); //セッションの中身をすべて削除
    session_destroy(); //セッションを破棄
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link rel = "stylesheet" href = "../CSS/heander.css">
        <title>Rabbit's Confectionery Shop</title>
    </head>
    <body>
        <header>
            <div class="header">
                <div class="nav-left"></div>
                <div class="nav-center">
                    <h1>Rabbit's Confectionery Shop</h1>
                </div>
                <div class="nav-right">
                    <form action="sign_up.php" method="POST">
                        <input type="submit" value="新規登録">
                    </form>
                    <form action="login.php" method="POST">
                        <input type="submit" value="ログイン">
                    </form>
                </div>
            </div>
        </header>
        <main>
            <p>Rabbit's Confectionery Shop へようこそ！！</p>
            <p>このサイトではうさぎ型のキャンディやチョコレートなどのお菓子を5種類とそれぞれストロベリー味・グレープ味・オレンジ味と3種類用意しています！</p>
        </main>
    </body>
</html>
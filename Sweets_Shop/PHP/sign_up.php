<?php
    session_start();
    $_SESSION["boolean_l"] = 0;
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
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
                        <form action="login.php" method="POST">
                            <input type="submit" value="ログイン">
                        </form>
                    </div>
            </div>
        </header>
        <main class="sign">
            <div class="container">
                <form name="sign_up_form" method = "POST" action="user.php" class="sign-form">
                    <p class="auth-title">新規登録</p>
                    <div class="user-info-s">
                        <p>
                            お名前
                            <span class="error-name">
                            <?php
                                if (isset($_SESSION["boolean_s"])){
                                    if ($_SESSION["boolean_s"] == 2){
                                        echo "＊この名前は既に使われています。";
                                    }
                                }                                
                            ?>
                            </span>
                        </p>
                        <input type="text" name="user_name" maxlength="15" placeholder="15文字以内">
                    </div>
                    <div class="user-info-s">
                        <p>パスワード</p>
                        <input type="password" name="password" id="password" maxlength="8" placeholder="半角8文字以内" oninput="checkform(this)">
                        <span class="rabbit-eye-f" id="display"></span>
                    </div>
                    <div class="user-info-s">
                        <p>お届け先住所</p>
                        <input type="text" name="address">
                    </div>
                    <div class="button button-s">
                        <input  type="reset" name="reset" value="リセット" class="form-button">
                        <input  type="submit" name="sign_up" value="登録" class="form-button">
                    </div>   
                </from>
                <div class="error">
                    <?php
                        try{
                            $dbh=new PDO('mysql:host=localhost;dbname=ibuki','ibuki','pipopa');
                        }catch(PDOException $e){
                            echo $e->getmessage();
                            exit;
                        }

                        // if (isset($_POST["sign_out"])){
                        //     $sql = "delete from users where id = :key_user_id";
                        //     $stmt = $dbh -> prepare($sql);
                        //     $stmt -> bindParam(":key_user_id", $_SESSION["user_id"]);
                        //     $stmt -> execute();
                        //     echo "アカウントを削除しました。";
                        // }

                        if (empty($_SESSION["boolean_s"])){
                            $_SESSION["boolean_s"] = 0;
                        }else if ($_SESSION["boolean_s"] == 1){
                            echo "＊空欄またはタブ・スペース(全角・半角)を含む文字は登録できません";
                        }
                        $_SESSION["boolean_s"] = 0;

                        $dbh =null;
                    ?>
                </div>
            </div>
        </main>
        <script src="../JavaScript/form.js"></script>
    </body>
</html>
<?php
    session_start();
    if (empty($_SESSION["user_id"]) || empty($_SESSION["user_name"]) || empty($_SESSION["user_password"]) || empty($_SESSION["user_address"])){
        header("Location:session_lost.php");
        exit;
    }
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
                    <form action="user.php" method="POST">
                        <input type="submit" value="マイページ">
                    </form>
                </div>
                <div class="nav-center">
                    <h1>Rabbit's Confectionery Shop</h1>
                </div>
                <div class="nav-right">
                    <!-- <form action="sign_up.php" method="POST" onsubmit="return check()">
                        <input type="submit" name="sign_out" id="sign_out" value="アカウントの削除">
                    </form> -->
                    <form action="logout.php" method="POST">
                        <input type="submit" value="ログアウト">
                    </form>
                </div>
            </div>
        </header>
        <main class="edit-main">
            <p class="sub-title">アカウント情報</p>
            <div class="edit">
                <?php
                    try{
                        $dbh=new PDO('mysql:host=localhost;dbname=ibuki','ibuki','pipopa');
                    }catch(PDOException $e){
                        echo $e->getmessage();
                        exit;
                    }

                    if (isset($_POST["profile_edit"])){
                        $_SESSION["boolean_e"] = 0;
                    }

                    echo "<div class=login_user>".$_SESSION["user_name"]."としてログイン中</div>";


                    if ( isset ($_POST["edit"]) && !empty($_POST["user_name"] && !empty($_POST["password"]) && !empty($_POST["address"]))){     //登録がクリックされたら
                        $user_name = $_POST['user_name'];
                        $user_name = htmlspecialchars(string: $user_name, flags: ENT_QUOTES, encoding: "UTF-8");
                        $password = $_POST['password'];
                        $password = htmlspecialchars(string: $password, flags: ENT_QUOTES, encoding: "UTF-8");
                        $address = $_POST['address'];
                        $address = htmlspecialchars(string: $address, flags: ENT_QUOTES, encoding: "UTF-8");
                        if (preg_match("/ +|　+|\t/", $user_name) || preg_match("/ +|　+|\t/", $password) || preg_match("/ +|　+|\t/", $address)){
                            $_SESSION["boolean_e"] = 1;
                            header("Location:profile_edit.php");
                            exit;
                        }else{
                            $sql_dub = "select * from users where name = :key_user_name";
                            $stmt_dub = $dbh -> prepare($sql_dub);
                            $stmt_dub -> bindParam(":key_user_name", $user_name);
                            $stmt_dub -> execute();
                            if (empty($stmt_dub-> fetchAll(PDO::FETCH_ASSOC)) || $_SESSION["user_name"] == $user_name){
                                $sql = "update users set name = :key_user_name, password = :key_password, address = :key_address where id = :key_user_id";
                                $stmt = $dbh -> prepare($sql);
                                $stmt -> bindParam(":key_user_id", $_SESSION["user_id"]);
                                $stmt -> bindParam(":key_user_name", $user_name);
                                $stmt -> bindParam(":key_password", $password);
                                $stmt -> bindParam(":key_address", $address);
                                $stmt -> execute();

                                $sql = "select * from users where id = :key_user_id";
                                $stmt = $dbh -> prepare($sql);
                                $stmt -> bindParam(":key_user_id", $_SESSION["user_id"]);
                                $stmt -> execute();
                                $user = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                                $_SESSION["user_name"] = $user[0]["name"];
                                $_SESSION["user_password"] = $user[0]["password"];
                                $_SESSION["user_address"] = $user[0]["address"];

                                $_SESSION["boolean_e"] = 3;
                            }else{
                                $_SESSION["boolean_e"] = 2;
                                header("Location:profile_edit.php");
                                exit;
                            }
                        }
                    }else{
                        if (isset($_POST["edit"])){
                            $_SESSION["boolean_e"] = 1;
                            header("Location:profile_edit.php");
                            exit;
                        }
                    }

                    echo 
                        "<div class='container container-e'>".
                            "<p class=auth-title>現在の登録情報</p>".
                            "<div class=user-info-e>".
                                "<p>会員ID</p>".
                                "<input disabled type=text value=$_SESSION[user_id]></input>".
                            "</div>".
                            "<div class=user-info-e>".
                                "<p>お名前</p>".
                                "<input disabled type=text value=$_SESSION[user_name]></input>".
                            "</div>".
                            "<div class=user-info-e>".
                                "<p>パスワード</p>".
                                "<input disabled type=password value=$_SESSION[user_password] id=password></input>".
                                "<span class='rabbit-eye-f' id=display></span>".
                            "</div>".
                            "<div class=user-info-e>".
                                "<p>お届け先住所</p>".
                                "<input disabled type=text value=$_SESSION[user_address]></input>".
                            "</div>".
                        "</div>";

                    echo "<p class=edit-arrow>→</p>";
                    

                    echo "<div class='container container-e'>".
                            "<form action=profile_edit.php method=POST>".
                                "<p class=auth-title>変更内容</p>".
                                "<div class=user-info-e>".
                                    "<p>会員ID<span class=error-name>＊会員IDは変更できません</span></p>".
                                    "<input disabled type=text value=$_SESSION[user_id]></input>".
                                "</div>";

                ?>
                                <div class="user-info-e">
                                    <p>
                                        お名前
                                        <span class="error-name">
                                        <?php
                                            if (isset($_SESSION["boolean_e"])){
                                                if ($_SESSION["boolean_e"] == 2){
                                                    echo "＊この名前は既に使われています。";
                                                }
                                            }                                
                                        ?>
                                        </span>
                                    </p>
                                    <input type="text" name="user_name" maxlength="15" placeholder="15文字以内">
                                </div>
                                <div class="user-info-e">
                                    <p>パスワード</p>
                                    <input type="password" name="password" id="password-e" maxlength="8" placeholder="半角8文字以内" oninput="checkform(this)">
                                    <span class="rabbit-eye-f" id="display-e"></span>
                                </div>
                                <div class="user-info-e">
                                    <p>お届け先住所</p>
                                    <input type="text" name="address">
                                </div>
                                <div class="button button-e">
                                    <input  type="reset" name="reset" value="リセット" class="form-button">
                                    <input  type="submit" name="edit" value="更新" class="form-button">
                                </div>   
                        <div class="error error-e">
                        <?php
                            if ($_SESSION["boolean_e"] == 1){
                                echo "＊空欄またはタブ・スペース(全角・半角)を含む文字は登録できません";
                            }else if ($_SESSION["boolean_e"] == 3){
                                echo "＊アカウント情報の更新が完了しました";
                            }
                            $_SESSION["boolean_e"] = 0;
                        ?>
                        </div>
                        </form>
                    </div>
            </div>
        </main>
        <script src="../JavaScript/check.js"></script>
        <script src="../JavaScript/form.js"></script>
    </body>
</html>
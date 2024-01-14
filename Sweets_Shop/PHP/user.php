<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link rel = "stylesheet" href = "../CSS/header.css">
        <link rel = "stylesheet" href = "../CSS/user.css">
        <title>Rabbit's Confectionery Shop</title>
    </head>
    <body>
        <header>
            <div class="header">
                <div class="nav-left">
                    <form action="sweet.php" method="POST">
                        <input type="submit" value="商品はこちら">
                    </form>
                    <form action="order_history.php" method="POST">
                        <input type="submit" name="order_history" value="購入履歴">
                    </form>
                </div>
                <div class="nav-center">
                    <h1>Rabbit's Confectionery Shop</h1>
                </div>
                <div class="nav-right">
                    <form action="profile_edit.php" method="POST" id="profile_edit" onsubmit="return password()">
                        <input type="submit" name="profile_edit" value="登録情報の変更">
                    </form>
                    <form action="logout.php" method="POST">
                        <input type="submit" value="ログアウト">
                    </form>
                </div>
            </div>
        </header>
        <main>
            <?php
                try{
                    $dbh=new PDO('mysql:host=localhost;dbname=rabbit_sweets','rabbit_1','portfolio');
                }catch(PDOException $e){
                    echo $e->getmessage();
                    exit;
                }

                if (isset($_POST["sign_up"]) || isset($_POST["login"])){
                    $user_name = $_POST['user_name'];
                    $user_name = htmlspecialchars(string: $user_name, flags: ENT_QUOTES, encoding: "UTF-8");
                    $password = $_POST['password'];
                    $password = htmlspecialchars(string: $password, flags: ENT_QUOTES, encoding: "UTF-8");
                }

                if ( isset ($_POST["sign_up"]) && !empty($_POST["user_name"] && !empty($_POST["password"]) && !empty($_POST["address"]))){     //登録がクリックされたら
                    $address = $_POST['address'];
                    $address = htmlspecialchars(string: $address, flags: ENT_QUOTES, encoding: "UTF-8");
                    if (preg_match("/ +|　+|\t/", $user_name) || preg_match("/ +|　+|\t/", $password) || preg_match("/ +|　+|\t/", $address)){
                        $_SESSION["boolean_s"] = 1;
                        header("Location:sign_up.php");
                        exit;
                    }else{
                        $sql_dub = "select * from users where name = :key_user_name";
                        $stmt_dub = $dbh -> prepare($sql_dub);
                        $stmt_dub -> bindParam(":key_user_name", $user_name);
                        $stmt_dub -> execute();
                        if (empty($stmt_dub-> fetchAll(PDO::FETCH_ASSOC))){
                            $sql = "insert into users(name, password, address) value(:key_user_name, :key_password, :key_address)";
                            $stmt = $dbh -> prepare($sql);
                            $stmt -> bindParam(":key_user_name", $user_name);
                            $stmt -> bindParam(":key_password", $password);
                            $stmt -> bindParam(":key_address", $address);
                            $stmt -> execute();

                            $sql = "select * from users where id = last_insert_id()";
                            $stmt = $dbh -> prepare($sql);
                            $stmt -> execute();
                            $user = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                            $_SESSION["user_id"] = $user[0]["id"];
                            $_SESSION["user_name"] = $user[0]["name"];
                            $_SESSION["user_password"] = $user[0]["password"];
                            $_SESSION["user_address"] = $user[0]["address"];

                            $_SESSION["success"] = 1;
                        }else{
                            $boolean_s = 2;
                            $_SESSION["boolean_s"] = $boolean_s;
                            header("Location:sign_up.php");
                            exit;
                        }
                    }
                }else if ( isset ($_POST["login"]) && !empty($_POST["user_name"]) && !empty($_POST["password"])){     //ログインがクリックされたら
                    if (preg_match("/ +|　+|\t/", $user_name) || preg_match("/ +|　+|\t/", $password)){
                        $_SESSION["boolean_l"] = 1;
                        header("Location:login.php");
                        exit;
                    }else{
                        $sql = "select * from users where name = :key_user_name && password = :key_password";
                        $stmt = $dbh -> prepare($sql);
                        $stmt -> bindParam(":key_user_name", $user_name);
                        $stmt -> bindParam(":key_password", $password);
                        $stmt -> execute();
                        $success = $stmt -> rowCount();
                        $user = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                        if ($success == 1){
                            $_SESSION["user_id"] = $user[0]["id"];
                            $_SESSION["user_name"] = $user[0]["name"];
                            $_SESSION["user_password"] = $user[0]["password"];
                            $_SESSION["user_address"] = $user[0]["address"];

                            $_SESSION["success"] = 2;
                        }else{
                            $_SESSION["boolean_l"] = 2;
                            header("Location:login.php");
                            exit;
                        }
                    }
                }else{
                    if (isset($_POST["sign_up"])){
                        $boolean_s = 1;
                        $_SESSION["boolean_s"] = $boolean_s;
                        header("Location:sign_up.php");
                        exit;
                    }else if(isset($_POST["login"])){
                        $boolean_l = 1;
                        $_SESSION["boolean_l"] = $boolean_l;
                        header("Location:login.php");
                        exit;
                    }
                }

                if (!empty($_SESSION["user_id"]) && !empty($_SESSION["user_name"]) && !empty($_SESSION["user_password"]) && !empty($_SESSION["user_address"])){
                    if (isset($_SESSION["success"])){
                        if($_SESSION["success"] == 1){
                            echo "<p class='success'>新規登録が完了しました。</p>";
                        }else if ($_SESSION["success"] == 2){
                            echo "<p class='success'>ログインに成功しました。</p>";
                        }
                        $_SESSION["success"] = 0;
                    }
                    echo "<div class='user'>".
                            "<p class='mypage'>マイページ</p>".
                            "<div class='user-info'>".
                                "<div class='login'><p>プロフィール</p></div>".
                                "<div class='user-1'>".
                                    "<div class='user-1-top'>".
                                        "<p class='user-icon'><img src='../img/icon/user_icon.png' alt='アイコン'></p>".
                                        "<p class='icon-not-edit'><span>＊現在、アイコンは変更できません</span></p>".
                                    "</div>".
                                    "<div class='user-1-top'>".
                                        "<p class='user-id'>会員ID</p>".
                                        "<p class='user-id'>".$_SESSION["user_id"]."</p>".
                                    "</div>".
                                "</div>".
                                "<div class='user-2'>".
                                    "<div class='user-name'>".
                                        "<p>名前</p>".
                                        "<p>".$_SESSION["user_name"]."</p>".
                                    "</div>".
                                    "<div class='user-address'>".
                                        "<p>お届け先住所</p>".
                                        "<p>".$_SESSION["user_address"]."</p>".
                                    "</div>".
                                "</div>".
                            "</div>".
                         "</div>";
                }else{
                    header("Location:session_lost.php");
                    exit;
                }

                echo "<div class=login_user>".$_SESSION["user_name"]."としてログイン中</div>";

                $dbh =null;

                if ($_SERVER["REQUEST_METHOD"] === "POST"){
                    header("Location:user.php");
                    if (isset($_POST["sign_up"])){
                        $_SESSION["success"] = 1;
                    }else if(isset($_POST["login"])){
                        $_SESSION["success"] = 2;
                    }
                    exit;
                }
            ?>
        </main>
        <script>
            function password(){
                let user_password = <?php echo json_encode($_SESSION["user_password"]); ?>;
                const result = prompt("現在のパスワードを入力してください\n(半角英数字)");

                if (result === user_password) {
                    alert("パスワードの入力に成功しました");
                    return true;
                } else {
                    alert("入力に失敗しました。\n文字の型などご確認ください。\n(全角・半角・スペース...など)");
                    return false;
                }
                document.getElementById("profile_edit").addEventListener("click", function(){
                    password();
                });
            }
        </script>
    </body>
</html>
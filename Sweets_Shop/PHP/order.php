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
        <title>Rabbit's Confectionery Shop</title>

    </head>
    <body>
        <header>
            <div class="header">
                <div class="nav-left">                
                    <form action="sweet.php" method="POST">
                        <input type="submit" value="商品一覧">
                    </form>
                    <form action="user.php" method="POST">
                        <input type="submit" value="マイページ">
                    </form>
                </div>
                <div class="nav-center">
                    <h1>Rabbit's Confectionery Shop</h1>
                </div>
                <div class="nav-right">
                    <form action="logout.php" method="POST">
                        <input type="submit" value="ログアウト">
                    </form>
                </div>
            </div>
        </header>
        <main>
            <?php
                try{
                    $dbh=new PDO('mysql:host=localhost;dbname=ibuki','ibuki','pipopa');
                }catch(PDOException $e){
                    echo $e->getmessage();
                    exit;
                }

                if (isset($_POST["order"])){
                    $_SESSION["reload"] = 1;
                }

                if (isset($_SESSION["reload"])){
                    if ($_SESSION["reload"] == 1){
                        echo "<h3>注文内容</h3>";
                        echo "　商　品：　".$_SESSION["sweet_name"]."<br> ".
                             "　味　　：　".$_SESSION["taste_name"]."<br>".
                             "　個　数：　".$_SESSION["num"]."<br>".
                             "合計金額：　".$_SESSION["num"] * $_SESSION["price"]."円<br>".
                             "合計金額：　".$_SESSION["time"]."<br><br>";
                        echo "<form action = order_history.php method = POST>
                                <input type = submit name = order_history value = 購入履歴へ>
                              </form>";
                    }
                }

                if (isset($_POST["order"])){ 
                    date_default_timezone_set('Asia/Tokyo');  
                    $_SESSION["time"] = date('Y年m月d日 H:i:s');                
                    $sql = "insert into sales(user_id) value(:key_user_id)";
                    $stmt = $dbh -> prepare($sql);
                    $stmt -> bindParam(":key_user_id", $_SESSION["user_id"]);
                    $stmt -> execute();

                    $sql = "insert into orders(sweet_id, taste_id, num, time) value(:key_sweet_id, :key_taste_id, :key_num, :key_time)";
                    $stmt = $dbh -> prepare($sql);
                    $stmt -> bindParam(":key_sweet_id", $_SESSION["sweet_id"]);
                    $stmt -> bindParam(":key_taste_id", $_SESSION["taste_id"]);
                    $stmt -> bindParam(":key_num", $_SESSION["num"]);
                    $stmt -> bindParam(":key_time", $_SESSION["time"]);
                    $stmt -> execute();
                }

                echo "<div class=login_user>".$_SESSION["user_name"]."としてログイン中</div>";
                if ($_SERVER["REQUEST_METHOD"] === "POST"){
                    header("Location:order.php");
                    exit;
                }

                $dbh =null;
            ?>
        </main>
    </body>
</html>
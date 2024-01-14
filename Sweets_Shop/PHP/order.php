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
        <link rel = "stylesheet" href = "../CSS/header.css">
        <link rel = "stylesheet" href = "../CSS/order.css">
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
                    $dbh=new PDO('mysql:host=localhost;dbname=rabbit_sweets','rabbit_1','portfolio');
                }catch(PDOException $e){
                    echo $e->getmessage();
                    exit;
                }

                if (isset($_POST["order"])){
                    $_SESSION["reload"] = 1;
                }

                if (isset($_SESSION["reload"])){
                    if ($_SESSION["reload"] == 1){
                        echo "<p class='confirm'>ご注文が確定しました。</p>".
                             "<div class='order-history'>".
                                "<div class='order'>".
                                    "<div class='order-element'>".
                                        "<p class='history-number'>注文内容</p>".
                                    "</div>".
                                    "<div class='order-element'>".
                                        "<p class=element-1>商品：</p>".
                                        "<p class=element-2>".$_SESSION["sweet_name"]."</p>".
                                    "</div>".
                                    "<div class='order-element'>".
                                        "<p class=element-1>味：</p>".
                                        "<p class=element-2>".$_SESSION["taste_name"]."</p>".
                                    "</div>".
                                    "<div class='order-element'>".
                                        "<p class=element-1>個数：</p>".
                                        "<p class=element-2>".$_SESSION["num"]."</p>".
                                    "</div>".
                                    "<div class='order-element'>".
                                        "<p class=element-1>合計金額：</p>".
                                        "<p class='element-2'>".$_SESSION["price"] * $_SESSION["num"]."円</p>".
                                    "</div>".
                                    "<div class='order-element'>".
                                        "<p class=element-1>購入時刻：</p>".
                                        "<p class='element-2'>".$_SESSION["time"]."</p>".
                                    "</div>".
                                    "<div class='order-element history'>".
                                        "<form action = 'order_history.php' method = 'POST'>
                                            <input type = 'submit' name = 'order_history' value = '購入履歴へ'>
                                        </form>".
                                    "</div>".
                                "</div>".
                             "</div>";
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
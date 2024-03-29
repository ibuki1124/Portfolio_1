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
                        <input type="submit" value="戻る">
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

                if (isset($_POST["sweets"])){
                    $sweet = $_POST["sweet"];
                    $taste = $_POST["taste"];

                    if ($sweet == "candy"){
                        $sweet_id = 1;
                    }else if ($sweet == "gummy"){
                        $sweet_id = 2;
                    }else if ($sweet == "chocolate"){
                        $sweet_id = 3;
                    }else if ($sweet == "macaron"){
                        $sweet_id = 4;
                    }else if ($sweet == "cake"){
                        $sweet_id = 5;
                    }

                    if ($taste == "berry"){
                        $taste_id = 1;
                    }else if ($taste == "grape"){
                        $taste_id = 2;
                    }else if ($taste == "orange"){
                        $taste_id = 3;
                    }
                }

                if (isset($_POST["order_num"])){
                    $_SESSION["num"] = $_POST["order_num"];
                }

                if (isset($sweet) && isset($taste)){
                    $sql = "select * from sweets where id = :key_sweet_id";
                    $stmt = $dbh -> prepare($sql);
                    $stmt -> bindParam(":key_sweet_id", $sweet_id);
                    $stmt -> execute();
                    foreach($stmt -> fetchAll(PDO::FETCH_ASSOC) as $s){
                        $_SESSION["sweet_id"] = $s["id"];
                        $_SESSION["sweet_name"] = $s["name"];
                        $_SESSION["price"] = $s["price"];
                    }

                    $sql = "select * from tastes where id = :key_taste_id";
                    $stmt = $dbh -> prepare($sql);
                    $stmt -> bindParam(":key_taste_id", $taste_id);
                    $stmt -> execute();
                    foreach($stmt -> fetchAll(PDO::FETCH_ASSOC) as $s){
                        $_SESSION["taste_id"] = $s["id"];
                        $_SESSION["taste_name"] = $s["name"];
                    }
                    echo "<p class='confirm'>こちらの商品で間違いありませんか？</p>".
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
                                    "<p class=element-2>".$s["name"]."</p>".
                                "</div>".
                                "<div class='order-element'>".
                                    "<p class=element-1>個数：</p>".
                                    "<p class=element-2>".$_SESSION["num"]."</p>".
                                "</div>".
                                "<div class='order-element'>".
                                        "<p class=element-1>合計金額：</p>".
                                        "<p class='element-2 total'>".$_SESSION["price"] * $_SESSION["num"]."円</p>".
                                "</div>".
                                "<form action='order.php' method='POST'>
                                            <input type='submit' name='order' value='注文確定' class='button-c'>
                                        </form>".
                                "</div>".
                        "</div>";
                         $_SESSION["boolean_sweet"] = 0;
                }else{
                    $_SESSION["boolean_sweet"] = 1;
                    header("Location:sweet.php");
                    exit;
                }

                echo "<div class=login_user>".$_SESSION["user_name"]."としてログイン中</div>";

                $dbh =null;
            ?>
        </main>
    </body>
</html>
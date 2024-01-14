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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.4/css/all.css">
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

                if (isset($_POST["order_history"])){
                    $_SESSION["reload"] = 0;
                }

                if (isset($_SESSION["reload"])){
                    if ($_SESSION["reload"] == 0){
                        $reload = $_SESSION["reload"];
                    }
                }else{
                    header("Location:user.php");
                    exit;
                }

                if ($_SERVER["REQUEST_METHOD"] === "POST"){
                    header("Location:order_history.php");
                    exit;
                }

                if (isset($_POST["order_history"]) || $reload == 0){
                    $sql = "select sales.user_id, sweets.name as sweet_name, tastes.name as taste_name, orders.num, orders.num * sweets.price as total_price, orders.time
                            from  sales, orders, sweets, tastes 
                            where sales.user_id = :key_user_id and sales.order_id = orders.id and orders.sweet_id = sweets.id and orders.taste_id = tastes.id
                            order by orders.id";
                    $stmt = $dbh -> prepare($sql);
                    $stmt -> bindParam(":key_user_id", $_SESSION["user_id"]);
                    $stmt -> execute();
                    $count = 0;
                    echo "<p class='sub-title'>購入履歴</p>".
                         "<div class='order-history'>";
                    foreach($stmt -> fetchAll(PDO::FETCH_ASSOC) as $s){
                        $count += 1;
                        echo "<div class='order'>".
                                "<div class='order-element'>".
                                    "<p class='history-number'>履歴番号".$count."</p>".
                                "</div>".
                                "<div class='order-element'>".
                                    "<p class=element-1>商品：</p>".
                                    "<p class=element-2>".$s["sweet_name"]."</p>".
                                "</div>".
                                "<div class='order-element'>".
                                    "<p class=element-1>味：</p>".
                                    "<p class=element-2>".$s["taste_name"]."</p>".
                                "</div>".
                                "<div class='order-element'>".
                                    "<p class=element-1>個数：</p>".
                                    "<p class=element-2>".$s["num"]."</p>".
                                "</div>".
                                "<div class='order-element'>".
                                    "<p class=element-1>合計金額：</p>".
                                    "<p class=element-2>".$s["total_price"]."円</p>".
                                "</div>".
                                "<div class='order-element'>".
                                    "<p class=element-1>購入日時：</p>".
                                    "<p class=element-2>".$s["time"]."</p>".
                                "</div>".
                             "</div>";
                    }
                    echo "</div>";
                    if (empty($s)){
                        echo "<div class='order-history no'>購入履歴なし</div>";
                    }
                }

                echo "<div class=login_user>".$_SESSION["user_name"]."としてログイン中</div>";
                $dbh =null;
            ?>
            <div class="page-top" id="page-top">
                <a href="#"></a>
            </div>
        </main>
        <script src="../JavaScript/scroll.js"></script>
    </body>
</html>
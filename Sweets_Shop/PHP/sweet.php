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
        <link rel = "stylesheet" href="../CSS/food.css">
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
            <form action="confirm.php" method="POST">
                <div class="food">
                    <p class="sub-title">商品一覧</p>
                    <div class="container-1">
                        <p class="food-title">お菓子</p>
                        <div class="sweets">
                            <div class="sweet">
                                <div class="sweet-name">キャンディ</div>
                                <input type="radio" name="sweet" value="candy" id="candy" checked>
                                <label for="candy"></label>
                            </div>
                            <div class="sweet">
                                <div class="sweet-name">グミ</div>
                                <input type="radio" name="sweet" value="gummy" id="gummy">
                                <label for="gummy"></label>
                            </div>
                            <div class="sweet">
                                <div class="sweet-name">チョコレート</div>
                                <input type="radio" name="sweet" value="chocolate" id="chocolate">
                                <label for="chocolate"></label>
                            </div>
                            <div class="sweet">
                                <div class="sweet-name">マカロン</div>
                                <input type="radio" name="sweet" value="macaron" id="macaron">
                                <label for="macaron"></label>
                            </div>
                            <div class="sweet">
                                <div class="sweet-name">ケーキ</div>
                                <input type="radio" name="sweet" value="cake" id="cake">
                                <label for="cake"></label>
                            </div>
                            <div class="sweet">
                                <div class="price">
                                    <p class="price-title">値段表</p>
                                    <div class="price-box">
                                        <div class="price-list">
                                            <p class="sweet-name-p">キャンディ</p>
                                            <p class="sweet-price">100円</p>
                                        </div>
                                        <div class="price-list">
                                            <p class="sweet-name-p">グミ</p>
                                            <p class="sweet-price">100円</p>
                                        </div>
                                        <div class="price-list">
                                            <p class="sweet-name-p">チョコレート</p>
                                            <p class="sweet-price">150円</p>
                                        </div>
                                        <div class="price-list">
                                            <p class="sweet-name-p">マカロン</p>
                                            <p class="sweet-price">300円</p>
                                        </div>
                                        <div class="price-list">
                                            <p class="sweet-name-p">ケーキ</p>
                                            <p class="sweet-price">500円</p>
                                        </div>
                                        <span>味による値段変動なし</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <p class="food-title">味</p>
                        <div class="tastes">
                            <div class="taste">
                                <div class="taste-name">ストロベリー</div>
                                <input type="radio" name="taste" value="berry" id="berry" checked>
                                <label for="berry"></label>
                            </div>

                            <div class="taste">
                                <div class="taste-name">グレープ</div>
                                <input type="radio" name="taste" value="grape" id="grape">
                                <label for="grape"></label>
                            </div>

                            <div class="taste">
                                <div class="taste-name">オレンジ</div>
                                <input type="radio" name="taste" value="orange" id="orange">
                                <label for="orange"></label>
                            </div>
                        </div>
                    </div>

                    <p class="num">個数</p>
                    <span>＊1注文につき10個まで</span>
                    <div class="container-2">
                        <div class="field">
                            <button type="button" class="button" id="down">－</button>
                            <input type="number" value="1" class="inputtext" id="textbox" name="order_num" readonly>
                            <button type="button" class="button" id="up">＋</button>
                        </div>
                        <button type="button" class="button resetbtn" id="reset">リセット</button>
                        <input type="submit" name="sweets" value="確認へ" class="button-c">
                    </div>
                </div>
            </form>

            <?php
                if (empty($_SESSION["boolean_sweet"])){
                    $_SESSION["boolean_sweet"] = 0;
                } else if ($_SESSION["boolean_sweet"] == 1){
                    echo "「お菓子」・「味」・「個数」を全て選択してください";
                }
                $_SESSION["boolean_sweet"] = 0;

                echo "<div class=login_user>".$_SESSION["user_name"]."としてログイン中</div>";
            ?>
        </main>
        <script src="../JavaScript/count.js"></script>
    </body>
</html>
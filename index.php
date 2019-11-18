<?php
    require_once "confi.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CVRR_BOOKSTORE</title>
    <link rel="stylesheet" href="bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <style type="text/css">
    body{
        background-image:linear-gradient(brown,violet);
    }
    #header{
        text-align: center;
    }
        .container {
            margin-top: 105px;

        }

        .card {
            width: 250px;
            background-color: #1AFD65;
        }

        .card:hover {
            transform: scale(1.05);
            transition: all .4s ease-in-out;
        }
        .card-title{
            font-style: "Comic Sans MS", cursive, sans-serif;
            color: #9E0BFB;  

        }

        .list-group-item {
            border: 0px;
            padding: 2px;
            cursor: pointer;
        }

        .price {
            font-size: 70px;
        }

        .currency {
            position: relative;
            font-size: 27px;
            top: -41px;
        }
    </style>
</head>
<body>
    <h5 style="color: red;">CVRROCKET</h5>
    <h1 id=header>CVRR_BOOKSTORE</h1>
<div class="container">
    <?php
        $colNum = 1;
        foreach ($products as $productID => $attributes) {
            if ($colNum == 1)
                echo '<div class="row">';

            echo '
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header text-center">
                            <h2 class="price"><span class="currency">$</span>'.($attributes['price']/100).'</h2>
                        </div>

                        <div class="card-body text-center">
                            <div class="card-title">
                                <h2>'.$attributes['title'].'</h2>
                            </div>
                            <ul class="list-group">
                            ';


                            foreach($attributes['features'] as $feature)
                                echo '<li class="list-group-item">'.$feature.'</li>';

                        echo '
                            </ul>
                            <br>
                            <form action="ipn.php?id='.$productID.'" method="POST">
                              <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="'.$stripeDetails['publishableKey'].'"
                                data-amount="'.$attributes['price'].'"
                                data-name="'.$attributes['title'].'"
                                data-description="CVRR_BOOKSTORE"
                                data-image="logo.png"
                                data-locale="auto">
                              </script>
                            </form>
                        </div>
                    </div>
                </div>
            ';

            if ($colNum == 4) {
                echo '</div><br>';
                $colNum = 0;
            } else
                $colNum++;
        }
    ?>
</div>
</body>
</html>
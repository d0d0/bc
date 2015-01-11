<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bakalárska práca</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </head>
    <body class="container">
        <h1 style="text-align: center">Vývojové prostredie pre online programovanie v skupine</h1>
        <div class="row">
            <div class="col-md-2">
                <ul class="nav nav-pills nav-stacked" style="text-align: center">
                    <li class="active"><a href="index.php">Domov</a></li>
                    <li><a href="diary.php">Denník</a></li>
                    <li><a href="sources.php">Zdroje</a></li>
                    <li><a href="plan.php">Ćasový plán práce</a></li>
                    <li><a href="screenshot.php">Screenshoty</a></li>
                    <li><a href="http://62.169.176.249/bc" data-toggle="tooltip" data-placement="bottom" title="Meno do aplikácie je admin@admin.com a heslo 123456. Budem rád za každý bug report na githube!">Demo</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                <dl class="dl-horizontal">
                    <p class="lead">
                    <dt>Autor:</dt>
                    <dd>Jozef Dúc</dd>
                    </p>
                    <p class="lead">
                    <dt>Názov práce:</dt>
                    <dd>Vývojové prostredie pre online programovanie v skupine</dd> 
                    </p>
                    <p class="lead">
                    <dt>Školiteľ:</dt>
                    <dd>Ing. František Gyárfáš, PhD.</dd>
                    </p>
                    <p class="lead">
                    <dt>Zadanie:</dt>
                    <dd>Cieľom bakalárskej práce je vytvoriť vývojové prostredie na skupinové programovanie ako webovú aplikáciu. Prostredie bude umožňovať interaktívne online programovanie pre skupiny študentov. Bude obsahovať možnosť zdieľaného editovania zdrojového kódu, zbiehanie programov, skupinový chat, štatistiky. Správnosť kódu sa bude dať overiť pomocou metodológie Test-driven development. Súčasťou bude administratívne rozhranie pre zadávateľa úloh. Systém bude realizovaný pomocou technológií/nástrojov: php framework (Laravel), MySQL, JavaScript (jQuery), html.</dd>
                    </p>
                </dl>
            </div>
        </div>
        <div class="footer navbar-fixed-bottom" style="background-color: white;">
            <div class="container">
                <ul class="list-inline">
                    <li class="muted">
                        Vytvoril <a href="mailto:duc4@uniba.sk">Jozef Dúc</a>.
                    </li>
                    <li>
                        <iframe class="github-btn" src="http://ghbtns.com/github-btn.html?user=D0d0&amp;repo=bc&amp;type=watch&amp;count=true" allowtransparency="true" frameborder="0" scrolling="0" width="100px" height="20px"></iframe>
                    </li>
                    <li>
                        <iframe class="github-btn" src="http://ghbtns.com/github-btn.html?user=D0d0&amp;repo=bc&amp;type=fork&amp;count=true" allowtransparency="true" frameborder="0" scrolling="0" width="102px" height="20px"></iframe>
                    </li>
                </ul>
            </div>
        </div>
    </body>
</html>
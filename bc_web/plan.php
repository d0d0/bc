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
                    <li><a href="index.php">Domov</a></li>
                    <li><a href="diary.php">Denník</a></li>
                    <li><a href="sources.php">Zdroje</a></li>
                    <li class="active"><a href="plan.php">Časový plán práce</a></li>
                    <li><a href="screenshot.php">Screenshoty</a></li>
                    <li><a href="http://62.169.176.249/bc" data-toggle="tooltip" data-placement="bottom" title="Meno do aplikácie je admin@admin.com a heslo 123456. Budem rád za každý bug report na githube!">Demo</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="thumbnail">
                    <h3>December 2014 / Január 2015</h3>
                    Dokončenie základného editoru pre viac dokumentov
                </div>
                <div class="thumbnail">
                    <h3>Február 2015</h3>
                    Začiatie prác na unit testoch
                </div>
                <div class="thumbnail">
                    <h3>Marec 2015</h3>
                    Dokončenie unit testov a zbehnutý prvý test
                </div>
                <div class="thumbnail">
                    <h3>Marec 2015</h3>
                    Začiatie práce na texte práce
                </div>
                <div class="thumbnail">
                    <h3>Máj 2015</h3>
                    Dokončenie aplikácie a textu
                </div>
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
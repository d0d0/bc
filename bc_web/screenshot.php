<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bakalárska práca</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
        <link href="css/bootstrap-image-gallery.min.css" rel="stylesheet">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
        <script src="js/bootstrap-image-gallery.min.js"></script>
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
                    <li><a href="plan.php">Časový plán práce</a></li>
                    <li class="active"><a href="screenshot.php">Screenshoty</a></li>
                    <li><a href="http://46.229.238.230/bc" data-toggle="tooltip" data-placement="bottom" title="Meno do aplikácie je admin@admin.com a heslo 123456. Budem rád za každý bug report na githube!">Demo</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                </ul>
            </div>
            <div class="col-md-9" style="margin-bottom: 3em">
                <div id="blueimp-gallery" class="blueimp-gallery">
                    <!-- The container for the modal slides -->
                    <div class="slides"></div>
                    <!-- Controls for the borderless lightbox -->
                    <h3 class="title"></h3>
                    <a class="prev">‹</a>
                    <a class="next">›</a>
                    <a class="close">×</a>
                    <a class="play-pause"></a>
                    <ol class="indicator"></ol>
                    <!-- The modal dialog, which will be used to wrap the lightbox content -->
                    <div class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"></h4>
                                </div>
                                <div class="modal-body next"></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left prev">
                                        <i class="glyphicon glyphicon-chevron-left"></i>
                                        Predchádzajúca
                                    </button>
                                    <button type="button" class="btn btn-primary next">
                                        Ďalej
                                        <i class="glyphicon glyphicon-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="links">
                    <?php
                    $titles = array(
                        'Prihlasovanie do aplikácie',
                        'Zobrazenie výsledného riešenia po deadline',
                        'Učiteľské rozhranie pre vytvorenie predmetu',
                        'Výber z predmetov, ktoré učiteľ vedie alebo žiak je na ne prihlásený',
                        'Rozhranie pre vytvorenie zadania',
                        'Všetky zadania z predmetu',
                        'Zobrazenie prihlásenia žiaka k riešeniu zadania',
                        'Vytváranie súboru k zadaniu',
                        'Vytvorený súbor, zobrazenie odhlásenia žiaka z riešenia',
                        'Synchrónne riešenie zadania',
                        'Synchrónne riešenie zadania, kde má druhý žiak iný súbor',
                        'Zobrazenie súborov, ktoré boli odstránené a sú dostupné na obnovenie',
                        'Shoutbox',
                        'Pripravená funkcionalita na vypnutie editorov',
                    );
                    for ($i = 1; $i < 15; $i++) {
                        ?>
                        <a href="images/ss/pic (<?php echo $i ?>).png" title="<?php echo $titles[$i-1]?>" data-gallery>
                            <img src="images/ss/thumbnail/pic (<?php echo $i ?>).png" alt="<?php echo $titles[$i-1]?>">
                        </a>
                        <?php
                    }
                    ?>
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
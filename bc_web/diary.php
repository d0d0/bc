<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bakalárska práca</title>
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
                    <li class="active"><a href="diary.php">Denník</a></li>
                    <li><a href="sources.php">Zdroje</a></li>
                    <li><a href="plan.php">Časový plán práce</a></li>
                    <li><a href="screenshot.php">Screenshoty</a></li>
                    <li><a href="http://46.229.238.230/bc" data-toggle="tooltip" data-placement="bottom" title="Meno do aplikácie je admin@admin.com a heslo 123456. Budem rád za každý bug report na githube!">Demo</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                </ul>
            </div>
            <div class="col-md-9" style="margin-bottom: 2em">
                <div class="thumbnail">
                    <h3>Písanie textu</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 9.4.2015 - 15.4.2015</p>
                    <p>Napísal som takmer celú kapitolu Implementácia (ešte chýba časť o Virtuálnom serveri), pokročil som v kapitole Návrh a vo východiskovej kapitole mi ešte chýbajú dokončiť sekcie o E-learningu a malá časť z použitých technológii.</p>
                </div>
                <div class="thumbnail">
                    <h3>Písanie textu</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 25.3.2015 - 8.4.2015</p>
                    <p>Začal som pracovať na texte, spísal som si kostru kapitoly Návrh.</p>
                </div>
                <div class="thumbnail">
                    <h3>Programovanie a testovanie</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 23.3.2015 - 24.3.2015</p>
                    <p>Dokončil som celú aplikáciu a otestoval som ju na hodine Extrémneho programovania. Žiaci našli zopár minor bugov, ktoré som opravil na mieste. Požiadal som všetkých, ktorí testovali aplikáciu, aby vyplnili krátku anketu. Podľa ohlasov je možné, že ešte niektoré časti budem trochu upravovať, aby boli viac user-friendly.</p>
                </div>
                <div class="thumbnail">
                    <h3>Programovanie</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 12.3.2015 - 19.3.2015</p>
                    <p>Predpripravil som si skripty na vytvorenie virtálneho stroja, na ktorom budú bežať skompilované programy kvôli bezpečnosti. Doprogramoval som všetku prácu so skupinou.</p>
                </div>
                <div class="thumbnail">
                    <h3>Programovanie</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 7.3.2015 - 11.3.2015</p>
                    <p>Doprogramoval som kľúčové časti aplikácie- vytváranie zadaní vrátane unit testov, kompilácia riešenia, spúšťanie riešenia a zmigroval ju nový, rýchlejší server. Zároveň som sa stretol so školiteľom a dohodli sme sa, že aplikáciu odtestujeme v reálnej prevádzke 24.3. na hodine extrémneho programovania a toto by mal konečný termín, do ktorého bude aplikácia v hotovom stave.</p>
                </div>
                <div class="thumbnail">
                    <h3>Písanie textu</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 3.3.2015</p>
                    <p>Začal som písať text k bc. Pred minulotýždňovým stretnutím so školiteľom som si pripravil zopár kľúčových fráz, ktoré by mohli tvoriť kapitoly a podkapitoly. So školiteľom sme ich prebrali vylúčili sme tie, ktoré boli veľmi všeobecné a naopak popridávali sme nové, ktoré sa viac hodia a sú zaujímavejšie. Zároveň som sa rozhodol, že do najbližšieho stretnutia budem mať hotovú takmer celú aplikáciu, aby som mohol navrhnúť školiteľovi na odskúšanie reálne na jeho predmete.</p>
                </div>
                <div class="thumbnail">
                    <h3>Programovanie</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 29.1.2015</p>
                    <p>Dokončená práca na kompilovaní a vypisovaní výsledkov testov. V ďalšej časti treba vytvoriť zadávanie testov a preniesť funkcionalitu testovania na virtuálny stroj pre zabezpečenie servera.</p>
                </div>
                <div class="thumbnail">
                    <h3>Programovanie</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 29.1.2015</p>
                    <p>Spustenie testu online z php a vypísanie jeho naformátovaných výsledkov. V ďalšej fáze bude skompilovanie programu z php. Keďže skripty už mám pripravené, tak by to nemalo byť náročné.</p>
                </div>
                <div class="thumbnail">
                    <h3>Programovanie</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 27.1.2015</p>
                    <p>Vybral som si vhodný framework na UnitTesty (gtest) a podarilo sa mi skompilovať a odchytiť výsledky z prvého testu cez konzolu.</p>
                </div>
                <div class="thumbnail">
                    <h3>Programovanie</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 8.1.2015</p>
                    <p>Dokončil som prácu na všetkých synchrónnych veciach- editor, shoutbox. Spravil som rozhranie, ktoré umožní ďalšie veľmi ľahké pridávanie častí aplikácie, ktoré majú byť synchrónne medzi užívateľmi.</p>
                </div>
                <div class="thumbnail">
                    <h3>Programovanie</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 6.1.2015 - 7.1.2015</p>
                    <p>Vytvoril som aplikáciu, rozbehal server, sfunkčnil redis databázu, vytvoril funkcionalitu pre viac editorov naraz, skompiloval .cpp súbor cez php.</p>
                </div>
                <div class="thumbnail">
                    <h3>Aktualizovanie stránky</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 11.12.2014</p>
                    <p>Doplnil som zdroj o mená resp. oragnizácie a pridal odkaz na demo aplikácie.</p>
                </div>
                <div class="thumbnail">
                    <h3>Stretnutie so školiteľom</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 3.12.2014</p>
                    <p>Školiteľovi som predviedol funkčnú časť aplikácie. Dohodli sme sa na ďalšom postupe, že do ďalšieho stretnutia (pravdepodobne niekedy začiatkom januára) dokončím editor pre viac dokumentov naraz. Odporučil mi, že najskôr mám dokončiť aplikáciu a až potom písať text.</p>
                </div>
                <div class="thumbnail">
                    <h3>Prezentácia na Bakalársky seminár</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 26.11.2014</p>
                    <p>Vytvorené prezentácia na bakalársky seminár.</p>
                </div>
                <div class="thumbnail">
                    <h3>Naprogramovanie základného editora</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 15.11.2014</p>
                    <p>Naprogramovaný základný online editor.</p>
                </div>
                <div class="thumbnail">
                    <h3>Vyvorenie webovej stránky</h3>
                    <p class="text-muted"><span class="glyphicon glyphicon-calendar"></span> 26.10.2014</p>
                    <p>Vytvoril som základný layout pre web na bakalársku prácu.</p>
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
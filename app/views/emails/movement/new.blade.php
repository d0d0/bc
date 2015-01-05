<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
            Bol pridaný nový obrat na váš účet. Suma obratu je {{ $price }}. Nový zostatok na účte je {{ round($amount, 2) }}.
        </div>
        <div style="color:#777;">
            Správa bola automaticky vygenerovaná zo systému {{ date('d.m.Y H:i:s') }}
        </div>
    </body>
</html>
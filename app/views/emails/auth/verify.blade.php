<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Overenie mailu</h2>

        <div>
            Ďakujeme za vytvorenie účtu.
            Kliknutím na nasledujúci link si aktivujete svoj účet
            {{ action('RegistrationController@confirm', [$confirmation_code]) }}.<br/>
        </div>

    </body>
</html>
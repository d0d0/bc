<?php

Form::macro('errorMsg', function($field) {
    $errors = Session::get('errors');
    if ($errors->has($field)) {
        $msg = $errors->first($field);
        return "<p class=\"help-block\" style=\"margin-bottom: 0px\">$msg</p>";
    }
    return '';
});

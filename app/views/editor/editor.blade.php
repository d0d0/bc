@extends('layouts.center_content')

@section('style')
#editor{
    height: 300px;
}
@stop

@section('center')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Editor</h3>
    </div>
    <div class="panel-body">
        <div id="editor"></div>
    </div>
</div>
<script src="js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="js/ace/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>
<script src="js/bcsocket-uncompressed.js"></script>
<script src="js/share.uncompressed.js"></script>
<script src="js/ace_c.js"></script>
<script>
    var randomDocName = function (length) {
        var chars, x;
        if (length == null) {
            length = 32;
        }
        chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=";
        var name = [];
        for (x = 0; x < length; x++) {
            name.push(chars[Math.floor(Math.random() * chars.length)]);
        }
        return name.join('');
    };

    var editor = ace.edit("editor");
    editor.$blockScrolling = Infinity;
    editor.setOptions({
        enableBasicAutocompletion: true
    });

    editor.setTheme("ace/theme/twilight");
    editor.getSession().setMode("ace/mode/javascript");
    var docName = null;
    if (document.location.hash) {
        docName = "code:" + document.location.hash.slice(1);
    } else {
        docName = "code:" + randomDocName();
    }
    console.log(docName);
    sharejs.open(docName, 'text', 'http://62.169.176.249:8000/channel', function (error, doc) {
        doc.attach_ace(editor);
    });
</script>
@stop
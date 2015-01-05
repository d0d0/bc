<!DOCTYPE HTML>
<html>
    <head>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <title>Hello World</title>
    </head>

    <body>
        <div id="header">
            <div id="htext">
                Editing <b>hello</b></input>
            </div>
        </div>

        <div id="editor"></div>

        <script src="js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/ace/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/bcsocket-uncompressed.js"></script>
        <script src="js/share.uncompressed.js"></script>
        <script src="js/ace_c.js"></script>
        <script>
            var randomDocName = function (length) {
                var chars, x;
                if (length == null) {
                    length = 10;
                }
                chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=";
                var name = [];
                for (x = 0; x < length; x++) {
                    name.push(chars[Math.floor(Math.random() * chars.length)]);
                }
                return name.join('');
            };

            var editor = ace.edit("editor");
            editor.setOptions({
                enableBasicAutocompletion: true
            });

            editor.setTheme("ace/theme/twilight");
            editor.getSession().setMode("ace/mode/c_cpp");
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
    </body>
</html>	


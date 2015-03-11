{{ File::get($path . '/test.html') }}
.Info o kompilátore
{{ shell_exec('g++ --version') }}
@if (File::exists($path))
    <?php File::delete($path); ?>
@endif
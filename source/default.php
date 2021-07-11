<?php
    global $title;
    global $description;
    global $content;
    ob_start();
?>
{title='404'}

<div class="container all-center">
    <h1>{title}</h1>
    <p class="mt-3"><a class="btn btn-primary" href="/">Home</a></p>
</div>

{content = ob_get_clean()}
{{layouts/main}}
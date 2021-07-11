<?php
    global $title;
    global $description;
    global $content;
    ob_start();
?>
{title='index'}
{description=''}

<div class="container">
    <div class="container-page">
        <h1>{title}</h1>
        <p>Home page</p>
    </div>
</div>

{content = ob_get_clean()}
{{layouts/main}}
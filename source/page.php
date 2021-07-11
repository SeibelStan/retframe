<?php
    global $title;
    global $description;
    global $content;
    ob_start();
?>
{title='page'}
{description=''}

<div class="container">
    <div class="container-page">
        <h1>{title}</h1>
        <?php render("content/pages/page.md") ?>
    </div>
</div>

{content = ob_get_clean()}
{{layouts/main}}
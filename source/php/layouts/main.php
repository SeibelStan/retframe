<?php
    global $title;
    global $image;
    global $description;
    global $content;
?>
<!DOCTYPE html>
<html lang="ru" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
    <link rel="icon" type="image/svg" href="/assets/logo.svg">    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="/assets/custom.css" rel="stylesheet">
    
    <meta property="og:type" content="website">

    @if $description
    <meta name="og:description" content="{description}">
    <meta name="description" content="{description}">
    @eif
    @if $image
    <meta property="og:image" content="<?= DOMAIN ?>/content/images/{image}">
    @eif

    <meta property="og:title" content="{title}">
    <title>{title} &mdash; {SITENAME}</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-border">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <span>{SITENAME}</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="/catalog">Catalog</a></li>
                        <li class="nav-item"><a class="nav-link" href="/page">Page</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <script>
            document.querySelector('[href="' + location.pathname + '"]').classList.add('active');
        </script>
    </header>

    <main class="pt-5">
        {content}
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
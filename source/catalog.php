<?php
    if ($_GET['i'] ?? '') {
        render('source/catalog-item.php');
        die();
    }

    global $title;
    global $image;
    global $description;
    global $content;
    ob_start();

    $catalog = json_decode(file_get_contents('content/-catalog.json'));
?>
{title='Catalog'}
{description=''}
{image=$catalog ? 'catalog/' . $catalog[0]->images[0] : ''}

<div class="container">

<div class="row">
    <div class="col">
        <div class="row">
            @foreach $catalog as $unit
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a class="card" href="/catalog?i={unit->slug}">
                    <img src="/content/images/catalog/{unit->images[0]}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{unit->title}</h5>
                        <div class="description">{unit->description}</div>
                        <div class="price">{unit->price} $</div>
                    </div>
                </a>
            </div>
            @eforeach
        </div>
    </div>
</div>

</div>

{content = ob_get_clean()}
{{layouts/main}}
<?php
    $catalog = json_decode(file_get_contents('content/-catalog.json'));
    $item = false;
    foreach ($catalog as $unit) {
        if (($_GET['i'] ?? '') == $unit->slug) {
            $item = $unit;
            break;
        }
    }
    if (!$item) {
        render('source/default.php');
        die();
    }

    global $title;
    global $image;
    global $description;
    global $content;
    ob_start();
?>
{title=$item->title}
{image='catalog/' . $item->images[0]}
{description=$item->description}

<div class="container">

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/catalog">Catalog</a></li>
        <li class="breadcrumb-item active" aria-current="page">{title}</li>
    </ol>
</nav>

<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div id="carouselExampleControls" class="carousel slide carousel-controls-dark" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach $item->images as $i => $unit
                    <div class="carousel-item <?= $i ? '' : 'active' ?>">
                        <img src="/content/images/catalog/{unit}" class="item-image d-block w-100 pointer" onclick="modalImg('/content/images/catalog/{unit}')">
                    </div>
                @eforeach
            </div>
            @if count($item->images) > 1
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="bi-chevron-left" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="bi-chevron-right" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @eif
        </div>
    </div>

    <div class="col-lg-8 col-md-6 col-sm-12">
        <h1>{item->title}</h1>
        <div>{item->description}</a></div>
        <table class="mt-3">
            <tr><td>Price<td class="text-end"><span class="price">{item->price}</span> $
        </table>
        <div class="container-page mt-3">
            <?php render("content/catalog/$item->slug.md") ?>
        </div>
    </div>
</div>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" data-bs-dismiss="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{item->title}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" style="width: 100vmin; height: calc(100vmin - 56px); object-fit: cover;">
            </div>
        </div>
    </div>
</div>

<script>
    function modalImg(src) {
        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'))

        document.querySelector('#exampleModal img').src = src;
        myModal.show();
    }
</script>

{content = ob_get_clean()}
{{layouts/main}}
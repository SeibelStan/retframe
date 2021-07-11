<?php

define('ROOT', '/');
define('DOMAIN', 'https://site.domain');
define('SITENAME', 'Site Name');

function render($rp) {

    $frp = preg_replace('/^(source)\//', '', $rp);

    if (preg_match('/\.md$/', $frp)) {
        $c = markdown($rp);
    }
    elseif (preg_match('/\.txt$/', $frp)) {
        $c = text($rp);
    }
    else {
        $c = preproc($rp);
    }

    if ($dump = 0) {
        header('Content-type: text/plain');
        echo $c;
        die();
    }

    if (!file_exists('temp')) { mkdir('temp'); }

    $trp = preg_replace('/\//', '.', $frp);
    $f = fopen("temp/$trp", 'w+');
    fwrite($f, $c);
    
    require("temp/$trp");
}

function preproc($rp) {
    $c = file_get_contents($rp);

    $c = preg_replace('/\{\{(.+?\.php)\}\}/', "<?php require('source/php/$1') ?>", $c);
    $c = preg_replace('/\{\{(.+?\.md)\}\}/', "<?php render('source/md/$1') ?>", $c);
    $c = preg_replace('/\{\{(.+?\.txt)\}\}/', "<?php render('source/txt/$1') ?>", $c);
    $c = preg_replace('/\{\{(.+?)\}\}/', "<?php render('source/php/$1.php') ?>", $c);
    $c = preg_replace('/@elseif (.+)/', "<?php elseif ($1) : ?>", $c);
    $c = preg_replace('/@else/', "<?php else : ?>", $c);
    $c = preg_replace('/@e(\w+)(.+)/', "<?php end$1; ?>", $c);
    $c = preg_replace('/@([a-z].+?) (.+)/', "<?php $1 ($2) : ?>", $c);
    $c = preg_replace('/\{([A-Z][A-z0-9_]*?)\}/', "<?= $1 ?>", $c);
    $c = preg_replace('/\{([a-z][^=]*?)\}/', "<?= \$$1 ?>", $c);
    $c = preg_replace('/\{(.+?)=(.+?)\}/', "<?php \$$1=$2; ?>", $c);
    return $c;
}

function markdown($rp) {
    $c = file_get_contents($rp);

    $c = preg_replace('/^###### (.+?)(\s*)$/m', '<h6>$1</h6>$2', $c);
    $c = preg_replace('/^##### (.+?)(\s*)$/m', '<h5>$1</h5>$2', $c);
    $c = preg_replace('/^#### (.+?)(\s*)$/m', '<h4>$1</h4>$2', $c);
    $c = preg_replace('/^### (.+?)(\s*)$/m', '<h3>$1</h3>$2', $c);
    $c = preg_replace('/^## (.+?)(\s*)$/m', '<h2>$1</h2>$2', $c);
    $c = preg_replace('/^# (.+?)(\s*)$/m', '<h1>$1</h1>$2', $c);
    
    $c = preg_replace("/^>+ (.+?)(\s*)$/m", '<blockquote>$1</blockquote>$2', $c);

    $c = preg_replace('/!\[(.+?):(\d+)\]\((.+?)\)/', '<img alt="$1" width="$2" src="$3">', $c);
    $c = preg_replace('/!\[(.+?)\]\((.+?)\)/', '<img alt="$1" src="$2">', $c);
    $c = preg_replace('/\[(.+?)\]\((.+?)\)/', '<a href="$2">$1</a>', $c);

    $c = preg_replace('/\*\*(\S.*?\S*)\*\*/', '<strong>$1</strong>', $c);
    $c = preg_replace('/\*(\S.*?\S*?)\*/', '<em>$1</em>', $c);
    $c = preg_replace('/--(\S.*?\S*?)--/', '<span style="text-decoration: line-through">$1</span>', $c);
    $c = preg_replace('/-(\S+)-/', '<span style="text-decoration: line-through">$1</span>', $c);

    $c = preg_replace("/^[*+-] (.+?)(\s*)$/m", '<dli>$1</dli>$2', $c);
    $c = preg_replace("/(^|\s{3,})<dli/", "$1<ul>\n<dli", $c);
    $c = preg_replace("/dli>(\s{3,})/m", "dli>\n</ul>$1", $c);
    $c = preg_replace("/(dli>)/", "li>", $c);

    $c = preg_replace("/^\d+\. (.+?)(\s*)$/m", '<dli>$1</dli>$2', $c);
    $c = preg_replace("/(^|\s{3,})<dli/", "$1<ol>\n<dli", $c);
    $c = preg_replace("/dli>(\s{3,})/m", "dli>\n</ol>$1", $c);
    $c = preg_replace("/(dli>)/", "li>", $c);
    
    $t = preg_match_all("/```([\s\S]+?)```/m", $c, $matches);
    if ($matches) {
        foreach ($matches[1] as $m) {
            $m = trim($m);
            $m = preg_replace('/ /', '&nbsp;', $m);
            $m = preg_replace('/\n/', '<br>', $m);
            $c = preg_replace("/```([\s\S]+?)```/m", "```$m```", $c, 1);
        }
    }

    $c = preg_replace("/```([\s\S]+?)```/m", '<code>$1</code>$2', $c);
    $c = preg_replace("/`(.+?)`/", '<code>$1</code>$2', $c);
    
    $c = preg_replace("/^(<img |<a |<span|<strong|<em)*([^<\s].*?)(\s*)$/m", '<p>$1$2</p>$3', $c);
    return $c;
}

function text($rp) {
    $c = file_get_contents($rp);
    $c = nl2br($c);
    return $c;
}

function rm($dir) {
    if (!file_exists($dir)) {
        return false;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($iterator as $path) {
        if ($path->isDir()) {
            @rmdir($path);
        }
        else {
            unlink($path);
        }
    }
    rmdir($dir);
}

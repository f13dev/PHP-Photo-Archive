<?php

$path = realpath('../archive/images');

$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $name => $object){
    echo ".." . strstr($name, '/archive/') . "<br />";
    echo str_replace('/archive/', '/thumbs/', strstr($name, '/archive/')) . '<br />';
}

?>

<?php

include 'securimage.php';

$img = new securimage();


$img->ttf_file = "images/arialbd.ttf";
$img->draw_lines	= false;
$img->text_color	= "#FFFFFF";

$img->show('./images/code_back.jpg'); // alternate use:  $img->show('/path/to/background.jpg');

?>
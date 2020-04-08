<?php
$noticia = $_POST['noticia'];
$substituir = array("á","é",'í',"ó","ú","ç","ã","ô"," ");
$por = array("a","e",'i',"o","u","c","a","o","-");
echo strtolower(str_replace($substituir,$por, $noticia));
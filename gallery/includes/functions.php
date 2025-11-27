<?php

function h($s) {
return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function human_filesize($bytes, $decimals = 2) {
$sz = ['B','KB','MB','GB','TB'];
$factor = floor((strlen($bytes) - 1) / 3);
if ($factor == 0) return $bytes . ' ' . $sz[0];
return sprintf("%.*f %s", $decimals, $bytes / pow(1024, $factor), $sz[$factor]);
}
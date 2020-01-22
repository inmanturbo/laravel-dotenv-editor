<?php
$data =  file_get_contents(__DIR__ . '/setup.stub');
$vars = [];

$data = explode("\n", $data);
foreach ($data as &$row) {
    $row = explode('=', $row);
    $vars = array_merge($vars, [$row[0] => trim($row[1], '"')]);
}


return array_filter($vars);

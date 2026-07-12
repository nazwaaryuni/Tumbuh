<?php
$bendahara = App\Models\User::where('name', 'Bendahara Umum')->first();
$ketua = App\Models\User::where('name', 'Ketua Umum')->first();

echo 'Bendahara view-dues: ' . ($bendahara->can('view-dues') ? 'true' : 'false') . PHP_EOL;
echo 'Bendahara manage-dues: ' . ($bendahara->can('manage-dues') ? 'true' : 'false') . PHP_EOL;
echo 'Ketua view-dues: ' . ($ketua->can('view-dues') ? 'true' : 'false') . PHP_EOL;
echo 'Ketua manage-dues: ' . ($ketua->can('manage-dues') ? 'true' : 'false') . PHP_EOL;

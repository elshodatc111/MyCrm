<?php
use Carbon\Carbon;
$today = Carbon::today();
$numberOfBirthdaysToday = DB::table('users')
    ->where('filial',request()->cookie('filial_id'))
    ->whereRaw("DATE_FORMAT(tkun, '%m-%d') = ?", [$today->format('m-d')])->count();
echo $numberOfBirthdaysToday;
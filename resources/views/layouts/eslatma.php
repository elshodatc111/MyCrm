<?php
$Eslatmalar = count(DB::table('eslatmas')->where('filial_id',request()->cookie('filial_id'))->where('status','true')->get());
echo $Eslatmalar;

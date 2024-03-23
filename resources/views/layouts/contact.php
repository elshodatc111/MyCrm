<?php

$Contact = count(DB::table('contacts')
->where('filial_id',request()->cookie('filial_id'))
->where('status','user')
->where('admin_type','false')->get());
echo $Contact;

?>
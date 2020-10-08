<?php

function rupiah($data){
    return 'Rp '.number_format($data,0,',','.');
}

function dateIndo($data){
    return date('d-m-Y H:i',strtotime($data));
}
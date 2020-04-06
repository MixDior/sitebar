<?php

function update_profile(){
    if(!empty($_REQUEST)){
        $data=$_REQUEST;
        $data=json_encode($data);
        echo $data;
        //убили скрипт
        die();
    }
}
//Если в action содержиться функция, то функция выполняется
function ajax_request(){
    if(!empty($_REQUEST['action']) && function_exists($_REQUEST['action'])){

        $_REQUEST['action']();
    }
}

<?php

function send_json_succes($data){
    $data=json_encode(array(
        'success'=>true,
        'data'=>$data,
    ));
}

function send_json_error($data){
    $data=json_encode(array(
        'success'=>false,
        'data'=>$data,
    ));

    echo $data;
    die();
}

function update_profile(){
    if(!empty($_REQUEST)){
        $data=$_REQUEST;
        $important = array('fio'=>'ФИО','email'=>'Email',);
        $error=array();
        foreach ($important as $key=>$value) {
            if(empty($data[$key])){
                $error[]='Поле '.$value.' должно быть заполнено!';
            }
        }
        if(!empty($error)){
            send_json_error($error);
        }

    }
}
//Если в action содержиться функция, то функция выполняется
function ajax_request(){
    if(!empty($_REQUEST['action']) && function_exists($_REQUEST['action'])){

        $_REQUEST['action']();
    }
    echo 0;
}

ajax_request();

<?php

include '../functions.php';

function send_json_success($data){
    $data=json_encode(array(
        'success'=>true,
        'data'=>$data,
    ));
}

function send_json_error($data=null){
    $data=json_encode(array(
        'success'=>false,
        'data'=>$data,
    ));

    echo $data;
    die();
}
//Обновление данных профиля
function update_profile(){
    if(!empty($_REQUEST)){
        $data=$_REQUEST;
        $fields = fields_profile();
        $error=array();
        $insert=array();
        $update=array();
        $matches=array();
        //Делаем перебор полей, определенных в спец массиве
        foreach ($fields as $key=>$value) {

            //Если поле является обязательным для заполнения добавляем информацию об этом в список ошибок
            if(!empty($value['required'])&&empty($data[$key])){
                $error[]='Поле "'.$value['label'].'" должно быть заполнено!';
            }

            //ищем в ключе все составляющие  (слова)
            preg_match_all('/([^\[\]]+)/i',$key,$match);
            //если ключ имеет менее 2-х составляющих
            if(1==sizeof($match[1])) {
                //указываем имя в таблице
                $table_name='users';
            }else{

                //указываем имя таблицы в соответствии с первой составляющей ключа
                $table_name=$match[1][0];
            }

            if(empty($insert[$table_name])){
                $insert[$table_name]=array();
            }
        //Если массивы с ключами и значениямидля добавления в БД не определен
            if (empty($insert[$table_name][0])){
                //Говорим что это массив
                $insert[$table_name][0]=array();
                $insert[$table_name][1]=array();
            };



            //добавляем найденные составляющие ключа в общий список (это для тестирования)
            $matches[]=$match;
        //если ключ имеет менее 2-х составляющих
            if(sizeof($match[1])<2) {
                //добавляем ключ в список ключей для отправки в БД (при создании записи)
                $insert[0][]=$key;

                //добавляем список значения в правильном формате
                if ('s' == $value['perform']) {
                    $insert[$table_name][1][] = "'" . $data[$key] . "'";
                    $update[]=$key."='".$data[$key]."'";
                } else {
                    $insert[$table_name][1][] = $data[$key];
                    $update[]=$key."=".$data[$key];
                }

            }
        }

        //если в процессе возникли ошибки
        if(!empty($error)){

            //отправляем список ошибок и флаг success; false
            send_json_error($error);
        }else{
            //запрос есть ли запись в бд
            //проверяем на существование хоть какой-то записи в указанной таблице
            $result=do_query('SELECT COUNT(*) FROM users');

            //если записи не найдено
            if (empty($result)){

                //преобразовываем ключи и значения в строки
                $insert[$table_name][0]=implode(', ',$insert[$table_name][0]);
                $insert[$table_name][1]=implode(', ',$insert[$table_name][1]);

                //составляем запрос
                $query[$table_name]='INSERT INTO users( '.$insert[$table_name][0].') VALUES('.$insert[$table_name][1].')';

                //выполняем запрос
                do_query($query[$table_name]);
            }else{
                $update[$table_name]=implode(', ',$update[$table_name]);
                $query[$table_name]='UPDATE users SET'.$update[$table_name];
            }
            send_json_succes ($query);
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

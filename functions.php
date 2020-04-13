<?php
/**  */
global $link;

define('SECRET','twretqrwetrqweytrqytre');
/**Функция для определения пароля
 * Если для нескольких пользователей, то переносим в БД. В БД храним именно ХЭШ 'md5($password.SECRET)'
 */
function is_admin(){
    $password='123';
    $hash=md5($password.SECRET);

    if((!empty($_REQUEST['pass']) && md5($_REQUEST['pass'].SECRET)==$hash)||(!empty($_COOKIE['hash'])) && $_COOKIE['hash']=$hash){

        setcookie('hash',md5($_REQUEST['pass']),time()+3600,'/');
        return true;
    }
    return false;

}


//Функция печати данных на экран
function pr( $data ) {
    echo '<pre>';
    print_r( $data );
    echo '</pre>';
}

function do_query( $query ) {
    global $link;
    $result = mysqli_query( $link, $query );


    if ( $error = mysqli_error( $link ) ) {
        return $error;
    }

    return $result;
}


/**perform  - ключ, который показывает на то, какой тип данных у данной переменной, чтобы правильно сохранить их в БД, варианты
 * d - целое число;
 * f - числа с точкой;
 * s - все остальное;
 */
function fields_profile(){
    $values=get_last_user_data();
    $values=array_merge($values, get_user_meta());

    $fields=array(
        'fio'=>array(
            'label'=>'ФИО',
            'perform'=>'s',
            'type'=>'text',
            'class'=>'form__control',
            'required'=>1,),
        'bio'=>array(
            'label'=>'Биография',
            'perform'=>'s',
            'type'=>'text',
            'class'=>'form__control',),
        'birthday'=>array(
            'label'=>'ДР',
            'perform'=>'s',
            'type'=>'datetime',
            'class'=>'form__control',),
        'email'=>array(
            'label'=>'Email',
            'perform'=>'s',
            'type'=>'text',
            'class'=>'form__control',
            'required'=>1,),
        'phone'=>array(
            'label'=>'Телефон',
            'perform'=>'s',
            'type'=>'text',
            'class'=>'form__control',),
        'usermeta[vk_link]'=>array(
            'label'=>'Ссылка VK',
            'perform'=>'s',
            'type'=>'text',
            'class'=>'form__control',),
    );
    foreach ($values as $key=>$value){
        if(!empty($fields[$key])){
            $fields[$key]['value']=$value;
        }
    }
    if (empty($fields['birthday'])||'0000-00-00'==$fields['birthday']['value']){
        $fields['birthday']['value']=date('Y-m-d');
    }
    return $fields;
}

function get_user(){

    $data = array(
        'fio'=>'Иванов Иван Иванович',
        'image'=>'<img src="assets/images/photo.bmp" alt="" class="bio__image">',
        'bio'=>'Затем я удалил ый свет, но не',
        'meta'=>array(
            'dob'=>1920,
            'address'=>'MOSCOW',
        'phone'=>'+7 (903) 111-11-22',
        'email'=>'m@ya.ru',
        'site'=>'m.ru',
        'vk_link'=>'https://vk.com/minita.ru',
        'vk_image'=>'',
        'fb_link'=>'https://facebook.com/minitaru',
    ),
    );
    return $data;
}

function get_resume(){
    $fields = array(
        array(
            'start'=>'2015-03-01',
            'end'=>'2015-12-01',
            'position'=>'Mehanik',
            'location'=>'Sizran',
            'description'=>'Работал в автосервисе'),
        array(
            'start'=>'2016-12-01',
            'end'=>'2016-03-01',
            'position'=>'Mehanik-электрик',
            'location'=>'Саратов',
            'description'=>'Выкручивал'),
        array(
            'start'=>'2016-04-01',
            'end'=>'0000-00-00',
            'position'=>'Mehanik',
            'location'=>'Москва',
            'description'=>'Ничего не делал'),
    );
    return $fields;
}


/**
 * Получение последней редакции данных пользователя
 *
 * @return array
 */
function get_last_user_data() {
    $query  = 'SELECT * FROM `users` ORDER BY id DESC LIMIT 1';
    $result = do_query( $query );
    $result = $result->fetch_assoc();

    if ( empty( $result ) ) {
        $result = array();
    }

    return $result;
}

function get_user_meta(){
    $query  = 'SELECT * FROM `usermeta`';
    $result = do_query( $query );
    $response=array();
    while ($row=$result->fetch_assoc()){
        if (!empty($row)){
            $key='usermeta['.$row['key'].']';
            $response[]=$row['value'];
        }
    }

    return $response;
}



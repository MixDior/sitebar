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

    if((!empty($_REQUEST['pass']) && md5($_REQUEST['pass'].SECRET)==$hash)||(!empty($_COOKIE['hash']) && md5($_COOKIE['hash'].SECRET)==$hash)){

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

function get_form() {
    if ( ! empty( $_GET['form'] ) ) {
        ob_start();
        if ( is_admin() ) {
            $function_name = 'fields_' . $_GET['form'];
            $fields = $function_name();
            $out = show_fields( $fields );

            include 'templates/form-' . $_GET['form'] . '.php';

        } else {
            include 'templates/auth.php';
        }

        return ob_get_clean();
    }

    return '';
}


/**
 * Формирование списка полей формы по заданным параметрам
 *
 * @param $fields
 *
 * @return array|string
 */
function show_fields( $fields ) {
    $out = array();
    foreach ( $fields as $key => $field ) {

        $value    = ! empty( $field['value'] ) ? $field['value'] : '';
        $required = ! empty( $field['required'] ) ? ' required="required"' : '';
        $html     = '';

        if ( 'hidden' != $field['type'] ) {
            $html .= '<div class="form__group">';
        }
        if ( ! empty( $field['label'] ) && 'hidden' != $field['type'] ) {
            $html .= '<label for="' . $key . '" class="form__label">' . $field['label'] . '</label>';
        }
        $html .= '<input id="' . $key . '" type="' . $field['type'] . '" class="form__control" name="' . $key . '" value="' . $value . '"' . $required . '>';

        if ( 'hidden' != $field['type'] ) {
            $html .= '</div>';
        }

        $out[] = $html;
    }
    $out = implode( "\n", $out );

    return $out;
}

function get_resume() {

    $where = '';
    if ( ! empty( $_REQUEST['id'] ) ) {
        $where = ' WHERE resume_id = ' . $_REQUEST['id'];
    }

    $query  = 'SELECT * FROM `resume`' . $where . ' ORDER BY end DESC, start DESC';
    $result = do_query( $query );

    $fields = array();
    while ( $row = $result->fetch_assoc() ) {
        $fields[] = $row;
    }


    return $fields;
}


function fields_resume() {

    /*$values = get_last_user_data();
    $values = array_merge( $values, get_user_meta() );*/

    $fields = array(
        'action'      => array(
            'value' => 'update_resume',
            'type'  => 'hidden',
        ),
        'resume_id'   => array(
            'perform' => 'd',
            'type'    => 'hidden',
        ),
        'start'       => array(
            'label'    => 'Дата начала работы',
            'perform'  => 's',
            'type'     => 'date',
            'class'    => 'form__controll',
            'required' => 1,
            'value'    => date( 'Y-m-d' ),
        ),
        'end'         => array(
            'label'    => 'Дата окончания работы',
            'perform'  => 's',
            'type'     => 'date',
            'class'    => 'form__controll',
            'required' => 1,
            'value'    => date( 'Y-m-d' ),
        ),
        'position'    => array(
            'label'   => 'Должность',
            'perform' => 's',
            'type'    => 'text',
            'class'   => 'form__controll',
        ),
        'location'    => array(
            'label'   => 'Расположение',
            'perform' => 's',
            'type'    => 'text',
            'class'   => 'form__controll',
        ),
        'description' => array(
            'label'   => 'Описание',
            'perform' => 's',
            'type'    => 'text',
            'class'   => 'form__controll',
        ),
    );

    /*foreach ( $values as $key => $value ) {
        if ( ! empty( $fields[ $key ] ) ) {
            $fields[ $key ]['value'] = $value;
        }
    }*/

    if ( empty( $fields['start']['value'] ) || '0000-00-00' == $fields['start']['value'] ) {
        $fields['start']['value'] = date( 'Y-m-d' );
    }

    return $fields;
}

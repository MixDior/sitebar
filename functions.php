<?php
/**  */
global $link;
function do_query($query){
    global $link;
    $result=mysqli_query($link,$query);

    if($error=mysqli_error($link)){
        print_r($error);
    }
    return $result;
}

/**perform  - ключ, который показывает на то, какой тип данных у данной переменной, чтобы правильно сохранить их в БД, варианты
 * d - целое число;
 * f - числа с точкой;
 * s - все остальное;
 */
function fields_profile(){
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
            'type'=>'datetime-local',
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


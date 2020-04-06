<?php
/**  */
function get_user(){

    $data = array(
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


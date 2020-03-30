<?php
/**  */
function get_user(){

    $data = array(
        'image'=>'<img src="assets/images/photo.ipg" alt="" class="bio__image">',
        'bio'=>'Затем я удалил PostgreSQL и сборку apache и попытался перезапустить MAMP. Он активировал базу данных MySQL (зеленый свет), но Apache не',
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

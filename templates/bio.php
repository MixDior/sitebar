<?php
$data = get_user();

$columns = array();
$fields = array(
    'dob'=>'Дата рождения',
    'address'=>'Адрес',
    'phone'=>'Телефон',
    'email'=>'Email',
    'site'=>'Сайт'
);
$meta = array();
foreach($fields as $key=>$value){
    if (!empty($data['meta'][$key])){
        $meta[] = '<div class="columns__label"></div>'.$value.'<div class="columns__value"></div>';
    }

}
?>

<div class="bio">
    <div class="bio__photo">
        <?php echo $data['photo'];?>
        <img src="assets/images/photo.ipg" alt="" class="bio__image">
    </div>
    <div class="bio__discription"><?php echo $data[''];?></div>
    <div class="bio__info">
        <?php echo $data[''];?>
        <div class="columns">
            <div class="columns__column">
                <div class="columns__label"></div>
            </div>
            <div class="columns__column">
                <div class="columns__value"></div>
            </div>
        </div>
    </div>
    <div class="bio__socials"></div>
</div>



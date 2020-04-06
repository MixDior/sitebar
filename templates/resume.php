<?php
$data = get_resume();

$columns = array();




$resume_rows = array();
foreach($data as $key=>$value){
    if (!empty($value['start'])){
        $period = date('m.Y',strtotime($value['start']));
        if('0000-00-00'!=$value['end']){
            $period.='_'.date('m,M',strtotime($value['end']));
        }
        else{
            $period.='- HB';
        }
        $resume_rows[] = '<div class="resume__row">'.'
        <div class="resume__period">'.$period.'</div>
        <div class="resume__position">'.$value['position'].'</div>
        <div class="resume__location">'.$value['location'].'</div>
        <div class="resume__description">'.$value['description'].'</div>'.'</div>';
    }

}
$resume = implode("\n", $resume_rows);
?>

<div class="resume">

        <?php echo $resume; ?>

</div>



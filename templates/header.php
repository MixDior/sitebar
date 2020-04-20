<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="assets/styles/style.css">
</head>
<body>
<div class="menu">
    <a href="javascript:" class="menu__burger">E</a>
<ul class="menu__list">
    <li class="menu__item"><a href="?form=profile" class="menu__link">Главная</a></li>
    <li class="menu__item"><a href="?form=resume" class="menu__link">Резюме</a></li>
    <li class="menu__item"><a href="#opt" class="menu__link">Опыт</a></li>
</ul>
</div>

<div class="container">
<?php echo get_form(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php css("vendor/grid.css")                       ?>"/>
    <link rel="stylesheet" href="<?php css("style.css")                             ?>"/>
    <link rel="stylesheet" href="<?php css("components/header.component.css")       ?>"/>
    <link rel="stylesheet" href="<?php css("components/placeholder.component.css")  ?>"/>
    <link rel="stylesheet" href="<?php css("components/form.component.css")         ?>"/>
    <link rel="stylesheet" href="<?php css("components/menu.component.css")         ?>"/>
    <link rel="stylesheet" href="<?php css("components/product.component.css")         ?>"/>
</head>
<body>
    
    <!-- BEM (BLOCK - ELEMENT - MODIFICATOR) -->
    <div id="component--header">
        
        <div class="row">
            <div class="col-xs-4">
                <div id="component--header-logo">
                    CMS WEB SHOP
                </div>
            </div>
            
            <div class="col-xs-8">
                <div id="component--menu">
                    
                    <?php if(src\client\models\UserModel::hasRoleUser()): ?>
                        <ul>
                            <!--  <li><a href="index.php/profile">Потребителски профил</a></li> -->
                            <li><?php a("profile", "Потребителски профил");?></li>
                        </ul>                    
                    <?php endif; ?>
                    
                    <?php if(src\client\models\UserModel::hasRoleModerator()): ?>

                        <ul>
                            <!-- comment --><!-- <li><a href="index.php/profile">Модераторски профил</a></li> -->
                            <li><?php a("profile", "Модераторски профил");?></li>
                        </ul>                                        
                    <?php endif; ?>

                    <?php if(\src\client\models\UserModel::hasRoleAdmin()): ?>

                        <ul>
                            <!-- <li><a href="index.php/create_product">създаване на продукти</a></li> -->
                            <li><?php a("create_product", "Създаване на продукти");?></li>
                            
                            <li>|</li>
                            <!-- <li><a href="index.php/create_category">създаване на категории</a></li> -->
                            <li><?php a("create_category", "Създаване на категории");?></li></li>
                        </ul>                                                       
                    <?php endif; ?>                    
                    
                    
                    <?php if(src\client\models\UserModel::isGuest()): ?>
                        <ul>
                            <!-- <li><a href="<?php //navigate('home'); ?>">Начало</a></li> -->
                            <li><?php a("home", "Начало");?></li>
                            <li>|</li>
                            
                            <!-- <li><a href="<?php //navigate('signup'); ?>">Регистрация</a></li> -->   
                            <li><?php a("signup", "Регистрация");?></li>
                            <li>|</li>
                            
                            <!-- <li><a href="<?php// navigate('signin'); ?>">Вход</a></li> -->
                            <li><?php a("signin", "Вход");?></li>
                        </ul>                    
                    <?php endif; ?>
                    
                    <?php if(src\client\models\UserModel::isAuthenticated()): ?>
                        <ul>
                            <!-- <li><a href="index.php/home">Начало</a></li> -->
                            <li><?php a("home", "Начало");?></li>
                            <li>|</li>
                            
                            <!-- <li><a href="index.php/teller">Продукти</a></li> -->
                            <li><?php a("teller", "Продукти");?></li>                       
                            <li>|</li>
                            
                            <!-- <li><a href="index.php/profile">Профил</a></li> -->
                            <li><?php a("profile", "Профил");?></li>
                            <li>|</li>
                            
                            <!-- <li><a href="index.php/logout">Изход</a></li> -->
                            <li><?php a("logout", "Изход");?></li>
                        </ul>                    
                    <?php endif; ?>                    
                </div>         
            </div>
        </div>
    </div> 


<?php

namespace src\client\controllers\admin;
use src\vendor\database\Database as Database;


class CategoryController{
    //vrushat danni za category
    public function index() {
        load_view('admin', 'category');
    }


    //insert na new nova categoriq v tb_caegory
    public function insertNewCategory() {
        
        $message = null;
        if(isset($_POST['category_tokken']) && $_POST['category_tokken'] == 1) {
    
            Database::insert('tb_categories', [
                'title' => $_POST['category_title']
            ]);

        $message = 'Success category insertion';
        }
    }
}


<?php
namespace App\Controllers\Api_Controllers;
use App\Models\Connections\DataBase;

class Api_Get_Data{
    public static function get() {
        $conn = DataBase::getConnection();
        if($conn){
           echo "conectado!";
        }else{
            echo "erro na conexao";
        }
    }
}
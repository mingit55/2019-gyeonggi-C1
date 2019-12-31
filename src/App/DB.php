<?php
namespace App;

class DB {
    static $connect = null;
    static function takeDB(){
        if(self::$connect === null){
            $option = [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ];
            self::$connect = new \PDO("mysql:host=localhost;dbname=biaf1;charset=utf8mb4", "root", "", $option);
        }
        return self::$connect;
    }

    static function query($sql, $data =  []){
        $q = self::takeDB()->prepare($sql);
        $q->execute($data);
        return $q;
    }

    static function fetch($sql, $data = []){
        return self::query($sql, $data)->fetch();
    }

    static function fetchAll($sql, $data = []){
        return self::query($sql, $data)->fetchAll();
    }

    static function lastInsertId(){
        return self::takeDB()->lastInsertId();
    }

    static function find($table, $id){
        return self::fetch("SELECT * FROM `$table` WHERE id = ?", [$id]);
    }
}
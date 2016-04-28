<?php

class Database extends PDO{
    
    public function __construct(){
        parent::__construct("sqlite:" . __DIR__ . "/../database.db");
    }
    
    public function getNumberOfImages(){
        $img_num = $this->query("SELECT count(*)  FROM images");
        return $img_num->fetchColumn();
    }
    
    public function saveImage($imgArray, $ext){
        $sql = "INSERT INTO images (name, type, size, ext) VALUES (?,?,?,?)";
        $stm = $this->prepare($sql);
        $values = array(
            $imgArray["name"],
            $imgArray["type"],
            $imgArray["size"],
            $ext        
        );
        if($stm->execute($values) === FALSE){
            return -1;
        }else{
            return $this->lastInsertId("id");
        }
    }
    
    public function getImages(){
        $sql = "SELECT * FROM images";
        return $this->query($sql);
    }
    
    public function getImage($id){
        $sql = "SELECT * FROM images WHERE id ='$id'";
        return $this->query($sql)->fetch(); 
    }
}

?>
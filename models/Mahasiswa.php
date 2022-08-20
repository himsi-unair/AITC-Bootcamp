<?php
require_once PROJECT_ROOT . '/models/Database.php';

class Mahasiswa {
    public $id;
    public $nama;
    public $ipk;
    public $biodata;
    public $image_url;

    private $table_name;
    private $db;
    private $executed_db;
    public  $error_message;

    public function __construct(){
        $db = new Database;
        $this->db = $db->connect();
        $this->table_name = "mahasiswa";
    }

    public function create(){
        // persiapan syntax sql insert
        $sql = "INSERT INTO {$this->table_name} (nama, ipk, biodata, image_url, created_at)
        VALUES (:nama, :ipk, :biodata, :image_url, :created_at);";

        $data = [
            'nama'      =>$this->nama,
            'ipk'       =>$this->ipk,
            'biodata'   =>$this->biodata,
            'image_url' =>$this->image_url,
            'created_at' =>date('Y-m-d H:i:s')
        ];

        // eksekusi syntax
        try {
            $execute = $this->db->prepare($sql);
            if(!$execute->execute($data)){
                $this->error_message = "Aksi simpan gagal :" . $execute->errorInfo()[2];
                return FALSE;
            }else{
                $this->executed_db = $execute;
                return TRUE;
            }
        
        } catch (PDOException $e) {
            $this->error_message = "Aksi simpan gagal :" . $e->getMessage();
            return FALSE;
        }
    }

    public function get($id = null){

        if(!is_null($id)){
            $this->id   = $id;
            // persiapan syntax sql get by id
            $sql  = "SELECT * FROM {$this->table_name} WHERE id = :id";
            $data = ['id' => $this->id];
        }else{
            $sql  = "SELECT * FROM {$this->table_name}";
            $data = [];
        } 

        // eksekusi syntax
        try {
            $execute = $this->db->prepare($sql);
            if(!$execute->execute($data)){
                $this->error_message = "Aksi ambil data gagal :" . $execute->errorInfo()[2];
                return FALSE;
            }else{
                if(!is_null($id)){
                    $result = $execute->fetch();
                }else{
                    $result = $execute->fetchAll();
                }
                return $result;
            }        
        } catch (PDOException $e) {
            $this->error_message = "Aksi ambil data gagal :" . $e->getMessage();
            return FALSE;
        }

    }

    public function update($id){
        // persiapan syntax sql insert
        $sql = "UPDATE {$this->table_name} 
        SET nama = :nama, ipk = :ipk, biodata = :biodata, image_url = :image_url, updated_at = :updated_at
        WHERE id = :id;";

        $data = [
            'nama'      =>$this->nama,
            'ipk'       =>$this->ipk,
            'biodata'   =>$this->biodata,
            'image_url' =>$this->image_url,
            'updated_at' =>date('Y-m-d H:i:s'),
            'id'        =>$id
        ];

        // eksekusi syntax
        try {
            $execute = $this->db->prepare($sql);
            if(!$execute->execute($data)){
                $this->error_message = "Aksi update gagal :" . $execute->errorInfo()[2];
                return FALSE;
            }else{
                $this->executed_db = $execute;
                return TRUE;
            }
        
        } catch (PDOException $e) {
            $this->error_message = "Aksi update gagal :" . $e->getMessage();
            return FALSE;
        }
    }

    public function delete($id){
        // persiapan syntax sql insert
        $sql = "DELETE from {$this->table_name} WHERE id = :id;";

        $data = ['id' =>$id];

        // eksekusi syntax
        try {
            $execute = $this->db->prepare($sql);
            if(!$execute->execute($data)){
                $this->error_message = "Aksi hapus gagal :" . $execute->errorInfo()[2];
                return FALSE;
            }else{
                $this->executed_db = $execute;
                return TRUE;
            }
        
        } catch (PDOException $e) {
            $this->error_message = "Aksi hapus gagal :" . $e->getMessage();
            return FALSE;
        }
    }
}
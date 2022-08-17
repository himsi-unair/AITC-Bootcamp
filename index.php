<?php
define('PROJECT_ROOT', __DIR__);

$route = strtok($_SERVER["REQUEST_URI"], '?');

require_once PROJECT_ROOT.'/controllers/MahasiswaController.php';

switch($route){
    case '/':
        $mahasiswa = new MahasiswaController;
        $mahasiswa->index();
        break;
    case '/create':
        $mahasiswa = new MahasiswaController;
        $mahasiswa->create();
        break;
    case '/store':
        $mahasiswa = new MahasiswaController;
        $mahasiswa->store();
        break;
    case '/edit':
        $mahasiswa = new MahasiswaController;
        $mahasiswa->edit();
        break;
    case '/update':
        $mahasiswa = new MahasiswaController;
        $mahasiswa->update();
        break;
    default:
        echo "Halaman Tidak Ditemukan";
        break;
}

?>
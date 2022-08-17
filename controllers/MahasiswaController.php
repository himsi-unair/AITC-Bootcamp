<?php

    class MahasiswaController{

        public function index()
        {
            $kumpulan_mahasiswa = json_decode(file_get_contents('./data/mahasiswa.json'));
            include './views/index.php';
        }

        public function create()
        {
            include './views/create.php';
        }

        public function store()
        {
            // validasi
            $required_field = ['nama', 'ipk', 'biodata'];
            $empty_field = [];
            foreach($required_field as $field){
                if(empty($_POST[$field])){
                    array_push($empty_field, $field);
                }
            }
            if(!empty($empty_field)){
                $warning = 'Field '.implode(", ", $empty_field).' dibutuhkan';
                include './views/create.php';
                exit;
            }else if(empty($_FILES['image']['tmp_name'])){
                $warning = 'Field image dibutuhkan';
                include './views/create.php';
                exit;
            }

            if (!empty($_FILES['image']['tmp_name'])) {
                $errors = [];
                $path = './uploads/';
                $extensions = ['jpg', 'jpeg', 'png', 'gif'];

                $file_name = 'profile-'.time().rand(1,999);
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];
                $file_size = $_FILES['image']['size'];
                $ext = explode('.', $_FILES['image']['name']);
                $file_ext = strtolower(end($ext));
    
                $file = $path . $file_name . '.' .$file_ext;
    
                if (!in_array($file_ext, $extensions)) {
                    $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
                }
    
                if ($file_size > 2097152) {
                    $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
                }
    
                if (empty($errors)) {
                    move_uploaded_file($file_tmp, $file);
                }
        
                if ($errors) {
                    $warning = 'Terjadi kesalahan : ' . implode('<br>', $errors);
                    include './views/create.php';
                    exit;
                }
            }

            // simpan data
            $data = (object) [
                "nama" => $_POST['nama'],
                "ipk" => $_POST['ipk'],
                "biodata" => $_POST['biodata'],
                "image_url" => $file
            ];
            $kumpulan_mahasiswa = json_decode(file_get_contents('./data/mahasiswa.json'));
            array_push($kumpulan_mahasiswa, $data);
            file_put_contents('./data/mahasiswa.json', json_encode($kumpulan_mahasiswa, JSON_PRETTY_PRINT));

            // redirect ke menu awal
            header('Location: ' . 'http://' . $_SERVER['HTTP_HOST']);
            exit;
        }

        public function edit()
        {
            $id = $_GET['id'];
            $kumpulan_mahasiswa = json_decode(file_get_contents('./data/mahasiswa.json'));

            $data_mahasiswa = null;
            foreach ($kumpulan_mahasiswa as $mahasiswa){
                if($mahasiswa->id == $id){
                    $data_mahasiswa = $mahasiswa;
                }
            }

            if($data_mahasiswa == null){
                $warning = 'Terjadi kesalahan : Data mahasiswa tidak ditemukan';
                include './views/index.php';
                exit;
            }

            include './views/edit.php';
        }

        public function update()
        {
            // validasi
            $required_field = ['nama', 'ipk', 'biodata'];
            $empty_field = [];
            foreach($required_field as $field){
                if(empty($_POST[$field])){
                    array_push($empty_field, $field);
                }
            }
            if(!empty($empty_field)){
                $warning = 'Field '.implode(", ", $empty_field).' dibutuhkan';
                include './views/edit.php';
                exit;
            }

            $file = null;
            if (!empty($_FILES['image']['tmp_name'])) {
                $errors = [];
                $path = './uploads/';
                $extensions = ['jpg', 'jpeg', 'png', 'gif'];

                $file_name = 'profile-'.time().rand(1,999);
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];
                $file_size = $_FILES['image']['size'];
                $ext = explode('.', $_FILES['image']['name']);
                $file_ext = strtolower(end($ext));
    
                $file = $path . $file_name . '.' .$file_ext;
    
                if (!in_array($file_ext, $extensions)) {
                    $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
                }
    
                if ($file_size > 2097152) {
                    $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
                }
    
                if (empty($errors)) {
                    move_uploaded_file($file_tmp, $file);
                }
        
                if ($errors) {
                    $warning = 'Terjadi kesalahan : ' . implode('<br>', $errors);
                    include './views/edit.php';
                    exit;
                }
            }

            // simpan data
            $kumpulan_mahasiswa = json_decode(file_get_contents('./data/mahasiswa.json'));
            foreach ($kumpulan_mahasiswa as $mahasiswa){
                if($mahasiswa->id == $_POST['id']){
                    $mahasiswa->nama = $_POST['nama'];
                    $mahasiswa->ipk = $_POST['ipk'];
                    $mahasiswa->biodata = $_POST['biodata'];
                    if($file != null){
                        $mahasiswa->image_url = $file;
                    }
                }
            }
            file_put_contents('./data/mahasiswa.json', json_encode($kumpulan_mahasiswa, JSON_PRETTY_PRINT));

            // redirect ke menu awal
            header('Location: ' . 'http://' . $_SERVER['HTTP_HOST']);
            exit;
        }
    }
?>
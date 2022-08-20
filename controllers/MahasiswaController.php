<?php
    require_once './models/Mahasiswa.php';

    class MahasiswaController{

        public function seed()
        {
            $kumpulan_mahasiswa = json_decode(file_get_contents('./data/mahasiswa.json'));
            foreach($kumpulan_mahasiswa as $data){
                $mahasiswa = new Mahasiswa;
                $mahasiswa->nama = $data->nama;
                $mahasiswa->ipk = $data->ipk;
                $mahasiswa->biodata = $data->biodata;
                $mahasiswa->image_url = $data->image_url;
                $save = $mahasiswa->create();
            }
            echo 'data successfully saved';
        }

        public function index()
        {
            $mahasiswa = new Mahasiswa;
            $kumpulan_mahasiswa = $mahasiswa->get();
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
                    include './views/create.php';
                    exit;
                }
            }

            // simpan data
            $mahasiswa = new Mahasiswa;
            $mahasiswa->nama = $_POST['nama'];
            $mahasiswa->ipk = $_POST['ipk'];
            $mahasiswa->biodata = $_POST['biodata'];
            $mahasiswa->image_url = $file;
            $save = $mahasiswa->create();

            if(!$save){
                $warning = 'Terjadi kesalahan : ' . $save->error_message;
                include './views/create.php';
                exit;
            }

            // redirect ke menu awal
            header('Location: ' . 'http://' . $_SERVER['HTTP_HOST']);
            exit;
        }

        public function edit()
        {
            $id = $_GET['id'];

            $mahasiswa = new Mahasiswa;
            $data_mahasiswa = $mahasiswa->get($id);

            if(!$data_mahasiswa || empty($mahasiswa)){
                // redirect ke menu awal
                header('Location: ' . 'http://' . $_SERVER['HTTP_HOST']);
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

            $file = $_POST['image_url'];
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
            $mahasiswa = new Mahasiswa;
            $mahasiswa->nama = $_POST['nama'];
            $mahasiswa->ipk = $_POST['ipk'];
            $mahasiswa->biodata = $_POST['biodata'];
            $mahasiswa->image_url = $file;
            $update = $mahasiswa->update($_POST['id']);
            if (!$update) {
                $warning = 'Terjadi kesalahan : ' . $mahasiswa->error_message;
                include './views/edit.php';
                exit;
            }

            // redirect ke menu awal
            header('Location: ' . 'http://' . $_SERVER['HTTP_HOST']);
            exit;
        }

        public function destroy()
        {
            $mahasiswa = new Mahasiswa;
            $delete = $mahasiswa->delete($_GET['id']);

            // redirect ke menu awal
            header('Location: ' . 'http://' . $_SERVER['HTTP_HOST']);
            exit;
        }
    }
?>
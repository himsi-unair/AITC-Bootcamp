<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,700;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/styles/main.css">
</head>
<body>
  <header>
    <h1 onclick="backHome()">Data Mahasiswa</h1>
    <a href="./form.html" target="_blank" class="text-black">Tambah +</a>
  </header>
  <main>
    <div>
      <form method="POST" action="/update" enctype="multipart/form-data" class="form w-500px margin-x-auto">
        <div class="input-image text-center">
          <img src="<?php echo isset($_POST['image_url']) ? $_POST['image_url'] : $data_mahasiswa['image_url']?>" class="margin-x-auto" id="image" alt="picture">
          <div class="wrap-input">
            <button class="btn btn-small btn-gray margin-x-auto" type="button">Pilih File</button>
            <input onchange="inputFile(this)" type="file" name="image" id="fileImg" accept="image/png, image/jpg, image/jpeg" />
          </div>
        </div>
        <?php if(isset($warning)):?>
        <p class="margin-b-16px" style="color:red"><?php echo $warning?></p>
        <?php endif?>
        <input type="hidden" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : $data_mahasiswa['id']?>">
        <input type="hidden" name="image_url" value="<?php echo isset($_POST['image_url']) ? $_POST['image_url'] : $data_mahasiswa['image_url']?>">
        <input class="margin-b-16px" type="text" name="nama" placeholder="nama mahasiswa" value="<?php echo isset($_POST['nama']) ? $_POST['nama'] : $data_mahasiswa['nama']?>"/>
        <input class="margin-b-16px" type="number" step="0.01" max="4" min="0" name="ipk" placeholder="ipk" value="<?php echo isset($_POST['ipk']) ? $_POST['ipk'] : $data_mahasiswa['ipk']?>"/>
        <textarea rows="8" type="text" placeholder="biodata" name="biodata"><?php echo isset($_POST['biodata']) ? $_POST['biodata'] : $data_mahasiswa['biodata']?></textarea>
        <button class="btn btn-primary margin-x-auto margin-t-48px w-250px" type="submit">SIMPAN</button>
      </form>
    </div>
  </main>
  <footer>
    <p class="text-center">AITC Bootcamp</p>
  </footer>

  <script>
    function inputFile(value) {
      const url = value.value;
      if (value && value.files.length > 0) {
        const img = document.getElementById('image');
        const reader = new FileReader();
        reader.onload = function(e) {
          img.setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(value.files[0])
      }
    }

    function backHome(){
        window.location = "http://<?php echo $_SERVER['HTTP_HOST']?>"
    }
  </script>
</body>
</html>
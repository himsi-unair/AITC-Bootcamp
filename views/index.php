<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&display=swap" rel="stylesheet">
  <title>Bootcamp AITC</title>
  <link rel="stylesheet" href="./assets/styles/main.css">
</head>
<body>
  <header>
    <h1 onclick="backHome()">Data Mahasiswa</h1>
    <a href="/create" target="_blank" class="text-black">Tambah +</a>
  </header>
  <main>
    <div>
      <input id="search" type="text" class="w-500px" placeholder="cari nama">
      <?php if(isset($warning)):?>
        <p class="margin-b-16px" style="color:red"><?php echo $warning?></p>
        <?php endif?>
      <div id="empty" class="empty text-center d-none">
        <img src="./assets/images/empty.png" class="margin-x-auto" alt="empty image">
        <h4 class="font-medium">Hasil yang kamu cari tidak ditemukan</h4>
      </div>
      <div id="items" class="items">
        <?php foreach($kumpulan_mahasiswa as $mahasiswa):?>
        <article class="item"
          data-id="<?php echo $mahasiswa->id?>"
          data-src="<?php echo $mahasiswa->image_url?>"
          data-name="<?php echo $mahasiswa->nama?>"
          data-desc="<?php echo $mahasiswa->biodata?>"
          data-ipk="<?php echo $mahasiswa->ipk?>"
          onclick="showModal(this)">
          <div class="item-image">
            <img src="<?php echo $mahasiswa->image_url?>" alt="<?php echo $mahasiswa->nama?>">
            <span class="ipk">IPK <?php echo $mahasiswa->ipk?></span>
          </div>
          <div class="item-desc">
            <h5><?php echo $mahasiswa->nama?></h5>
            <p><?php echo $mahasiswa->biodata?></p>
          </div>
        </article>
        <?php endforeach?>
      </div>
    </div>
    <div id="modalDetail" class="modal d-none">
      <div class="modal-content">
        <div class="modal-body d-flex">
          <div class="modal-image">
            <img src="./assets/images/profile-1.png" alt="B.A. Baracus">
          </div>
          <div class="modal-desc">
            <h3>B.A. Baracus</h3>
            <span class="ipk">IPK 2.7</span>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
              Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
          </div>
        </div>
        <div class="modal-footer">
          <div class="d-flex justify-between">
            <a href="" class="btn btn-secondary btn-link btn-large font-semibold">Edit</a>
            <form class="d-inline-block" method="POST" action="/index.html" onsubmit="if(!confirm('Apakah yakin dihapus?')) return false">
              <input type="hidden" value="DELETE" name="METHOD">
              <button class="btn btn-light btn-link btn-large" type="submit">Hapus</button>
            </form>
          </div>
        </div>
      </div>
      <div class="overlay">     
      </div>
    </div>
  </main>
  <footer>
    <p class="text-center">AITC Bootcamp</p>
  </footer>
  <script>
    // function testCallback(fungsi) {
    //   fungsi();
    // }
    // testCallback(function(){
    //   console.log('testCallback');
    // });
    
    function showModal(e) {
      const elemModal = document.getElementById('modalDetail');
      const elemName = document.querySelector('#modalDetail .modal-body h3');
      const elemIpk = document.querySelector('#modalDetail .modal-body span');
      const elemDesc = document.querySelector('#modalDetail .modal-body p');
      const elemImg = document.querySelector('#modalDetail .modal-image img');
      const elemBtnEdit = document.querySelector('#modalDetail .modal-footer a');

      elemModal.classList.remove('d-none');
      elemName.innerText = e.getAttribute('data-name');
      elemIpk.innerText = 'IPK ' + e.getAttribute('data-ipk');
      elemDesc.innerText = e.getAttribute('data-desc');
      elemImg.setAttribute('src', e.getAttribute('data-src'));
      elemBtnEdit.setAttribute('href', 'edit?id=' + e.getAttribute('data-id'));
    }

    function mounted() {
      const search = document.getElementById("search");
      const empty = document.getElementsByClassName("empty");
      const itemsElem = document.getElementById("items");
      const items = document.querySelectorAll("#items .item");

      search.addEventListener("keyup", function() {
        const arrItem = Array.from(items);
        let count = 0;
        arrItem.forEach(function(item, index) {
          const name = item.querySelector(".item-desc h5").innerText;

          if (name.toLowerCase().includes(search.value.toLowerCase())) {
            item.classList.remove("d-none");
          } else {
            count += 1;
            item.classList.add("d-none");
          }
        });
        if (count === items.length) {
          empty[0].classList.remove("d-none");
          itemsElem.classList.add("d-none");
        } else {
          empty[0].classList.add("d-none");
          itemsElem.classList.remove("d-none");
        }
      })

      document.querySelector('#modalDetail .overlay').addEventListener('click', function() {
        document.getElementById('modalDetail').classList.add('d-none');
      })
    }
    window.addEventListener("load", mounted);

  </script>
</body>
</html>
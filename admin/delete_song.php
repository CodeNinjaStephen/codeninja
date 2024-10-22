<?php
include_once "../php/db.php";
$get_songs = mysqli_query($conn, "SELECT * FROM `song`  ORDER BY id DESC");


?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/output.css" />
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
  </head>
  <body>
    <section class="flex">
      <!-- side bar -->
      <div
        class="w-full md:w-[20%] duration-[0.5s] z-[1000] lg:w-[20%] xl:w-[20%] bg-slate-500 h-screen absolute nav_links left-[-100%] md:static lg:static xl:static"
      >
        <header class="w-full">
          <div class="flex justify-between px-[20px]">
            <span
              onclick="onToggleMenu(this)"
              class="md:hidden pt-[15px] font-extrabold text-xl pr-2 lg:hidden xl:hidden"
              ><ion-icon name="close-circle-outline"></ion-icon
            ></span>
            <span
              class="text-white pr-[10px] font-extrabold text-xl text-center cursor-pointer py-[15px] h-[60px]"
              >Worship<span class="text-red-500">Wave.</span></span
            >
          </div>
        </header>
        <!-- links -->
        <div class="w-full mt-[10px]">
          <div class="w-[90%] mx-auto">
            <a
              class="block py-2 px-4 bg-white rounded mt-[20px] text-start mx-auto font-semibold"
              href="admin.php"
              ><span
                class="w-[50px] mr-[7px] font-semibold text-xl align-middle"
                ><ion-icon name="albums-outline"></ion-icon
              ></span>
              Songs</a
            >
            <a
              class="block py-2 px-4 bg-white rounded mt-[20px] text-start mx-auto font-semibold"
              href="addson.php"
              ><span
                class="w-[50px] mr-[7px] font-semibold text-xl align-middle"
                ><ion-icon name="musical-notes-outline"></ion-icon
              ></span>
              Add Song</a
            >
            <a
              class="block py-2 px-4 bg-white rounded mt-[20px] text-start mx-auto font-semibold"
              
              ><span
                class="w-[50px] mr-[7px] font-semibold text-xl align-middle"
                ><ion-icon name="trash-outline"></ion-icon
              ></span>
              Delete Song</a
            >

            <a
              class="block py-2 px-4 bg-white rounded mt-[20px] text-start mx-auto font-semibold"
              href="../index.php"
              ><span
                class="w-[50px] mr-[7px] font-semibold text-xl align-middle"
                ><ion-icon name="home-outline"></ion-icon
              ></span>
              Home</a
            >

            
          </div>
        </div>
      </div>
      <!-- end of side bar -->

      <div class="w-full md:w-[80%] h-screen lg:w-[80%] xl:w-[80%] p-[10px]">
        <div>
          <div class="flex align-middle justify-between">
            <h2 class="font-bold inline-block text-xl pb-[10px]">Admin</h2>
            <span
              onclick="onToggleMenu(this)"
              class="md:hidden font-bold pr-2 lg:hidden xl:hidden"
              ><ion-icon name="menu-outline"></ion-icon
            ></span>
          </div>
          <div class="w-[95%] mx-auto shadow-md">
            <h2 class="font-light inline-block pb-[10px] text-sm p-[5px]">
              songs
            </h2>
            <div
              class="w-full overflow-y-scroll lg:h-[83vh] grid px-[5px] gap-3 lg:grid-cols-3 grid-cols-2"
            >
              <?php
        while ($row = mysqli_fetch_assoc($get_songs)) {
          
           
        ?>
              <!-- card  -->
              <div
              
                class="w-full h-[320px] shadow border-2"
              >
                <div class="w-full h-[200px]">
                  <img
                    class="w-full object-cover h-[200px]"
                    src="songimg/<?= $row['image']?>"
                    alt=""
                  />
                </div>
                <div class="h-[100px] w-full bg-white">
                  <div class="flex justify-between pt-[5px] px-[5px]">
                    <h2 class="text-neutral-500 font-bold">
                      <?= $row['title']?>
                    </h2>
                    <span class="text-neutral-500 time-display font-bold"
                      >00:00</span
                    >
                  </div>
                  <div class="px-[5px]">
                    <p class="text-sm font-serif"><?= $row['name']?></p>
                  </div>
                  <div>
                    <audio preload="auto" class="audio" id="" style="display:hidden;" src="audio/<?= $row['audio']?>"></audio>
                  </div>
                  <div class="text-center mt-[10px]">
                    <a
                    href="delete.php?song_id=<?php echo $row['id']?>"
                      class="text-white text-center grid mx-auto place-content-center text-4xl font-bold bg-red-500 h-[50px] rounded-full w-[50px]"
                      ><ion-icon
                        id=""
                        class="p-[5px] playBtn align-middle"
                        name="trash-outline"
                      ></ion-icon
                    ></a>
                  </div>
                </div>
              </div>
              <?php 
            }
         ?>
              <!-- card end  -->

              <!-- sca  -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <script>
      const nav_links = document.querySelector(".nav_links");
      function onToggleMenu(e) {
        e.name = e.name === "menu" ? "menu" : "menu";
        nav_links.classList.toggle("left-[0%]");
      };

</script>
</body>
</html>

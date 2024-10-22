<?php
// header('Context-Type : text/css; charset=UTF-8');
// ob_end_flush();
// ini_set('display_errors', 1);
// error_reporting(E_ALL);


session_start();
include_once "../php/db.php";
$user_id = $_SESSION['user_id'];
$get_user_details = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'");
if (!isset($_SESSION['user_id'])) {
  header("Location: ../login.php");
}else{

};

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
              href="delete_song.php"
              ><span
                class="w-[50px] mr-[7px] font-semibold text-xl align-middle"
                ><ion-icon name="trash-outline"></ion-icon
              ></span>
              Delete song</a
            >

            <a
              class="block py-2 px-4 bg-white rounded mt-[20px] text-start mx-auto font-semibold"
              href="index.php"
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
                    <span
                      class="text-white text-center grid mx-auto place-content-center text-4xl font-bold bg-red-500 h-[50px] rounded-full w-[50px]"
                      ><ion-icon
                        id=""
                        class="p-[5px] playBtn align-middle"
                        name="play-circle-outline"
                      ></ion-icon
                    ></span>
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

      let currentAudio = null;
let currentBtn = null;
let intervalId = null;

const audioPlayers = document.querySelectorAll(".audio");
const playPauseBtns = document.querySelectorAll(".playBtn");
const timeDisplays = document.querySelectorAll(".time-display");

playPauseBtns.forEach((btn, index) => {
  btn.addEventListener("click", () => {
    const audio = audioPlayers[index];
    const timeDisplay = timeDisplays[index];

    // Pause currently playing audio, if any
    if (currentAudio && currentAudio !== audio) {
      currentAudio.pause();
      currentBtn.setAttribute("name", "play-circle");
    }

    // Play/pause clicked audio
    if (audio.paused) {
      audio.play().then(() => {
        // Create new interval
        intervalId = setInterval(() => {
          const currentTime = audio.currentTime;
          const duration = audio.duration;
          const minutes = Math.floor(currentTime / 60);
          const seconds = Math.floor(currentTime % 60);
          const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
          timeDisplay.textContent = timeString;

          // Update time display when audio ends
          if (currentTime >= duration) {
            timeDisplay.textContent = "00:00";
            clearInterval(intervalId);
            btn.setAttribute("name", "play-circle");
          }
        }, 100); // Update every 0.1 seconds
      });
      btn.setAttribute("name", "pause-circle");
      currentAudio = audio;
      currentBtn = btn;
    } else {
      audio.pause();
      btn.setAttribute("name", "play-circle");
      clearInterval(intervalId);
      currentAudio = null;
      currentBtn = null;
    }
  });
});



</script>
</body>
</html>

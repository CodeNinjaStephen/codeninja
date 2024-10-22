<?php
    session_start();
    include_once "../php/db.php";
    

    if(isset($_POST['create_post'])) {
        $songname = mysqli_real_escape_string($conn, secure_input($_POST['Title']));
        $songtime = mysqli_real_escape_string($conn, secure_input($_POST['time']));
        $songartist = mysqli_real_escape_string($conn, secure_input($_POST['name']));
        // $postimage = mysqli_real_escape_string($conn, secure_input($_POST['image']));


        $image = $_FILES['postimage'];
        $audio = $_FILES['postsong'];
        // var_dump($image);
        //Get the image data
        $postImageName = $image['name']; // get the image name
        $postTmpName = $image['tmp_name']; // get the image tmp name
        $postImageSize = $image['size']; // get the image size
        $postImageType = $image['type']; // get the image type
        $maxSize = 2097152; //2mb
        $allowedFileTypes = ['image/jpeg', 'image/jpg', 'image/gif', 'image/png']; //\
        $renameImage = time().$postImageName;

        $targetFolder = "songimg/".$renameImage;

        $postaudioName = $audio['name']; // get the image name
        $postaudioTmpName = $audio['tmp_name']; // get the image tmp name
        $postAudioSize = $audio['size']; // get the image size
        $postaudioType = $audio['type']; // get the image type
        $audiomaxSize = 10097152; //2mb
        $audioallowedFileTypes = ['audio/mp3']; //\
        $renameaudio = time().$postaudioName;

        $targetFolder2 = "audio/".$renameaudio;


        // Validate the image
        if(($postImageSize > $maxSize) || ($postImageSize == 0)){
            echo "<script>alert('The file size is too large. It should be less than 2mb');window.history.back();</script>";
         }elseif(($postAudioSize > $audiomaxSize) || ($postAudioSize == 0)){
            echo "<script>alert('The audio file size is too large. It should be less than 10mb');window.history.back();</script>";
            exit();
         }else{
            if(in_array($postImageType, $allowedFileTypes) || in_array($postaudioType, $audioallowedFileTypes)){
                if(move_uploaded_file($postTmpName, $targetFolder) & move_uploaded_file($postaudioTmpName, $targetFolder2)){
                    
                    $insert ="INSERT INTO `song`( `image`, `audio`, `title`, `time`, `name`) VALUES ('$renameImage','$renameaudio','$songname','$songtime','$songartist')";
                    $query = mysqli_query($conn, $insert);
                    if ($query){
                        echo "<script>alert('Successfully Created a Post');window.history.back();</script>";
                    }
                }
            }else{
                echo "<script>alert('Enter a valid Image');window.history.back();</script>";
            }
        }

    }

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

      <div class="w-full md:w-[80%] h-screen lg:w-[80%] xl:w-[80%] pl-[10px] p-[8px]">
        <div>
          <div class="flex align-middle justify-between">
            <h2 class="font-bold inline-block text-lg pb-[10px]">Admin</h2>
            <span
              onclick="onToggleMenu(this)"
              class="md:hidden font-bold pr-2 lg:hidden xl:hidden"
              ><ion-icon name="menu-outline"></ion-icon
            ></span>
          </div>
          <div
            class="w-[95%] mt-[100px] pt-[50px] lg:pt-0 lg:mt-0 mx-auto shadow-md"
          >
            <h2
              class="font-light inline-block pb-[5px] pl-[10px] text-sm p-[5px]"
            >
              add songs
            </h2>
            <div class="lg:w-[90%] mx-auto w-[95%] lg:h-[83vh] px-[5px]">
              <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
                <div class="border w-[90%]  mx-auto p-[7px]">
                  <p class="font-bold p-[5px]">Song Image:</p>
                  <input
                    class="text-center file-input"
                    type="file"
                    name="postimage"
                    id=""
                  />
                </div>
                <div class="border w-[90%] mt-[10px] mx-auto p-[7px]">
                  <p class="font-bold p-[5px]">Song Audio:</p>
                  <input
                    class="text-center file-input"
                    type="file"
                    name="postsong"
                    id=""
                  />
                </div>

                <div class="border w-[90%] mt-[10px] mx-auto p-[7px]">
                  <p class="font-bold p-[5px]">Title :</p>
                  <input
                    name="Title"
                    class="w-full outline-none px-[5px]"
                    placeholder="Type Here..."
                    type="text"
                    id=""
                  />
                </div>

                <div class="border w-[90%] mt-[10px] mx-auto p-[7px]">
                  <p class="font-bold p-[5px]">Time :</p>
                  <input
                    name="time"
                    class="w-full outline-none px-[5px]"
                    placeholder="3:00"
                    type="text"
                    id=""
                  />
                </div>
                <div class="border w-[90%] mt-[10px] mx-auto p-[7px]">
                  <p class="font-bold p-[5px]">Artist :</p>
                  <input
                    name="name"
                    class="w-full outline-none px-[5px]"
                    placeholder="baba v ft soso"
                    type="text"
                    id=""
                  />
                </div>

                <div class="p-[10px] pr-[30px] text-end">
                  <button
                    type="submit"
                    name="create_post"
                    class="bg-stone-500 rounded text-white hover:bg-transparent hover:text-black font-bold hover:border duration-[0.5s] hover:border-black py-[7px] w-[120px] px-[10px]"
                  >
                    Post
                  </button>
                </div>
              </form>
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
      }
    </script>
  </body>
</html>

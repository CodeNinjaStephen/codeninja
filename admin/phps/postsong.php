<?php
    session_start();
    include_once "../php/db.php";
    

    if(isset($_POST['create_post'])) {
        $songname = mysqli_real_escape_string($conn, secure_input($_POST['Title']));
        $songtime = mysqli_real_escape_string($conn, secure_input($_POST['time']));
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
        $audiomaxSize = 6097152; //2mb
        $audioallowedFileTypes = ['image/jpeg', 'image/jpg', 'image/gif', 'image/png']; //\
        $renameaudio = time().$postauidoName;

        $targetFolder = "song/".$renameaudio;


        // Validate the image
        if(($postImageSize > $maxSize) || ($postImageSize == 0)){
            echo "<script>alert('The file size is too large. It should be less than 2mb');window.history.back();</script>";
         }elseif(($postAudioSize > $audiomaxSize) || ($postAudioSize == 0)){
            echo "<script>alert('The audio file size is too large. It should be less than 6mb');window.history.back();</script>";
            exit();
         }else{
            if(in_array($postImageType, $allowedFileTypes)){
                if(move_uploaded_file($postTmpName, $targetFolder)){
                    
                    $insert2 ="INSERT INTO `song`( `image`, `name`, `title`, `time`) VALUES ('$renameImage','$songname','$songtime','$renameaudio')"
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
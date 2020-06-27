<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    include("connection_database.php");
    $email = $_POST["email"];
    $password = $_POST['password'];

    function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }


    $image = GUID();
    $imageName = "".$image.".jpg";
    $image = "uploads/".$image.".jpg";
    $path = $_SERVER['DOCUMENT_ROOT'] . '/'. $image;

    $targetImgSize = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($targetImgSize[1] <= 300 && $targetImgSize[0]<=300){
        $error="Фото замале !";
    }
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $path)) {
            echo "Файл корректен и был успешно загружен.\n";
        } else {
            echo "Возможная атака с помощью файловой загрузки!\n";
        }


    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        $error="Занадто слабкий пароль";
    }else{
        $error="";

        $sql = "SELECT id FROM `tbl_users` AS u WHERE u.email=? LIMIT 1";
        $stmt= $dbh->prepare($sql);
        $stmt->execute([$email]);
        if($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $error = "Данний юзер вже зареєстрований";
        }

        if($error=="")
        {
            $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/upload/';
            $sql = "INSERT INTO `tbl_users` (`email`, `password`, `image`) VALUES (?, ?, ?);";
            $stmt= $dbh->prepare($sql);
            $stmt->execute([$email, $password, $imageName]);
            include_once("resizeImage.php");
            my_image_resize(200,200,$path);
            header("Location:  index.php");
            exit();
        }
    }
}
else{
    $email="";
    $password="";
    $error="";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/279e8c03ce.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <title>Document</title>
</head>
<body>
<?php include("navbar.php");?>
<div class="container">
    <div class="row">
        <h1 class="col-12 text-center">Реєстрація</h1>
    </div>
    <div class="row">
        <form class="col-12 needs-validation" action="registration.php" method="post" enctype="multipart/form-data" novalidate>
            <label class="offset-3 col-6 " style="color: red"><?php echo $error ?></label>
            <div class="offset-3 col-6 form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"  value="<?php echo $email ?>" aria-describedby="emailHelp" required>
                <div class="valid-feedback" >
                    Looks good!
                </div>
            </div>
            <div class="offset-3 col-6 form-group">
                <label for="password">Password</label>
                <input required type="password" value="<?php echo $password ?>" class="form-control" id="password" name="password" required>
                <div class="valid-feedback" >
                    Looks good!
                </div>
            </div>
            <div class="offset-3 col-6 mb-3 input-group mt-2">
                <div class="input-group mb-3">

                    <div class="custom-file">
                        <input required type="file" onchange="loadFile(event)"  class="custom-file-input" name="fileToUpload" id="fileToUpload" aria-describedby="fileToUpload">
                        <label class="custom-file-label" for="fileToUpload">Choose file</label>
                    </div>
                </div>

            </div>
            <input type="hidden" id="h" name="output"/>
            <img id="output" src="default.png" class="offset-4" style="height: 250px;width: 250px;"/>
            <script>
                var loadFile = function(event) {

                    //alert("t");
                    var output = document.getElementById('output');
                    output.src = URL.createObjectURL(event.target.files[0]);
                    output.onload = function() {
                        URL.revokeObjectURL(output.src) // free memory
                    }


                };
            </script>
            <button type="submit" class="offset-8 btn btn-primary">Реєстрація</button>
        </form>
    </div>
</div>

<script src="node_modules/jquery/dist/jquery.min.js" />
<script src="node_modules/popper.js/dist/popper.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<?php include_once("services/cropper.php");?>

<?php include_once "scripts.php" ?>
<script src="node_modules/cropperjs/dist/cropper.min.js"></script>
<script>

    $(function() {

        let dialogCropper = $("#cropperModal");
        $("#fileToUpload").on("change", function() {
            //console.log("----select file------", this.files);
            //this.files;
            if (this.files && this.files.length) {
                let file = this.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    //cropper.destroy();
                    //$('#modalImg').attr('src', e.target.result);
                    dialogCropper.modal('show');
                    cropper.replace(e.target.result);

                }
                reader.readAsDataURL(file);

            }
        });

        const image = document.getElementById('modalImg');
        var lastValidCrop = null;
        const cropper = new Cropper(image, {
            aspectRatio: 1/1,
            viewMode: 1,
            autoCropArea: 1.5,
            crop(e) {
                var validCrop = true;
                if (e.detail.width < 300) validCrop = false;
                if (e.detail.height < 300) validCrop = false;

                if (validCrop) {
                    lastValidCrop = cropper.getData();
                    $("#crop_photo_x").val(e.detail.x);
                    $("#crop_photo_y").val(e.detail.y);
                    $("#crop_photo_width").val(e.detail.width);
                    $("#crop_photo_height").val(e.detail.height);
                } else {
                    cropper.setData(lastValidCrop);
                }
            },
        });

        $("#rotateImg").on("click",function (e) {
            cropper.rotate(90);
        });

        $("#croppImg").on("click", function (e) {
            e.preventDefault();

            var imgContent = cropper.getCroppedCanvas().toDataURL();


            $("#h").val(imgContent);
            $("#output").attr("src", imgContent);
            dialogCropper.modal('hide');
        });

    });

</script>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include_once("styles.php"); ?>
    <title>Document</title>
</head>
<body>
<?php include "navbar.php";
include "connection_database.php";

$sql = "SELECT u.id, u.email, u.image FROM `tbl_users` AS u";
$stmt= $dbh->prepare($sql);
$stmt->execute();
?>

<div class="container">
    <div class="row">
        <h1>Овощи</h1>

        <table class="table table-striped table-dark">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col">Image</th>
            </tr>
            </thead>
            <tbody>

            <?php while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>
                <tr>
                    <th scope="row"><?php echo $row['id']; ?></th>
                    <td><?php echo $row['email']; ?></td>
                    <td><img style="width: 100px; height: 100px;" src="<?php echo "uploads/".$row['image'];?>" alt="" /></td>
                </tr>
                <?php
            }
            ?>



            </tbody>
        </table>



    </div>
</div>

<?php include_once "scripts.php"?>

</body>
</html>
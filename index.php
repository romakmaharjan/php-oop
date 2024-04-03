<?php
require_once "database.php";
$db = Database::Instance();
$allData = $db->All('students'); 

if(!empty($_POST)){

    $db->Insert('students',$_POST);
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP OOP-CRUD</title>
</head>

<body>
    <blockquote>
        <h1>Student List</h1>
        <table border="1" width="100">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php 
            foreach ($allData as $key => $student) { 
                ?>
            <tr>
                <td><?= ++$key; ?></td>
                <td><?= $student->name; ?></td>
                <td><?= $student->email; ?></td>
                <td>
                    <a href="#">Edit</a>
                    <a href="delete.php?id=<?= $student->id ?>">Delete</a>
                </td>
            </tr>
            <?php }?>
        </table>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" /><br>
            <label for="email">Email:</label>
            <input type="email" name="email" />
            <br><br>
            <button>Add Record</button>
        </form>
    </blockquote>
</body>

</html>
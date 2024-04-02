<?php
require_once "database.php";
$db=Database::Instance();

if(!empty($_POST)){

    $db->Insert('students',$_POST);
    echo "Successfully Recorded";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <blockquote>
        <h1>Add Record</h1>
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
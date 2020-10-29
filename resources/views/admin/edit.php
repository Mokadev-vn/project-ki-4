
<?php
    if(isset($_POST['url'])){
        if(isset($_POST['get'])){
            $code = file_get_contents($_POST['url']);
        }
        if(isset($_POST['post'])){
            $codes = isset($_POST['code'])? $_POST['code']: '';
            $myfile = fopen($_POST['url'], "w+");
            fwrite($myfile, $codes);
            fclose($myfile);
        }   
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        input{
            display: block;

        }
        .btn{
            margin: 15px 0;
        }

        .btn > input{
            display: inline;
        }
        
        textarea{
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <input type="text" class="" name="url">
        <div class="btn">
            <input type="submit" name="get" value="GET">
            <input type="submit" name="post" value="POST">
        </div>
        <textarea name="code" id="" cols="100" rows="50"><?= (isset($code)) ? $code : '' ?></textarea>
    </form>
</body>
</html>

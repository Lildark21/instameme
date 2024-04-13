<?php
if(isset($_POST['envoi'])){
    if (isset($_POST['Pseudo'])  AND !empty($_POST['mdp'])){
    }else{
        echo "Vuillez tout compléter ...";
    }
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="" align="center">
        <input type="text"  name="">
        <br>
        <input type="password" name="mdp">
        <br>
        <input type="submit" name="envoi">

    </form>
</body>
</html>
<?php
try{
    $pdo = new PDO("mysql:dbname=projeto_comentarios;host=localhost", "root", "");
}catch(PDOException $e){
    echo "ERRO: ".$e->getMessage();
    exit;
}

if(isset($_POST['nome']) && empty($_POST['nome']) == false){
    $nome = $_POST['nome'];
    $mensagem = $_POST['mensagem'];

    $sql = $pdo->prepare("INSERT INTO mensagens SET nome = :nome, msg = :msg, data_msg = NOW()");
    $sql-> bindValue(":nome", $nome);
    $sql->bindValue(":msg", $mensagem);
    $sql->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./styles.css" rel="stylesheet" type="text/css">
    <title>Comentários</title>
</head>
<body>
    <header>
        <h2>Sistema de comentários</h2>
    </header>
    <div id="body">
        <form method="POST">
            <h4>Nome:</h4>
            <input type="text" name="nome"><br>
    
            <h4>Mensagem:</h4>
            <textarea name="mensagem"></textarea><br><br>
            <input type="submit" value="Enviar Mensagem" id="enviar">
        </form>
    <br><br>
    </div>
</body>
</html>


<?php
$sql = "SELECT * FROM mensagens ORDER BY data_msg DESC";
$sql = $pdo->query($sql);
if($sql->rowCount() > 0){
    foreach($sql->fetchAll() as $mensagem):
        ?>
        <strong><?php echo $mensagem['nome'];?></strong><br>
        <?php echo $mensagem['msg'];?>
        <hr>
        <?php
        endforeach;
} else{
    echo "Não há mensagem.";
}
?>
<!DOCTYPE html>
<html lang="p-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TURMA</title>
  <link rel="stylesheet" href="css/turma.css">
  <link rel="shortcut icon" href="../img/ico_escola.ico">
</head>
<body>
  <?php require "header.php"; ?>
  <!-- BUSCANDO TURMAS NO BANCO -->
  <div id="caixa_preta"></div>
  <?php if (@$_GET['pg'] == 'todos') { ?>
    <div id="box_turma">
      <br><br>
      <h1>Turmas cadastradas</h1>
      <?php
        $sql_1 = "SELECT * FROM turma WHERE descricao != ''";
        $consulta = mysqli_query($conexao, $sql_1);
        if (mysqli_num_rows($consulta) == '')
          echo "<h2>Não existe nenhuma turma cadastrada no momento</h2>";
        else { ?>
          <table width="900" border="0">
            <tr>
              <td><strong>Id:</strong></td>
              <td><strong>Descrição:</strong></td>
              <td></td>
            </tr>
            <?php while ($res_1 = mysqli_fetch_assoc($consulta)) { ?>
            <tr>
              <td><h3><?php echo $res_1['id']; ?></h3></td>
              <td><h3><?php echo $res_1['descricao']; ?></h3></td>
              <td></td>
              <td>
                <a class="a" href="turma.php?pg=todos&func=deleta&id=<?php echo $res_1['id']; ?>"><img src="img/deleta.jpg" title="Excluir Turma(a)" width="18" height="20" border="0"></a>
              </td>
            </tr>    
            <?php } ?>
          </table>
          <br>
        <?php } ?>
    </div> <!-- FECHAMENTO da box_turma -->
    <!-- EXCLUSÃO, ATIVAÇÃO E DESATIVAÇÃO -->
    <?php
      if (@$_GET['func'] == 'deleta') {
        $id = $_GET['id'];
  
        $sql_del = "DELETE FROM turma WHERE id = '$id'";
        mysqli_query($conexao, $sql_del);
  
        echo "<script language='javascript'>window.location='turma.php?pg=todos';</script>";
      }
    ?>

<?php } ?> <!-- FECHAMENTO do pg = 'TODOS' -->
  <!-- CADASTRO DAS turmas - ETAPA 1 -->
  <?php if (@$_GET['pg'] == 'cadastra') { ?>
    <?php if (@$_GET['bloco'] == '1') { ?>
      <div id="cadastra_turma">
        <?php
          if (isset($_POST['button'])) {
            $id = $_POST['id'];
            $turma = $_POST['descricao'];
              
            $sql_2 = "INSERT INTO turma (id, descricao) VALUES ('$id', '$turma')";
            $cadastra = mysqli_query($conexao, $sql_2);
  
            echo "<script language='javascript'>window.alert('Turma cadastrada com sucesso!');window.location='turma.php?pg=todos';</script>";
          }
        ?>
        <form name="form1" action="" method="post">
          <table width="900" border="0">
            <tr>
              <td>ID:</td>
              <td>Descrição:</td>             
            </tr>
            <tr>
              <td>
                <input type="text" name="id" id="textfield1">
              </td>
              <td>
                <input type="text" name="descricao" id="textfield2">
              </td>
            </tr>           
            <tr>
              <td><input class="input" type="submit" name="button" id="button" value="Salvar"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </form>
        <br>
      </div> <!-- Fechamento da div cadastra_estudante -->
    <?php } ?> <!-- Fechamento da bloco 1 -->
        <br>
  <?php } ?> <!-- Fechamento do pg cadastra -->
  <?php require "footer.php"; ?>
</body>
</html>
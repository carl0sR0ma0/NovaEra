<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Professores</title>
  <link rel="stylesheet" href="css/professores.css">
  <link rel="shortcut icon" href="../img/ico_escola.ico">
</head>
<body>
  <?php require "header.php"; ?>
  <div id="caixa_preta"></div>
  <!-- EXIBIR TABELA DOS PROFESSORES CADASTRADOS -->
  <?php if (@$_GET['pg'] == 'todos') { ?>
    <div id="box_professores">
      <br><br>
      <a href="professores.php?pg=cadastra" class="a2">Cadastrar Professor</a>
      <h1>Professores</h1>
      <?php
        $sql = "SELECT * FROM professor WHERE nome != ''";
        $con = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($con) == '')
          echo "No momento não existe professores cadastrados!";
        else { ?>
          <table width="900" border="0">
            <tr>
              <td><strong>Código:</strong></td>
              <td><strong>Nome:</strong></td>
              <td><strong>Titulação</strong></td>
              <td><strong>N° de Disciplina(s):</strong></td>
              <td></td>
            </tr>
            <?php while ($res_1 = mysqli_fetch_assoc($con)) { ?>
            <tr>
              <td><h3><?php echo $id = $res_1['id']; ?></h3></td>
              <td><h3><?php echo $res_1['nome']; ?></h3></td>
              <td><h3><?php echo $res_1['titulacao']; ?></h3></td>
              <td>
                <h3>
                  <?php 
                    $sql2 = "SELECT * FROM professor_disciplina WHERE id_professor = '$id'";
                    echo mysqli_num_rows(mysqli_query($conexao, $sql2));
                  ?>
                </h3>
              </td>              
              <td></td>
              <td>
                <a href="professores.php?pg=todos&func=deleta&id=<?php echo $res_1['id']; ?>" class="a"><img src="img/deleta.jpg" title="Excluir Professor" width="18" height="18" border="0"></a>
                <a href="professores.php?pg=todos&func=edita&id=<?php echo $res_1['id']; ?>" class="a"><img src="../img/ico-editar.png" title="Editar Dados Cadastrais" width="18" height="18" border="0"></a>
              </td>
            </tr>
            <?php } ?>
          </table>
        <?php } ?>
      <br>
      <!-- DELETAR O PROFESSOR -->
      <?php
        if (@$_GET['func'] == 'deleta') {
          $id = $_GET['id'];
          $sql_42 = "DELETE FROM professor WHERE id = '$id'";

          mysqli_query($conexao, $sql_42);
          echo "<script language='javascript'>window.location='professores.php?pg=todos';</script>";
        }
      ?>
      <!-- EDITAR O PROFESSOR -->
      <?php if (@$_GET['func'] == 'edita') { ?>
        <hr>
        <h1>Editar Professor</h1>

        <?php
          $id = $_GET['id'];
          $sql_1 = "SELECT * FROM professor WHERE id = '$id'";
          $edit = mysqli_query($conexao, $sql_1);
          
          while ($res_1 = mysqli_fetch_assoc($edit)) { ?>
            <?php if (isset($_POST['button'])) {
              $id = $_GET['id'];
              $nome = $_POST['nome'];
              $titulacao = $_POST['titulacao'];

              $sql_2 = "UPDATE professor SET nome = '$nome', titulacao = '$titulacao' WHERE id = '$id'";
              $res_editar = mysqli_query($conexao, $sql_2);
              if ($res_editar == '')
                echo "<script language='javascript'>window.alert('Ocorreu um erro tente novamente!');window.location='';</script>";
              else
                echo "<script language='javascript'>window.alert('Atualização realizada com sucesso!');window.location='professores.php?pg=todos';</script>";
            }
          ?>
          <form action="" method="post" name="form1" enctype="multipart/form-data">
            <table width="900" border="0">
              <tr>
                <td>Nome:</td>
                <td>Titulação:</td>
              </tr>
              <tr>
                <td><input type="text" name="nome" id="textfield" value="<?php echo $res_1['nome']; ?>"></td>
                <td><input type="text" name="titulacao" id="textfield" value="<?php echo $res_1['titulacao']; ?>"></td>
              </tr>
              <tr>
                <td><input type="submit" name="button" id="button" class="input" value="Atualizar"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
            <?php } ?>
          </form>
      <?php } ?>
      <br>
    </div> <!-- Fechamento da div box_professores -->
  <?php } ?> <!-- Fechamento da PG todos -->
  <!-- CADASTRO DOS PROFESSORES -->
  <?php if (@$_GET['pg'] == 'cadastra') { ?>
    <div id="cadastra_professores">
      <h1>Cadastrar Novo Professor</h1>
      <?php
        if (isset($_POST['button'])) {
          $id = $_POST['id'];
          $nome = $_POST['nome'];
          $titulacao = $_POST['titulacao'];

          $sql_2 = "INSERT INTO professor (id, nome, titulacao) VALUES ('$id', '$nome', '$titulacao')";
          $cadastra = mysqli_query($conexao, $sql_2);
          if ($cadastra == '')
            echo "<script language='javascript'>window.alert('Ocorreu um erro ao cadastrar');</script>";
          else 
            echo "<script language='javascript'>window.alert('Professor cadastrado com Sucesso!!!');window.location='professores.php?pg=todos';</script>";
        }
      ?>
      <form action="" method="post">
        <table width="900" border="0">
          <tr>
            <td>Id:</td>
            <td>Nome:</td>
            <td>Titulação:</td>
          </tr>
          <tr>
            <td><input type="text" name="id" id="textfield"></td>
            <td><input type="text" name="nome" id="textfield"></td>
            <td><input type="text" name="titulacao" id="textfield"></td>
          </tr>
          <tr>
            <td><input type="submit" value="Cadastrar" class="input" name="button"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
      <br>
    </div> <!-- FECHAMENTO DA DIV cadastra_professores -->
  <?php } ?>
  <?php require "footer.php"; ?>
</body>
</html>
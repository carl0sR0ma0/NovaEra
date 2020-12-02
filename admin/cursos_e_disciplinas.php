<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cursos & Disciplinas</title>
  <link rel="stylesheet" href="css/cursos_e_disciplinas.css">
</head>
<body>
  <?php require "header.php"; ?>
  <div id="caixa_preta"></div>
  <!-- CADASTRAR CURSO -->
  <?php if (@$_GET['pg'] == 'curso') { ?>
    <div id="box_curso">
      <br><br>
      <a href="cursos_e_disciplinas.php?pg=curso&cadastra=sim" class="a2">Cadastrar Curso</a>
      <?php if (@$_GET['cadastra'] == 'sim') { ?>
        <br><br>
        <h1>Cadastrar Curso</h1>
        <?php if (isset($_POST['cadastra'])) {
          $nome = $_POST['nome'];
          $periodicidade = $_POST['periodicidade'];
          $descricao = $_POST['descricao'];
          $sql = "INSERT INTO curso (nome, periodicidade, descricao) VAlUES ('$nome', '$periodicidade', '$descricao')";

          $cad = mysqli_query($conexao, $sql);
          if ($cad == '')
            echo "<script language='javascript'>window.alert('ERRO ao Cadastrar, Curso já Cadastrado!');</script>";
          else {
            echo "<script language='javascript'>window.alert('Cadastro Realizado com Sucesso!!!');</script>";
            echo "<script language='javascript'>window.location='cursos_e_disciplinas.php?pg=curso';</script>";
          }
        } ?>
        <form action="" method="post" name="form1">
          <table width="900" border="0">
            <tr>
              <td width="134">Curso</td>
              <td width="134">Periodicidade</td>
            </tr>
            <tr>
              <td><input type="text" name="nome" id="textfield"></td>
              <td>
                <select name="periodicidade" id="periodicidade" size="1">
                  <option value="Manhã">Manhã</option>
                  <option value="Tarde">Tarde</option>
                  <option value="Noite">Noite</option>
                </select>
              </td>
            </tr>
            <tr>
              <td width="134">Descrição</td>
            </tr>
            <tr>
              <td>
                <textarea name="descricao" id="descricao" cols="35" rows="5" ></textarea>
              </td>
            </tr>
            <tr>
              <td>
                <input type="submit" name="cadastra" id="button" class="input" value="Cadastrar">
              </td>
            </tr>
          </table>
        </form>
        <br>
      <?php die; } ?>
      <!-- VISUALIZAR CURSOS CADASTRADOS -->
      <br><br>
      <h1>Cursos</h1>
      <?php
        $sql_1 = "SELECT * FROM curso";
        $result = mysqli_query($conexao, $sql_1);
        if (mysqli_num_rows($result) <= 0)
          echo "<h2>No momento não existe nenhum Curso cadastrado!!!</h2><br><br>";
        else { ?>
          <table width="900" border="0">
            <tr>
              <td><strong>Curso:</strong></td>
              <td><strong>Período:</strong></td>
              <td><strong>Total de Disciplinas:</strong></td>
              <td>&nbsp;</td>
            </tr>
            <?php while ($res_1 = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><h3><?php echo $curso = $res_1['nome']; $id_curso = $res_1['id']; ?></h3></td>
              <td><h3><?php echo $periodo = $res_1['periodicidade']; ?></h3></td>
              <td><h3>
                <?php $sql_2 = "SELECT * FROM disciplina WHERE id_curso = '$id_curso'";
                $result2 = mysqli_query($conexao, $sql_2);
                echo mysqli_num_rows($result2); ?>
              </h3></td>
              <td><a href="cursos_e_disciplinas.php?pg=curso&deleta=cur&id=<?php echo @$res_1['id']; ?>"><img src="img/deleta.jpg" title="Excluir curso" width="18" height="18" border="0"></a></td>
            </tr>
            <?php } ?>
          </table>
          <br>
        <?php } ?>
        <!-- DELEÇÃO DOS CURSOS -->
        <?php
          if (@$_GET['deleta'] == 'cur') {
            $id = $_GET['id'];

            $sql_3 = "DELETE FROM curso WHERE id = '$id'";
            mysqli_query($conexao, $sql_3);
            echo "<script language='javascript'>window.location='cursos_e_disciplinas.php?pg=curso';</script>";
          }
        ?>
    </div>
  <?php } ?>
  <?php require "footer.php"; ?>
</body>
</html>
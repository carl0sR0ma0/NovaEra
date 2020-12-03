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
              <td></td>
            </tr>
            <?php while ($res_1 = mysqli_fetch_assoc($con)) { ?>
            <tr>
              <td><h3><?php echo $id = $res_1['id']; ?></h3></td>
              <td><h3><?php echo $res_1['nome']; ?></h3></td>
              <td>
                <h3>
                  <?php 
                    $sql2 = "SELECT * FROM disciplina WHERE professor = '$id'";
                    echo mysqli_num_rows(mysqli_query($conexao, $sql2));
                  ?>
                </h3>
              </td>              
              <td></td>
              <td>
                <a href="professores.php?pg=todos&func=deleta&id=<?php echo $res_1['id']; ?>" class="a"><img src="img/deleta.jpg" title="Excluir Professor" width="18" height="18" border="0"></a>
                <?php if ($res_1['status'] == 'Inativo') { ?>
                  <a href="professores.php?pg=todos&func=ativa&id=<?php echo $res_1['id']; ?>&code=<?php echo $res_1['code']; ?>" class="a"><img src="../img/correto.jpg" title="Ativar novamente professor" width="20" height="20" border="0"></a>
                <?php } ?>
                <?php if ($res_1['status'] == 'Ativo') { ?>
                  <a href="professores.php?pg=todos&func=inativa&id=<?php echo $res_1['id']; ?>&code=<?php echo $res_1['code']; ?>" class="a"><img src="../img/ico_bloqueado.png" title="Inativar Professor(a)" width="18" height="18" border="0"></a>
                <?php } ?>
                <a href="professores.php?pg=todos&func=edita&id=<?php echo $res_1['id']; ?>" class="a"><img src="../img/ico-editar.png" title="Editar Dados Cadastrais" width="18" height="18" border="0"></a>
                <a href="historico_professor.php?id=<?php echo $res_1['id']; ?>" class="a" rel="superbox[iframe][930x500]"><img src="../img/visualizar16.gif" title="Histórico deste professor" width="18" height="18" border="0"></a>
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
            $sql_del = "DELETE FROM professores WHERE id = '$id'";
            mysqli_query($conexao, $sql_del);
            echo "<script language='javascript'>window.location='professores.php?pg=todos';</script>";
          }
        ?>
        <!-- ATIVAR O PROFESSOR -->
        <?php
          if (@$_GET['func'] == 'ativa') {
            $id = $_GET['id'];
            $code = $_GET['code'];
            
            $sql_edit1 = "UPDATE professores SET status = 'Ativo' WHERE id = '$id'"; 
            $sql_edit2 = "UPDATE login SET status = 'Ativo' WHERE code = '$code'";
            mysqli_query($conexao, $sql_edit1);
            mysqli_query($conexao, $sql_edit2);
            echo "<script language='javascript'>window.location='professores.php?pg=todos';</script>";
          }
        ?>
        <!-- INATIVAR O PROFESSOR -->
        <?php
          if (@$_GET['func'] == 'inativa') {
            $id = $_GET['id'];
            $code = $_GET['code'];

            $sql_edit3 = "UPDATE professores SET status = 'Inativo' WHERE id = '$id'";
            $sql_edit4 = "UPDATE login SET status = 'Inativo' WHERE code = '$code'";
            mysqli_query($conexao, $sql_edit3);
            mysqli_query($conexao, $sql_edit4);
            echo "<script language='javascript'>window.location='professores.php?pg=todos';</script>";
          }
        ?>
      <!-- EDITAR OS PROFESSORES -->
      <?php if (@$_GET['func'] == 'edita') { ?>  
        <hr>
        <h1>Editar professores</h1>

        <?php
          $id = $_GET['id'];

          $sql_1 = "SELECT * FROM professores WHERE id = '$id'";
          $edit = mysqli_query($conexao, $sql_1);
          while ($res_1 = mysqli_fetch_assoc($edit)) { ?>
            <?php if (isset($_POST['button'])) {
              $id = $_GET['id'];
              $nome = $_POST['nome'];
              $cpf = $_POST['titulacao'];               
              $sql_2 = "UPDATE professores SET nome = '$nome', titulacao = '$titulacao' WHERE id = '$id'";
              $res_editar = mysqli_query($conexao, $sql_2);
              if ($res_editar == '')
                echo "<script language='javascript'>window.alert('Ocorreu um erro tente novamente!');window.location='';</script>";
              else
                echo "<script language='javascript'>window.alert('Atualização realizada com sucesso!');window.location='professores.php?pg=todos';</script>";
            }
          ?>
          <form name="form1" action="" method="post" enctype="multipart/form-data">
            <table width="900" border="0">
              <tr>
                <td>Nome:</td>
                <td>Titulação:</td>
                <!--<td>Salário:</td> -->
              </tr>
              <tr>
                <td>
                  <label for="textfield2"></label>
                  <input type="text" name="nome" id="textfield2" value="<?php echo $res_1['nome']; ?>">
                </td>
                <td>
                  <label for="textfield3"></label>
                  <input type="text" name="titulacao" id="textfield3" value="<?php echo $res_1['titulacao']; ?>">
                </td>                
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
      <h1>Cadastrar novo professor</h1>
      <?php
        if (isset($_POST['button'])) {
          $code = $_POST['code'];
          $nome = $_POST['nome'];
          $titulacao = $_POST['titulacao'];          
  
          $sql_2 = "INSERT INTO professor (id, nome, titulacao) VALUES ('$code', '$nome', '$titulacao')";
          $cadastra = mysqli_query($conexao, $sql_2);
          if ($cadastra == '')
            echo "<script language='javascript'>window.alert('Ocorreu um erro ao cadastrar!');</script>";
          else {
            $sql_3 = "INSERT INTO login (status, code, senha, nome, painel) VALUES ('Ativo', '$code', '$titulacao', '$nome', 'PROFESSOR')";
            $cadastra_login = mysqli_query($conexao, $sql_3);
            echo "<script language='javascript'>window.alert('Professor cadastrado com sucesso!');window.location='professores.php?pg=todos';</script>";
          }
        }
      ?>
      <form name="form1" action="" method="post">
        <table width="900" border="0">
          <tr>
            <td>Código:</td>
            <td>Nome:</td>
            <td>Titulação:</td>
          </tr>
          <tr>
            <td>
              <?php
                $sql_4 = "SELECT * FROM professor ORDER BY id DESC LIMIT 1";
                $buscar_prof = mysqli_query($conexao, $sql_4);
                if (mysqli_num_rows($buscar_prof) == '') {
                  $new_code = "87415978";
              ?>
                  <input type="text" name="code" id="textfield" disabled="disabled" value="<?php echo $new_code; ?>">
                  <input type="hidden" name="code" value="<?php echo $new_code; ?>">
            </td>
            <?php
                } else {
                  while ($res_1 = mysqli_fetch_assoc($buscar_prof)) {
                    $new_code = $res_1['code'] + $res_1['id'] + 741;
            ?>
                    <input type="text" name="code" id="textfield" disabled="disabled" value="<?php echo $new_code; ?>">
                    <input type="hidden" name="code" value="<?php echo $new_code; ?>">
            </td>
                  <?php }
                } ?>
            <td><input type="text" name="nome" id="textfield2"></td>
            <td><input type="text" name="titulacao" id="textfield3"></td>
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
  <?php } ?> <!-- FECHAMENTO do PG = CADASTRAR -->

  <?php require "footer.php"; ?>
</body>
</html>
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
              <td>
                <a href="cursos_e_disciplinas.php?pg=curso&func=edita&id=<?php echo $res_1['id']; ?>" class="a"><img src="../img/ico-editar.png" title="Editar Dados Cadastrais" width="18" height="18" border="0"></a>
                <a href="cursos_e_disciplinas.php?pg=curso&deleta=cur&id=<?php echo @$res_1['id']; ?>"><img src="img/deleta.jpg" title="Excluir curso" width="18" height="18" border="0"></a>
              </td>
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
        <!-- EDITAR OS CURSO --->
        <?php if (@$_GET['func'] == 'edita') { ?>
          <hr>
          <h1>Editar professores</h1>

          <?php
            $id = $_GET['id'];

            $sql_1 = "SELECT * FROM curso WHERE id = '$id'";
            $edit = mysqli_query($conexao, $sql_1);
            while ($res_1 = mysqli_fetch_assoc($edit)) { ?>
              <?php
                if (isset($_POST['button'])) {
                  $id = $_GET['id'];
                  $nome = $_POST['nome'];
                  $periodo = $_POST['periodicidade'];
                  $descricao = $_POST['descricao'];

                  $sql_2 = "UPDATE curso SET nome = '$nome', periodicidade = '$periodo', descricao = '$descricao' WHERE id = '$id'";
                  $res_editar = mysqli_query($conexao, $sql_2);
                  if ($res_editar == '')
                    echo "<script language='javascript'>window.alert('Ocorreu um erro tente novamente!');window.location='';</script>";
                  else
                    echo "<script language='javascript'>window.alert('Atualização realizada com sucesso!');window.location='cursos_e_disciplinas.php?pg=curso';</script>";
                }
              ?>
              <form action="" method="post" name="form1" enctype="multipart/form-data">
                <table width="900" border="0">
                  <tr>
                    <td>Nome:</td>
                    <td>Periodicidade:</td>
                  </tr>
                  <tr>
                    <td><input type="text" name="nome" id="textfield2" value="<?php echo $res_1['nome']; ?>"></td>
                    <td>
                      <select name="periodicidade" id="periodicidade" size="1">
                        <option value=""><?php echo $res_1['periodicidade']; ?></option>
                        <option value=""></option>
                        <option value="Manhã">Manhã</option>
                        <option value="Tarde">Tarde</option>
                        <option value="Noite">Noite</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Descrição:</td>
                  </tr>
                  <tr>
                    <td><textarea name="descricao" id="textarea" cols="35" rows="5"><?php echo $res_1['descricao']; ?></textarea></td>
                  </tr>
                  <tr>
                    <td><input type="submit" name="button" class="input" value="Atualizar"></td>
                  </tr>
                </table>
            <?php } ?>
              </form>
        <?php } ?>
        <br>
    </div> <!-- Fechamento da div box_curso -->
  <?php } ?> <!-- Fechamento da pg = curso -->

  <!--CADASTRAR DISCIPLINAS -->
  <?php if (@$_GET['pg'] == 'disciplina') { ?>
    <div id="box_disciplinas">
      <br><br>
      <a class="a2" href="cursos_e_disciplinas.php?pg=disciplina&cadastra=sim">Cadastrar Disciplina</a>
      <?php if (@$_GET['cadastra'] == 'sim') { ?>
        <br><br>
        <h1>Cadastrar Nova Disciplina</h1>
        <?php
          if (isset($_POST['cadastra'])) {
            $id = $_POST['id'];
            $curso = $_POST['curso'];
            $nome = $_POST['nome'];
            $ch = $_POST['ch'];
            $ementa = $_POST['ementa'];

            if ($nome == '')
              echo "<script language='javascript'>window.alert('Digite o nome da disciplina');</script>";
            elseif ($ch == '')
              echo "<script language='javascript'>window.alert('Digite a carga horária da disciplina');</script>";
            else {
              $sql_cad_disc = "INSERT INTO disciplina (id, nome, carga_horaria, ementa, id_curso) VALUES ('$id', '$nome', '$ch', '$ementa', '$curso')";
              $cad_disc = mysqli_query($conexao, $sql_cad_disc);
              if ($cad_disc == '')
                echo "<script language='javascript'>window.alert('Ocorreu um erro!');</script>";
              else
                echo "<script language='javascript'>window.alert('Disciplina cadastrada com sucesso!!!');window.location='cursos_e_disciplinas.php?pg=disciplina';</script>";
            }
          }
        ?>
        <form action="" method="post" name="form1">
          <table width="900" border="0">
            <tr>
              <td>Curso:</td>
              <td>Id:</td>
              <td>Disciplina:</td>
            </tr>
            <tr>
              <td>
                <select style="width:200px;" size="1" name="curso">
                    <?php
                      $sql_rec_curso = "SELECT * FROM curso";
                      $result_rec_curso = mysqli_query($conexao, $sql_rec_curso);

                      while ($r2 = mysqli_fetch_assoc($result_rec_curso)) { ?>
                        <option value="<?php echo $r2['id']; ?>"><?php echo $r2['nome']; ?></option>
                      <?php } ?>
                  </select>
              </td>
              <td><input type="text" name="id"></td>
              <td><input type="text" name="nome" id="textfield"></td>
            </tr>
            <tr>
              <td>Carga-Horária</td>
              <td>Ementa:</td>
              <td>&nbsp;</td>
              <td width="0" colspan="2"></td>
            </tr>
            <tr>
              <td><input type="text" name="ch" id="textfield"></td>
              <td><textarea name="ementa" id="textarea" cols="35" rows="5"></textarea></td>
              <td><input class="input" type="submit" name="cadastra" id="button" value="Cadastrar"></td>
            </tr>
          </table>
        </form>
        <br>
      <?php die; } ?>
      <!-- VISUALIZAR DISCIPLINAS CADASTRADAS -->
      <br><br>
      <h1>Disciplinas</h1>
      <?php
        $sql_buscar_disc = "SELECT * FROM disciplina";
        $result_buscar_disc = mysqli_query($conexao, $sql_buscar_disc);
        if (mysqli_num_rows($result_buscar_disc) == '')
          echo "<h2>No momento não existe nenhuma Disciplina cadastrada!!!</h2><br><br>";
        else { ?>
          <table width="900" border=0>
            <tr>
              <td><strong>Curso:</strong></td>
              <td><strong>Id:</strong></td>
              <td><strong>Disciplina:</strong></td>
              <td><strong>Carga-Horária:</strong></td>
              <td><strong>Professor:</strong></td>
            </tr>
            <?php while ($res_busca = mysqli_fetch_assoc($result_buscar_disc)) { ?>
            <tr>
              <td><h3><?php echo $res_busca['id_curso']; ?></h3></td>
              <td><h3><?php echo $idDisc = $res_busca['id']; ?></h3></td>
              <td><h3><?php echo $res_busca['nome']; ?></h3></td>
              <td><h3><?php echo $res_busca['carga_horaria']; ?></h3></td>
              <td><h3>
                <?php
                  $sql_buscar_prof = "SELECT * FROM professor";                  
                  $result_buscar_prof = mysqli_query($conexao, $sql_buscar_prof);
                  
                  while ($res_busca_prof = mysqli_fetch_assoc($result_buscar_prof)) {
                    $professorId = $res_busca_prof['id'];
                    $sql_busca_prof = "SELECT * FROM professor_disciplina WHERE id_professor = '$professorId' AND id_disciplina = '$idDisc'";
                    $resul_buscar_prof = mysqli_query($conexao, $sql_busca_prof);
                    if (mysqli_num_rows($resul_buscar_prof) <= 0) { ?>
                      <a href="cursos_e_disciplinas.php?pg=disciplina&func=disciplina_prof&id=<?php echo $res_busca['id']; ?>">Adicionar Professor</a>
                    <?php } else {
                      while ($res_busca2 = mysqli_fetch_assoc($resul_buscar_prof)) {
                        echo " - " .$res_busca_prof['nome'] ;
                      }  
                    }
                  }
                ?>
              </h3></td>
              <td>
                <a href="cursos_e_disciplinas.php?pg=disciplina&func=edita&id=<?php echo $res_busca['id']; ?>" class="a"><img src="../img/ico-editar.png" title="Editar Dados Cadastrais" width="18" height="18" border="0"></a>
                <a href="cursos_e_disciplinas.php?pg=disciplina&deleta=sim&id=<?php echo $res_busca['id']; ?>"><img src="img/deleta.jpg" title="Excluir Disciplina" width="18" height="18" border="0"></a>
              </td>
            </tr>
            <?php } ?>
          </table>
          <br>
        <?php } ?>
      <!-- EXCLUSÃO DAS DISCIPLINAS -->
      <?php
        if (@$_GET['deleta'] == 'sim') {
          $id = $_GET['id'];
          $sql_31 = "DELETE FROM professor_disciplina WHERE id_disciplina = '$id'";
          $sql_32 = "DELETE FROM disciplina WHERE id = '$id'";

          mysqli_query($conexao, $sql_31);
          mysqli_query($conexao, $sql_32);
          echo "<script language='javascript'>window.location='cursos_e_disciplinas.php?pg=disciplina';</script>";
        }
      ?>
      <!-- EDITAR AS DISCIPLINAS --->
      <?php if (@$_GET['func'] == 'edita') { ?>
        <hr>
        <h1>Editar Disciplina</h1>

        <?php
          $id = $_GET['id'];
          $sql_4 = "SELECT * FROM disciplina WHERE id = '$id'";
          $edit2 = mysqli_query($conexao, $sql_4);
          while ($res_2 = mysqli_fetch_assoc($edit2)) { ?>
            <?php
              if (isset($_POST['button'])) {
                $id = $_GET['id'];
                $nome = $_POST['nome'];
                $ch = $_POST['ch'];
                $ementa = $_POST['ementa'];

                $sql_5 = "UPDATE disciplina SET nome = '$nome', carga_horaria = '$ch', ementa = '$ementa' WHERE id = '$id'";
                $res_edit2 = mysqli_query($conexao, $sql_5);
                if ($res_edit2 == '')
                  echo "<script language='javascript'>window.alert('Ocorreu um erro tente novamente!');window.location='';</script>";
                else
                  echo "<script language='javascript'>window.alert('Atualização realizada com sucesso!');window.location='cursos_e_disciplinas.php?pg=disciplina';</script>";
              }
            ?>
            <form action="" method="post" name="form1" enctype="multipart/form-data">
              <table width="900" border="0">
                <tr>
                  <td>Nome:</td>
                  <td>Carga Horária:</td>
                </tr>
                <tr>
                  <td><input type="text" name="nome" id="textfield" value="<?php echo $res_2['nome']; ?>"></td>
                  <td><input type="text" name="ch" id="textfield" value="<?php echo $res_2['carga_horaria']; ?>"></td>
                </tr>
                <tr>
                  <td>Ementa:</td>
                </tr>
                <tr>
                  <td><textarea name="ementa" id="textarea" cols="35" rows="5"><?php echo $res_2['ementa']; ?></textarea></td>
                  <td><input type="submit" name="button" class="input" value="Atualizar"></td>
                </tr>
              </table>
          <?php } ?> 
            </form>
      <?php } ?> <!-- Fechamento da função = edita -->
      <!-- FUNCAO ADICIONAR PROFESSOR Á DISCIPLINA -->
      <?php if (@$_GET['func'] == 'disciplina_prof') { ?>
        <hr>
        <h1>Adicionar Professor à Disciplina</h1>

        <?php
          if (isset($_POST['button'])) {
            $id = $_GET['id'];
            $idProfessor = $_POST['professor'];
            $sql_cad_prof_disc = "INSERT INTO professor_disciplina (id_professor, id_disciplina) VALUES ('$idProfessor', '$id')";
            $cad_disc_prof = mysqli_query($conexao, $sql_cad_prof_disc);

            if ($cad_disc_prof == '')
              echo "<script language='javascript'>window.alert('Ocorreu um erro tente novamente!');window.location='';</script>";
            else
              echo "<script language='javascript'>window.alert('Adição realizada com sucesso!');window.location='cursos_e_disciplinas.php?pg=disciplina';</script>";
          }
        ?>
        <form action="" method="post" name="form1" enctype="multipart/form-data">
              <table width="900" border="0">
                <tr>
                  <td>Selecione o Professor:</td>
                </tr>
                <tr>
                  <td>
                    <select name="professor">
                    <?php
                      $sql_result_prof = "SELECT * FROM professor WHERE nome != ''";
                      $result_rec_prof = mysqli_query($conexao, $sql_result_prof);

                      while ($r3 = mysqli_fetch_assoc($result_rec_prof)) { ?>
                        <option value="<?php echo $r3['id']; ?>"><?php echo $r3['nome']; ?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><input type="submit" name="button" class="input" value="Adicionar"></td>
                </tr>
              </table>
          </form>
      <?php } ?>
    </div> <!-- Fechamento da div box_disciplina -->
  <?php } ?> <!-- Fechamento da pg = disciplina -->
  <?php require "footer.php"; ?>
</body>
</html>
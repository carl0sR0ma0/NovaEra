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
              <td><strong>Disciplinas:</strong></td>
            </tr>
            <?php while ($res_1 = mysqli_fetch_assoc($consulta)) { $idTurma = $res_1['id']; ?>
            <tr>
              <td><h3><?php echo $res_1['id']; ?></h3></td>
              <td><h3><?php echo $res_1['descricao']; ?></h3></td>
              <td><h3>
              <?php
                  $sql_busca_disc = "SELECT * FROM disciplina";
                  $result_busca_disc = mysqli_query($conexao, $sql_busca_disc);
                  
                  if (mysqli_num_rows($result_busca_disc) > 0) {
                    while ($res_busca_disciplina = mysqli_fetch_assoc($result_busca_disc)) {
                      $idDisciplina = $res_busca_disciplina['id'];
                      $sql_busca_disci_turma = "SELECT * FROM disciplina_turma WHERE id_turma = '$idTurma' AND id_disciplina = '$idDisciplina'";
                      $resul_busca_disc = mysqli_query($conexao, $sql_busca_disci_turma);
                      while ($res_busca2 = mysqli_fetch_assoc($resul_busca_disc)) {
                        echo " - " .$res_busca_disciplina['nome'] ;
                      }
                    }
                  } else ?>
                  <a href="turma.php?pg=todos&func=turma_disc&id=<?php echo $res_1['id']; ?>"><img src="img/plus.png" title="Adicionar Disciplina" border="0"></a>
                  <a href="cursos_e_disciplinas.php?pg=disciplina&func=disciplina_profrem&id=<?php echo $res_busca['id']; ?>"><img src="img/menos.png" title="Excluir Professor" border="0"></a>
              </h3></td>
              <td>
                <a class="a" href="turma.php?pg=todos&func=deleta&id=<?php echo $res_1['id']; ?>"><img src="img/deleta.jpg" title="Excluir Turma(a)" width="18" height="20" border="0"></a>
                <a class="a" href="turma.php?pg=todos&func=edita&id=<?php echo $res_1['id']; ?>"><img src="../img/ico-editar.png" title="Editar Turma(a)" width="18" height="20" border="0"></a>
              </td>
            </tr>    
            <?php } ?>
          </table>
          <br>
        <?php } ?>
        <!-- EXCLUSÃO, ATIVAÇÃO E DESATIVAÇÃO -->
        <?php
          if (@$_GET['func'] == 'deleta') {
            $id = $_GET['id'];
      
            $sql_del = "DELETE FROM turma WHERE id = '$id'";
            mysqli_query($conexao, $sql_del);
      
            echo "<script language='javascript'>window.location='turma.php?pg=todos';</script>";
          }
        ?>
        <!-- FUNCAO ADICIONAR DISCIPLINA Á TURMA-->
        <?php if (@$_GET['func'] == 'turma_disc') { ?>
            <hr>
            <h1>Adicionar Disciplina à Turma</h1>

            <?php
              if (isset($_POST['button'])) {
                $id = $_GET['id'];
                $idDisciplina = $_POST['disciplina'];
                $professor = $_POST['professor'];
                $sql_cad_disc_turma = "INSERT INTO disciplina_turma (id_disciplina, id_turma, id_professor) VALUES ('$idDisciplina', '$id', '$professor')";
                $cad_disc_turma = mysqli_query($conexao, $sql_cad_disc_turma);

                if ($cad_disc_turma == '')
                  echo "<script language='javascript'>window.alert('Ocorreu um erro tente novamente!');window.location='';</script>";
                else
                  echo "<script language='javascript'>window.alert('Adição realizada com sucesso!');window.location='turma.php?pg=todos';</script>";
              }
            ?>
            <form action="" method="post" name="form1" enctype="multipart/form-data">
                  <table width="900" border="0">
                    <tr>
                      <td>Selecione a Disciplina:</td>
                      <td>Selecione o Professor:</td>
                    </tr>
                    <tr>
                      <td>
                        <select name="disciplina">
                        <?php
                          $sql_result_disc = "SELECT * FROM disciplina WHERE nome != ''";
                          $result_rec_disc = mysqli_query($conexao, $sql_result_disc);

                          while ($r3 = mysqli_fetch_assoc($result_rec_disc)) { ?>
                            <option value="<?php echo $r3['id']; ?>"><?php echo $r3['nome']; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                      <td>
                        <select name="professor">
                        <?php
                          $sql_result_prof = "SELECT * FROM professor WHERE nome != ''";
                          $result_rec_prof = mysqli_query($conexao, $sql_result_prof);

                          while ($r4 = mysqli_fetch_assoc($result_rec_prof)) { ?>
                            <option value="<?php echo $r4['id']; ?>"><?php echo $r4['nome']; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><input type="submit" name="button" class="input" value="Adicionar"></td>
                    </tr>
                  </table>
              </form>
              <br>
          <?php } ?>
    </div> <!-- FECHAMENTO da box_turma -->
<?php } ?> <!-- FECHAMENTO do pg = 'TODOS' -->
  <!-- CADASTRO DAS TURMAS -->
  <?php if (@$_GET['pg'] == 'cadastra') { ?>
    <div id="cadastra_turma">
        <?php
          if (isset($_POST['button'])) {
            $id = $_POST['id'];
            $turma = $_POST['descricao'];
            $curso = $_POST['curso'];
              
            $sql_2 = "INSERT INTO turma (id, descricao, id_curso) VALUES ('$id', '$turma', '$curso')";
            $cadastra = mysqli_query($conexao, $sql_2);
  
            echo "<script language='javascript'>window.alert('Turma cadastrada com sucesso!');window.location='turma.php?pg=todos';</script>";
          }
        ?>
        <form name="form1" action="" method="post">
          <table width="900" border="0">
            <tr>
              <td>ID:</td>
              <td>Descrição:</td>   
              <td>Curso:</td>          
            </tr>
            <tr>
              <td>
                <input type="text" name="id" id="textfield1">
              </td>
              <td>
                <input type="text" name="descricao" id="textfield2">
              </td>
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
            </tr>
            <tr>
              <td><input class="input" type="submit" name="button" id="button" value="Salvar"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <br>
        </form>
        <br>
      </div> <!-- Fechamento da div cadastra_estudante -->    
  <?php } ?> <!-- Fechamento do pg cadastra -->
  <!-- MOSTRAR OS CURSOS E AS DISCIPLINAS -->
  <?php if (@$_GET['pg'] == 'listaralunosturma') { ?>
    <!-- Fazer a lógica do mostrar cursos e as disciplinas -->
    <a class="a2" href="aluno.php?pg=cadastra&bloco=1">Adicionar Aluno</a>
  <?php } ?>

  <?php require "footer.php"; ?>
</body>
</html>
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
        
    </div> <!-- Fechamento da div box_professores -->
  <?php } ?> <!-- Fechamento da PG todos -->
    </div> <!-- FECHAMENTO DA DIV cadastra_professores -->
  <?php require "footer.php"; ?>
</body>
</html>
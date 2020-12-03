<!DOCTYPE html>
<html lang="p-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ALUNO</title>
  <link rel="stylesheet" href="css/aluno.css">
  <link rel="shortcut icon" href="../img/ico_escola.ico">
</head>
<body>
  <?php require "header.php"; ?>
  <!-- BUSCANDO ALUNOS NO BANCO -->
  <div id="caixa_preta"></div>
  <?php if (@$_GET['pg'] == 'todos') { ?>
    <div id="box_aluno">
      <br><br>
      <a href="aluno.php?pg=cadastra&bloco=1" class="a2">Cadastrar Aluno</a>
      <h1>Alunos que estão cadastrados</h1>
      <?php
        $sql_1 = "SELECT * FROM aluno WHERE nome != ''";
        $consulta = mysqli_query($conexao, $sql_1);
        if (mysqli_num_rows($consulta) == '')
          echo "<h2>Não existe nenhum aluno cadastrado no momento</h2>";
        else { ?>
          <table width="900" border="0">
            <tr>
              <td><strong>Código:</strong></td>
              <td><strong>Nome:</strong></td>
              <td><strong>Turma:</strong></td>
              <td></td>
            </tr>
            <?php while ($res_1 = mysqli_fetch_assoc($consulta)) { ?>
            <tr>
              <td><h3><?php echo $res_1['id']; ?></h3></td>
              <td><h3><?php echo $res_1['nome']; ?></h3></td>
              <td><h3><?php echo $res_1['id_turma']; ?></h3></td>
              <td></td>
              <td>
                <a class="a" href="aluno.php?pg=todos&func=deleta&id=<?php echo $res_1['id']; ?>&id=<?php echo $res_1['id']; ?>"><img src="img/deleta.jpg" title="Excluir Aluno(a)" width="18" height="20" border="0"></a>
              </td>
            </tr>    
            <?php } ?>
          </table>
          <br>
        <?php } ?>
    </div> <!-- FECHAMENTO da box_aluno -->
    <!-- EXCLUSÃO, ATIVAÇÃO E DESATIVAÇÃO -->
    <?php
      if (@$_GET['func'] == 'deleta') {
        $id = $_GET['id'];
        $code = $_GET['code'];
  
        $sql_del = "DELETE FROM aluno WHERE id = '$id'";
        $sql_del2 = "DELETE FROM login WHERE code = '$code'";
        mysqli_query($conexao, $sql_del);
        mysqli_query($conexao, $sql_del2);
  
        echo "<script language='javascript'>window.location='aluno.php?pg=todos';</script>";
      }
    ?>

    <?php
      if (@$_GET['func'] == 'ativa') {
        $id = $_GET['id'];
        $code = $_GET['code'];

        $sql_editar = "UPDATE aluno SET status = 'Ativo' WHERE id = '$id'";
        $sql_editar2 = "UPDATE login SET status = 'Ativo' WHERE code = '$code'";
        mysqli_query($conexao, $sql_editar);
        mysqli_query($conexao, $sql_editar2);

        echo "<script language='javascript'>window.location='aluno.php?pg=todos';</script>";
      }
    ?>

    <?php
      if (@$_GET['func'] == 'inativa') {
        $id = $_GET['id'];
        $code = $_GET['code'];

        $sql_editar3 = "UPDATE aluno SET status = 'Inativo' WHERE id = '$id'";
        $sql_editar4 = "UPDATE login SET status = 'Inativo' WHERE code = '$code'";
        mysqli_query($conexao, $sql_editar3);
        mysqli_query($conexao, $sql_editar4);

        echo "<script language='javascript'>window.location='aluno.php?pg=todos';</script>";
      }
    ?>
  <?php } ?> <!-- FECHAMENTO do pg = 'TODOS' -->
  <!-- CADASTRO DOS aluno - ETAPA 1 -->
  <?php if (@$_GET['pg'] == 'cadastra') { ?>
    <?php if (@$_GET['bloco'] == '1') { ?>
      <div id="cadastra_aluno">
        <?php
          if (isset($_POST['button'])) {
            $code = $_POST['id'];
            $nome = $_POST['nome'];
            $turma = $_POST['turma'];
              
            $sql_2 = "INSERT INTO aluno (id, nome, turma) VALUES ('$code', '$nome', '$turma')";
            $cadastra = mysqli_query($conexao, $sql_2);
  
            echo "<script language='javascript'>window.alert('Dados cadastrados com sucesso! Click em OK para avançar');window.location='aluno.php?pg=todos';</script>";
          }
        ?>
        <form name="form1" action="" method="post">
          <table width="900" border="0">
            <tr>
              <td>ID:</td>
              <td>Nome:</td>
              <td>Turma:</td>             
            </tr>
            <tr>
              <td>
                <label for="textfield1"></label>
                <input type="text" name="id" id="textfield1">
              </td>
              <td>
                <label for="textfield2"></label>
                <input type="text" name="nome" id="textfield2">
              </td>
              <td width="143">
                <select name="turma">
                    <?php
                        $sql_result_turma= "SELECT * FROM turma WHERE id != ''";
                        $result_req_turma= mysqli_query($conexao, $sql_result_turma);

                        while ($r3 = mysqli_fetch_assoc($result_req_turma)) { ?>
                            <option value="<?php echo $r3['id'];?>"> <?php echo $r3['descricao'];?></option>
                        <?php }?>
                </select>
              </td>
            </tr>           
            <tr>
              <td><input class="input" type="submit" name="button" id="button" value="Avançar"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </form>
        <br>
      </div> <!-- Fechamento da div cadastra_estudante -->
    <?php } ?> <!-- Fechamento da bloco 1 -->
    <!-- CADASTRADO DOS aluno - ETAPA 2 -->
    <?php if (@$_GET['bloco'] == '2') { ?>
      <div id="cadastra_aluno">
        <h1>2º Passo - Finalizar peenchimento de dados</h1>

        <?php
          if (isset($_POST['button'])) {
            $code = $_GET['code'];
            $serie = $_POST['serie'];
            $turno = $_POST['turno'];
            $cuidado_especial = $_POST['cuidado_especial'];
            $mensalidade = $_POST['mensalidade'];
            $vencimento = $_POST['vencimento'];
            $tel_cobranca = $_POST['tel_cobranca'];
            $obs = $_POST['obs'];

            $sql_3 = "UPDATE aluno SET serie = '$serie', turno = '$turno', atendimento_especial = '$cuidado_especial', mensalidade = '$mensalidade', vencimento = '$vencimento', tel_cobranca = '$tel_cobranca', obs = '$obs' WHERE code = '$code'";
            mysqli_query($conexao, $sql_3);

            $d = date("d");
            $m = date("m");
            $a = date("Y");
            $code_cobranca = $code*2;

            $sql_mensal = "INSERT INTO mensalidades (code, matricula, d_cobranca, vencimento, valor, status, dia, mes, ano) VALUES ('$code_cobranca', '$code', '$d/$m/$a', '$vencimento/$m/$a', '$mensalidade', 'Aguarda Pagamento', '$d', '$m', '$a')";
            
            mysqli_query($conexao, $sql_mensal);

            echo "<script language='javascript'>window.location='aluno.php?pg=cadastra&bloco=3';</script>";
          }
        ?>
        <form name="form1" method="post" action="">
          <table width="900" border="0">
            <tr>
              <td width="350">Série que este aluno vai se matricular:</td>
              <td width="332">Turno:</td>
              <td width="204">Cuidado Especial:</td>
            </tr>
            <tr>
              <td>
                <select name="serie" id="serie">
                  <?php
                  $sql_4 = "SELECT * FROM cursos";
                  $resultado = mysqli_query($conexao, $sql_4);
                  while ($res_1 = mysqli_fetch_assoc($resultado)) { ?>
                    <option value="<?php echo $res_1['curso']; ?>"><?php echo $res_1['curso']; ?></option>
                  <?php } ?>
                </select>
              </td>
              <td>
                <label for="turno"></label>
                <select name="turno" id="turno" size="1">
                  <option value="Manhã">Manhã</option>
                  <option value="Tarde">Tarde</option>
                  <option value="Noite">Noite</option>
                </select>
              </td>
              <td>
                <label for="cuidade_especial"></label>
                <select name="cuidado_especial" id="cuidado_especial" size="1">
                  <option value="SIM">SIM</option>
                  <option value="NÃO">NÃO</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Valor da mensalidade:</td>
              <td>Data de vencimento:</td>
              <td>Telefone de cobrança:</td>
            </tr>
            <tr>
              <td>
                <label for="mensalidade"></label>
                <input type="text" name="mensalidade" id="mensalidade">
              </td>
              <td>
                <label for="vencimento"></label>
                <input type="text" name="vencimento" id="vencimento">
              </td>
              <td>
                <label for="tel_cobranca"></label>
                <input type="text" name="tel_cobranca" id="tel_cobranca">
              </td>
            </tr>
            <tr>
              <td>Observações para este (a) aluno (a):</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3">
                <label for="obs"></label>
                <textarea name="obs" id="obs" cols="45" rows="5"></textarea>
              </td>
            </tr>
            <tr>
              <td><input class="input" type="submit" name="button" id="button" value="Finalizar"></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </form>
        <br>
      </div> <!-- Fechamento da div cadastra_estudante -->
    <?php } ?> <!-- Fechamento da bloco 2 -->
    <!-- CADASTRADO DOS aluno - ETAPA 3 -->
    <?php if (@$_GET['bloco'] == '3') { ?>
      <div id="cadastra_aluno">
        <h1>3º Passo - Mensagem de confirmação</h1>
        <table>
          <tr>
            <td>
              <h4>
                Este (a) Estudante foi cadastrado perfeitamente no sistema!
                <ul>
                  <li>Mensalmente será gerado a cobrança no valor informado!</li>
                  <li>Este (a) estudante já tem acesso ao sistema usando seu código e seu CPF como senha!</li>
                </ul>
                <a href="aluno.php?pg=todos">Clique aqui para voltar para página inicial</a>
              </h4>
            </td>
          </tr>
        </table>
        <br><br><br><br><br><br><br><br><br><br><br>
      </div> <!-- Fechamento da div cadastra_estudante -->
    <?php } ?> <!-- Fechamento da bloco 2 -->
  <?php } ?> <!-- Fechamento do pg cadastra -->
  <?php require "footer.php"; ?>
</body>
</html>
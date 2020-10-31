<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/header.css">
  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="../js/lightbox.js"></script>
  <link rel="stylesheet" href="../css/lightbox.css">

  <link rel="stylesheet" typ="text/css" href="../jquery.superbox.css" media="all">
  <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script> -->
  <script type="text/javascript" src="../jquery.superbox-min.js"></script>
  <script type="text/javascript">
    $(function () {
      $superbox.settings = {
        closeTxt: "Fechar",
        loadTxt: "Carregando...",
        nextTxt: "Next",
        prevTxt: "Previous"
      };

      $.superbox();
    });
  </script>
  <?php include "../conexao.php"; ?>
</head>
<body>
  <div id="box_topo">
    <div id="logo">
      <a href="index.php"><img src="../img/logo-novaera.png" width="250"></a>
    </div>
  </div>

  <div id="box_menu">
    <div id="menu_topo">
      <ul>
        <img src="img/separador_menu.png" />
        <li><a href="">CURSOS E DISCIPLINAS</a>
          <ul>
            <li><a href="cursos_e_disciplinas.php?pg=curso">Cadastrar Curso</a></li>
            <li><a href="cursos_e_disciplinas.php?pg=disciplina">Cadastrar Disciplina</a></li>
            <li><a href="cursos_e_disciplinas.php?pg=cursoedisciplina">Cursos & Disciplinas</a></li>
          </ul>
        </li>
        <img src="img/separador_menu.png" />
        <li><a href="professores.php?pg=todos">PROFESSORES</a></li>
        <img src="img/separador_menu.png" />
        <li><a href="estudantes.php?pg=todos">ESTUDANTES</a></li>
        <img src="img/separador_menu.png" />
        <li><a href="">RELATÓRIOS</a>
          <ul>
            <li><a href="">Alunos</a></li>
            <li><a href="">Professores</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</body>
</html>
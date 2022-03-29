<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

  <!-- Begin Navbar -->
  <div id="nav">
    <div class="navbar navbar-inverse navbar-fixed-top" data-spy="affix" data-offset-top="100">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="inicio.php"><img class="img-responsive logo img-thumbnail" src="../img/logo2.png" alt="" width="150px" height="100px"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">

        <ul class="nav navbar-nav navbar-right">

            <li ><a href="inicio.php" style="color: #6aadbd"><span class="glyphicon glyphicon-home"></span> Inicio</a>
            </li>
          
          <li class="dropdown">
            <a href="#" style="color: #d16f4b" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span> Gestão Produtos <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="categorias.php">Categorias</a></li>
              <li><a href="produtos.php">Produtos</a></li>
              <li><a href="fornecedores.php">Fornecedores</a></li>
            </ul>
          </li>


           <li><a href="clientes.php" style="color: #e303fc"><span class="glyphicon glyphicon-user"></span> Clientes</a>
          </li>
          <li><a href="vendasDeProdutos.php" style="color: #e306fc"><span class="glyphicon glyphicon-usd"></span> PDV</a>
          </li>
          <!--
          <li><a href="vendas.php" style="color: #61e89c"><span class="glyphicon glyphicon-usd"></span>Vendas</a>
          </li> -->

          <li class="dropdown">
            <a href="#" style="color: #61e89c" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-usd"></span> Gestão Vendas <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="pagamentos.php">Pagamentos</a></li>
              <li><a href="comandas.php">Abrir Comanda</a></li>
              <li><a href="vendasRelatorios.php">Lista de Vendas</a></li>
            </ul>
          </li>
          
          <li class="dropdown" >
            <a href="#" style="color: #19d1cb"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Usuário   <span class="caret"></span></a>
            <ul class="dropdown-menu">
              
              <?php if($_SESSION['usuario']['cargo'] == "1"):  ?>
              <li> <a href="usuarios.php">Gestão Usuários</a></li>
              <?php endif; ?>

              <li> <a style="color: red" href="../procedimentos/sair.php"><span class="glyphicon glyphicon-off"></span> Sair</a></li>
              
            </ul>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
    <!--/.contatiner -->
  </div>
</div>
<!-- Main jumbotron for a primary marketing message or call to action -->





<!-- /container -->        

</body>
</html>
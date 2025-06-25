<?php
session_start();


// Conexão
$host = "localhost";
$db = "projetooleo";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit;
}

$tipo = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : null;
$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Novolhar - Processamento de Óleo</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/modal.css">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

  <header>
    <div class="container header-wrapper">
      <div class="logo">
          <h1>
            <img src="img/logo_1.png" alt="Logo Novolhar">
        </h1>
      </div>
      <nav>
        <ul class="nav-links">
          <li><a href="#inicio" class="nav-link" active>Início</a></li>
          <li><a href="#servicos" class="nav-link">Serviços</a></li>
          <li><a href="#contato" class="nav-link">Contato</a></li>
        </ul>

        <?php if(!$tipo):?>
          <button class="btn-open-modal btnlogin" data-modal="modal-1">Login</button>
          
          <?php else:?>
            <div class="logado">
              <p class="usuario">Olá, <?php echo $nome?></p>
              <button class="btn-open-modal btnlogin" data-modal="modal-8">Excluir conta</button>
              <p class="link"><a href="php/logout.php">Sair</a></p>
            </div>
        <?php endif; ?>
      </nav>
    </div>

    <?php
      if ($tipo == 'usuario') {
          include 'barra_usuario.php';
      } elseif ($tipo == 'empresa') {
          include 'barra_empresa.php';
      }
    ?>
  </header>
  

  <!-- Seção principal com chamada para ação -->
  <section class="hero" id="inicio">
    <div class="container hero-content">
      <h2>Junte-se a nós para ajudar a preservar o meio ambiente</h2>
      <p>Nós da Novolhar estamos comprometidos em preservar os nossos recursos naturais.</p>
      <a href="#" class="btn-cta">Junte-se a nós</a>
    </div>
  </section>

  <section>
    <div class="container">
      <h3 class="sobre"><span>O que é a Novolhar?</span></h3>
      <p>A Novolhar é uma empresa dedicada ao processamento de óleo de cozinha usado, transformando-o em produtos sustentáveis e contribuindo para a preservação do meio ambiente. Nosso objetivo é reduzir o descarte inadequado de óleo, promovendo a reciclagem e a conscientização sobre a importância desse recurso.</p>
  </section>

  <!-- Seção de serviços -->
  <section class="servicos" id="servicos">
    <h3>Conheça os <span>NOSSOS SERVIÇOS</span></h3>
    <div class="container service-grid">
      <div class="service-card">
        <img src="img/oleo_1.png" alt="Cadastro de residência">
        <h4>Entregue o seu óleo para ser coletado</h4>
        <p>Clique aqui e disponibilize o seu óleo usado para a realização da coleta</p>
        <button class="btn-open-modal" data-modal="modal-3">Cadastrar usuario</button>
      </div>

      <div class="service-card">
        <img src="img/oleo_2.png" alt="Cadastro de empresa">
        <h4>Realize coletas de óleo em residências</h4>
        <p>Retire os volumes de óleo disponibilizados pelas residências</p>
        <button class="btn-open-modal" data-modal="modal-2">Cadastrar empresa</button>
      </div>

      <div class="service-card">
        <img src="img/oleo_3.png" alt="Deixe sua opinião">
        <h4>Queremos saber a sua opinião</h4>
        <p>Escreva para a gente e dê sua opinião sobre o modelo de negócio</p>
      </div>
      <div class="service-card">
        <img src="img/oleo_4.png" alt="O que produzir com óleo reciclado">
        <h4>O que pode ser feito com óleo reciclado?</h4>
        <p>Saiba o que pode ser feito a partir do processamento do óleo reciclado</p>
      </div>
    </div>
  </section>
  
  <div class="divisor"></div>

  <!-- Seção educativa -->
  <section class="info container">
    <div class="info-content">
      <img src="img/img_2.jpg" alt="Por que reciclar óleo">
      <div class="text">
        <h3>Por que você deve <span>RECICLAR O ÓLEO DE COZINHA UTILIZADO</span></h3>
        <p>O descarte inadequado, como jogá-lo no ralo da pia ou no lixo comum, contamina a água, o solo e pode causar problemas de entupimento nas redes de esgoto. Além disso, o óleo reciclado pode ser transformado em diversos produtos, como biodiesel, sabão e resinas, contribuindo para uma economia mais circular.</p>
        <a href="#" class="btn-secondary">Saiba mais</a>
      </div>
    </div>
  </section>

  <!-- Formulário de contato -->
  <section class="contact" id="contato">
  <div class="container contact-wrapper">
    
    <!-- Coluna esquerda: texto -->
    <div class="contact-info container">
      <h3>Tem alguma dúvida?<span>ENTRE EM CONTATO CONOSCO</span></h3>
      <p>
        Ficaremos felizes em poder ajudar você a tirar as suas dúvidas quanto ao nosso processo de trabalho, como trabalhamos para ajudar o meio ambiente, ou mesmo sobre qual quer outro assunto sobre o qual você queira falar.
      </p>
    </div>

    <!-- Coluna direita: formulário -->
    <form class="contact-form container">
      <div class="form-row">
        <input type="text" placeholder="Nome*" required>
        <input type="text" placeholder="Sobrenome*" required>
      </div>
      <input type="email" placeholder="E-mail*" required>
      <textarea placeholder="Mensagem*" required></textarea>
      <button type="submit" class="btn-submit">Enviar</button>
    </form>
  </div>
</section>

  <!-- Rodapé -->
  <footer>
    <div class="container footer-content">
      <div class="footer-logo">
        <img src="img/logo_2.png" alt="Logo Novolhar">
      </div>
      <p class="copyright">© Copyright – Todos os direitos reservados</p>
      <div class="social">
        <a href="https://www.facebook.com"><img src="img/facebook.svg" alt="Facebook"></a>
        <a href="https://www.instagram.com"><img src="img/instagram.svg" alt="Instagram"></a>
        <a href="https://www.linkedin.com.br"><img src="img/linkedin.svg" alt="LinkedIn"></a>
      </div>
    </div>
  </footer>


  <!-- ========== ++++++++++++MODAIS+++++++++++++++ ============== -->

  <!-- =============== MODAL PARA FAZER LOGIN ==================== -->
  <dialog id="modal-1">
    <form action="php/login.php" method="post">
    <h3 class="titulo">Faça o login</h3>

    <div class="modal-form">
      <p><input type="email" name="email" placeholder="Email" required></p>
      <p><input type="password" name="senha" placeholder="Senha" required></p>
    </div>
    <p class="tipo">
      <input type="radio" name="tipo" value="usuario" required checked> Usuário
      <input type="radio" name="tipo" value="empresa" required> Empresa
    </p>
    <div class="modal-actions">
      <p><input type="submit" value="Entrar"></p>
      <button type="button" class="btn-close-modal" data-modal="modal-1">Cancelar</button>
    </div>
    </form>
    
  </dialog>

 <!-- ================== MODAL PARA CADASTRAR EMPRESA ================= -->
 <dialog id="modal-2">
    <h3 class="titulo">Cadastro de empresa</h3>
    <form action="php/empresa/cadastrar_empresa.php" method="post">
      <div class="modal-form">
        <p><input type="text" name="nome_fantasia" placeholder="Nome fantasia*" required></p>
        <p><input type="text" name="logradouro_empresa" placeholder="Logradouro*" required></p>
        <p><input type="email" name="email_empresa" placeholder="Email*" required></p>
        <p><input type="password" name="senha" placeholder="Senha*" required></p>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn-close-modal" data-modal="modal-2">Cancelar</button>
        <p><input type="submit" value="Registar empresa"></p>
      </div>
    </form>
  </dialog>

  <!-- ================== MODAL PARA CADASTRAR USUARIO ================= -->
  <dialog id="modal-3">
    <h3 class="titulo">Cadastro de usuário</h3>
    <form action="php/usuario/cadastrar_usuario.php" method="post">
      <div class="modal-form">
        <p><input type="text" name="nome" placeholder="Nome*" required></p>
        <p><input type="text" name="logradouro_usuario" placeholder="Logradouro*" required></p>
        <p><input type="email" name="email" placeholder="Email*" required></p>
        <p><input type="password" name="senha" placeholder="Senha*" required></p>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn-close-modal" data-modal="modal-3">Cancelar</button>
        <p><input type="submit" value="Cadastrar"></p>
      </div>
    </form>
  </dialog>
<!-- =============== MODAL PARA EXCLUIR CONTA ==================== -->
  <dialog id="modal-8">
    <h3 class="titulo">Certeza que deseja excluir sua conta?</h3>
    <form action="php/excluir_conta.php" method="post">
      <div class="modal-actions">
      <button type="button" class="btn-close-modal" data-modal="modal-3">Cancelar</button>
      <p><input type="submit" value="Confirmar"></p>
      </div>
    </form>
  </dialog>
  <script src="js/modal.js"></script>
</body>
</html>
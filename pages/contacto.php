<?php
require_once 'config/database.php';

$sucesso = '';
$erro = '';

// Buscar serviços para o dropdown (liga a mensagem a um serviço = chave estrangeira)
$stmt = $pdo->query("SELECT id, titulo FROM servicos WHERE ativo = 1 ORDER BY ordem ASC");
$servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// PROCESSAR O FORMULÁRIO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recolher e limpar dados
    $nome      = trim($_POST['nome'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $telemovel = trim($_POST['telemovel'] ?? '');
    $mensagem  = trim($_POST['mensagem'] ?? '');
    // se não escolheu serviço, fica NULL
    $servico_id = !empty($_POST['servico_id']) ? $_POST['servico_id'] : null;

    // VALIDAÇÃO no servidor (não confiar só no JavaScript)
    if (strlen($nome) < 3) {
        $erro = 'O nome deve ter pelo menos 3 caracteres.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Email inválido.';
    } elseif ($mensagem === '') {
        $erro = 'A mensagem não pode estar vazia.';
    } else {
        // INSERT com prepared statement
        $stmt = $pdo->prepare("INSERT INTO mensagens_contacto 
            (nome, email, telemovel, mensagem, servico_id) 
            VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $telemovel, $mensagem, $servico_id]);

        $sucesso = 'Mensagem enviada com sucesso! Em breve entraremos em contacto.';
    }
}
?>

<main class="d-flex flex-column min-vh-100">

    <div class="row mt-5">
        <div class="col-12 big_title">
            <h1>Vamos Conversar</h1>
        </div>
        <div class="col-12">
            <p>Pronto para transformar a sua presença digital?</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h3>Informações de Contacto</h3>
        </div>
    </div>

    <div class="row my-5">
        <div class="col-lg-6 col-md-1 text-start">
            <div>
                <img src="./assets/img/envelope.svg" alt="simbolo_email">
                <p>EMAIL</p>
                <p>contato@miavilaca.com</p>
            </div>
            <hr>
            <div>
                <img src="./assets/img/telephone.svg" alt="simbolo_telefone">
                <p>TELEFONE</p>
                <p>+351 912 345 678</p>
            </div>
            <hr>
            <div>
                <img src="./assets/img/geo-alt.svg" alt="simbolo_localizacao">
                <p>LOCALIZAÇÃO</p>
                <p>Faro | Algarve | Portugal</p>
            </div>
        </div>

        <div class="col-lg-6 col-md-1">

            <!-- FEEDBACK ao utilizador -->
            <?php if ($sucesso): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($sucesso); ?></div>
            <?php endif; ?>
            <?php if ($erro): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>

            <!-- FORMULÁRIO real, agora com <form>, method e action -->
            <form action="index.php?p=contacto" method="POST" onsubmit="return validarForm()">

                <div>
                    <label for="nome">Nome Completo</label>
                    <input type="text" name="nome" class="form-control" id="nome"
                           placeholder="O seu nome" required minlength="3">
                </div>

                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email"
                           placeholder="seu@email.com" required>
                </div>

                <div>
                    <label for="telemovel">Telemóvel</label>
                    <input type="tel" name="telemovel" class="form-control" id="telemovel"
                           placeholder="+351 912 345 678">
                </div>

                <div>
                    <label for="servico_id">Serviço de interesse (opcional)</label>
                    <select name="servico_id" class="form-control" id="servico_id">
                        <option value="">-- Selecione --</option>
                        <?php foreach ($servicos as $s): ?>
                            <option value="<?php echo $s['id']; ?>">
                                <?php echo htmlspecialchars($s['titulo']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="mensagem">Mensagem</label>
                    <textarea class="form-control" name="mensagem" id="mensagem" rows="5"
                              placeholder="Escreva a sua mensagem aqui..." required></textarea>
                </div>

                <button type="submit" id="enviar" class="mia_button mt-3">Enviar</button>
            </form>

        </div>
    </div>



</main>

<?php
require_once 'config/database.php';

// Buscar serviços ativos da base de dados
$stmt = $pdo->prepare("SELECT * FROM servicos WHERE ativo = 1 ORDER BY ordem ASC");
$stmt->execute();
$servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="d-flex flex-column min-vh-100">
    <div class="row mt-5">
        <div class="col-12 big_title">
            <h1>Serviços e Pacotes</h1>
        </div>
        <div class="col-12">
            <p>Escolha o pacote que melhor se adapta às necessidades da sua marca.</p>
        </div>
    </div>

    <div class="row mt-4 d-flex justify-content-center align-items-stretch">
        <?php foreach($servicos as $index => $servico): 
            // Converter características de string para array
            $caracteristicas = explode('|', $servico['caracteristicas']);
        ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card card_hover" style="min-height:550px">
                <div class="card-body d-flex flex-column">
                    <h3 class="card-title"><?php echo htmlspecialchars($servico['titulo']); ?></h3>
                    <h6 class="card-subtitle mb-2 text-body-secondary">
                        <?php echo htmlspecialchars($servico['subtitulo']); ?>
                    </h6>
                    <p class="card-text text-primary fw-bold"><?php echo htmlspecialchars($servico['preco']); ?></p>
                    <p class="card-text"><?php echo htmlspecialchars($servico['descricao']); ?></p>
                    <hr>
                    <ul style="list-style-type: none;" class="p-0">
                        <?php foreach($caracteristicas as $item): ?>
                            <li>✓ <?php echo htmlspecialchars(trim($item)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="mt-auto">
                        <button type="button" class="mia_button w-100 mb-2" data-bs-toggle="modal" 
                                data-bs-target="#modalServico<?php echo $servico['id']; ?>">
                            <?php echo htmlspecialchars($servico['botao_texto']); ?>
                        </button>
                        <a href="index.php?p=contacto">
                            <button type="button" class="mia_button w-100">Pedir mais informações</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal para cada serviço -->
        <div class="modal fade" id="modalServico<?php echo $servico['id']; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reserva - <?php echo htmlspecialchars($servico['titulo']); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Preencha o formulário de contacto para oficializar a sua reserva do pacote <strong><?php echo htmlspecialchars($servico['titulo']); ?></strong>.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="mia_button" data-bs-dismiss="modal">Voltar</button>
                        <a href="index.php?p=contacto">
                            <button type="button" class="mia_button">Confirmar</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Resto do conteúdo igual... -->
    <div class="row m-5"><div class="col-12"><hr></div></div>
    <div class="row text-center mt-5">
        <div class="col-12 big_title"><h1>Precisa de um serviço personalizado?</h1></div>
    </div>
    <div class="row text-center mt-2 mb-5">
        <div class="col-12">
            <a href="index.php?p=contacto"><button type="button" class="mia_button">Solicitar um serviço personalizado</button></a>
        </div>
    </div>

</main>
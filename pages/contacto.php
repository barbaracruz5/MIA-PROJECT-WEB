
<?php
require_once 'config/database.php';
require_once 'vendor/autoload.php';
?>

    <main class="d-flex flex-column min-vh-100">

        <div class="row mt-5">

            <div class="col-12 big_title ">
                <h1>Vamos Conversar</h1>
            </div>

            <div class="col-12">
                <p>Pronto para transformar a sua presença digital?</p>
            </div>

        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h3> Informações de Contacto</h3>
            </div>
        </div>

        <div class="row my-5">
            <div class="col-lg-6 col-md-1 text-start ">

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

                    <p> Faro | Algarve | Portugal</p>

                </div>


            </div>

            <div class="col-lg-6 col-md-1">
                <div class="form">

                    <div>
                        <label for="nome">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" placeholder="O seu nome" required
                            minlength="3">
                    </div>

                    <div>
                        <label for="email">Email </label>
                        <input type="email" class="form-control" id="email" placeholder="seu@email.com" required>
                    </div>

                    <div>
                        <label for="telemovel">Telemóvel </label>
                        <input type="tel" class="form-control" id="telemovel" required placeholder="+351 912 345 678">
                    </div>

                    <div>
                        <label for="mensagem">Mensagem</label>
                        <textarea class="form-control" id="mensagem" rows="5"
                            placeholder="Escreva a sua mensagem aqui..." required></textarea>
                    </div>

                    <button type="submit" id="enviar" class="mia_button mt-3" onclick="validarForm()">Enviar</button>

                </div>


            </div>
        </div>

        <a href="contacto.html" class="up">
            <img src="./assets/img/arrow-up.svg" alt="seta">
        </a>

    </main>

    
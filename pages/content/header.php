    <header>

        <!--NAVBAR-->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Mariana Vilaça</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav  mb-2 mb-lg-0  ms-auto ">
                        <li class="nav-item">
                            <a class="nav-link <?php if ($p == 'inicio') echo 'active'; ?>" aria-current="page" href="inicio.php">Página Inicial</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($p == 'quemSou') echo 'active'; ?>" href="quemSou.php">Quem sou</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($p == 'comoTrabalho') echo 'active'; ?>" href="comotrabalho.php">Como trabalho</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($p == 'servicos') echo 'active'; ?>" href="servicos.php">Serviços</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($p == 'contacto') echo 'active'; ?>" href="contacto.php">Contacto</a>
                        </li>


                    </ul>

                </div>
            </div>
        </nav>

        <!--END NAVBAR-->

    </header>
# MIA Social Hub

Website institucional e sistema de gestão para uma profissional de gestão de redes sociais (Mariana Vilaça). O site público apresenta serviços, portfólio e formulário de contacto; 
o painel administrativo permite gerir serviços e consultar as mensagens recebidas.

## Tema escolhido

Plataforma de apresentação de serviços com área administrativa — gestão de uma marca pessoal de social media, com captação de contactos através do site e gestão desses contactos num painel privado.

## Tecnologias utilizadas

- **HTML** — estrutura das páginas
- **CSS** — estilos e responsividade (`assets/css/style.css`)
- **Bootstrap** — layout, grelha e componentes (navbar, cards, modais)
- **JavaScript** — validação de formulários no lado do cliente (`assets/js/main.js`)
- **PHP** — lógica back-end
- **MySQL Workbench** — base de dados


### Site público
- Página inicial, Quem sou, Como trabalho, Portfólio, Serviços e Contacto
- Sistema de routing através de `index.php?p=<pagina>`
- Cabeçalho, rodapé e botão "voltar ao topo" reutilizados em todas as páginas
- Página de serviços gerada dinamicamente a partir da base de dados
- Formulário de contacto que grava as mensagens na base de dados, com validação no cliente (JavaScript) e no servidor (PHP)

### Área administrativa (`/admin`)
- Registo de administrador (com `password_hash`)
- Login / logout com gestão de sessões (`$_SESSION`)
- Proteção de páginas privadas (redireciona para o login se não autenticado)
- Dashboard com contagem de mensagens não lidas
- CRUD completo de **Serviços** (criar, listar, editar, apagar)
- CRUD completo de **Mensagens de contacto** (listar, marcar como lida, apagar) com `JOIN` à tabela de serviços

## Base de dados

Base de dados `mia_socialhub` com três tabelas relacionadas:

- `administradores` — contas de acesso ao painel
- `servicos` — pacotes de serviços apresentados no site
- `mensagens_contacto` — mensagens enviadas pelo formulário, com chave estrangeira `servico_id` que referencia `servicos(id)`

A relação entre `mensagens_contacto` e `servicos` permite, no painel, mostrar a que serviço cada mensagem diz respeito (consulta com `LEFT JOIN`).


## Segurança

- Prepared statements (PDO) em todas as consultas à base de dados
- Sanitização de dados apresentados ao utilizador com `htmlspecialchars`
- Validação de inputs no servidor
- Senhas guardadas encriptadas com `password_hash`
- Proteção das páginas administrativas através de sessões

## Limitações e ideias futuras
- Possibilidade de adicionar gestão de portfólio pela área administrativa (atualmente os trabalhos estão fixos no código).
- Envio de email automático a notificar a chegada de novas mensagens.
- Paginação na listagem de mensagens quando o volume crescer.

## Autoria

Projeto desenvolvido no âmbito do módulo de Desenvolvimento Web (back-end).


## Script utilizado no Mysq Workbench 

CREATE DATABASE mia_socialhub;

CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);


CREATE TABLE servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    subtitulo VARCHAR(150),
    preco VARCHAR(50),
    descricao TEXT,
    caracteristicas TEXT,       
    botao_texto VARCHAR(50) DEFAULT 'Reservar',
    ativo TINYINT(1) DEFAULT 1,
    ordem INT DEFAULT 0
);


CREATE TABLE mensagens_contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telemovel VARCHAR(30),
    mensagem TEXT NOT NULL,
    servico_id INT,              
    lida TINYINT(1) DEFAULT 0,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (servico_id) REFERENCES servicos(id) ON DELETE SET NULL
);

## Projeto armazenado no git 
https://github.com/barbaracruz5

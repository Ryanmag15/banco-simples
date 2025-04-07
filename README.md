Este projeto é uma aplicação Laravel que utiliza Docker para criar um ambiente de desenvolvimento completo e padronizado. Ele conta com suporte ao banco de dados MySQL, além de utilizar migrations e seeders para estruturar e popular o banco de dados automaticamente.

🧰 Tecnologias Utilizadas
Laravel: framework PHP moderno e robusto para construção de APIs e aplicações web.

Docker: ferramenta que permite criar containers isolados para rodar a aplicação e seus serviços.

Docker Compose: orquestrador que facilita a configuração e o gerenciamento de múltiplos containers.

MySQL: sistema de gerenciamento de banco de dados relacional, usado para armazenar os dados da aplicação.

🚀 Iniciando o Projeto
Para iniciar o ambiente, é necessário ter o Docker instalado. Com isso feito, você pode subir a aplicação executando o seguinte comando na raiz do projeto:

docker compose up -d --build

Esse comando irá:

Construir os containers definidos no arquivo docker-compose.yml.
Subir os serviços (como o container do Laravel e o container do MySQL) em segundo plano (-d).
Garantir que o ambiente esteja pronto para uso com as configurações corretas.
Após os containers estarem em funcionamento, você poderá acessar o container da aplicação Laravel para:
Instalar as dependências do projeto
Gerar a chave da aplicação
Executar as migrations
Rodar os seeders para popular o banco
O uso do Docker garante que o projeto funcione da mesma forma em qualquer máquina, sem necessidade de configurar o PHP, Composer ou o MySQL localmente.

Dentro do container da aplicação Laravel, execute os seguintes comandos:
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed


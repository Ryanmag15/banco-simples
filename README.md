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


# 📦 Projeto Laravel com Docker

Este projeto é uma aplicação **Laravel** containerizada com **Docker**, ideal para desenvolvimento local padronizado, independente de sistema operacional.  
Ele oferece um ambiente completo com **MySQL** como banco de dados, e uso de **migrations** e **seeders** para estruturação e popularização automática do banco.

---

## 🧰 Tecnologias Utilizadas

| Tecnologia       | Descrição                                                                 |
|------------------|---------------------------------------------------------------------------|
| **Laravel**      | Framework PHP moderno e elegante para desenvolvimento de aplicações web. |
| **Docker**       | Plataforma para criação de containers, isolando o ambiente de execução.   |
| **Docker Compose** | Orquestrador de containers, facilita configuração e gerenciamento.       |
| **MySQL**        | Sistema de banco de dados relacional utilizado para persistência.         |
| **Composer**     | Gerenciador de dependências PHP.                                          |

---

## 📁 Estrutura do Projeto

```
.
├── app/                     # Código da aplicação Laravel
├── database/                # Migrations e seeders
├── docker/                  # Arquivos de configuração Docker (opcional)
├── .env                     # Arquivo de variáveis de ambiente
├── docker-compose.yml       # Definição dos serviços Docker
├── Dockerfile               # Instruções para construção do container Laravel
└── README.md                # Documentação do projeto
```

---

## ⚙️ Requisitos

Antes de começar, é necessário ter instalado:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- (Opcional) [Make](https://www.gnu.org/software/make/) para automatizar comandos

---

## 🚀 Subindo o Ambiente

Com Docker instalado, execute na raiz do projeto:

```bash
docker compose up -d --build
```

Esse comando:

- Constrói os containers com base no `Dockerfile`
- Inicializa os serviços definidos em `docker-compose.yml` (ex: Laravel, MySQL)
- Executa os containers em segundo plano (`-d`)

> ✅ Aguarde até que todos os serviços estejam com status "healthy" antes de prosseguir.

---

## 🛠️ Configuração Inicial da Aplicação

Acesse o container da aplicação Laravel com o comando:

```bash
docker exec -it <nome_container_laravel> bash
```

Dentro do container, execute os comandos abaixo para finalizar a configuração da aplicação:

### 1. Instalar dependências do Laravel
```bash
composer install
```

### 2. Gerar chave da aplicação
```bash
php artisan key:generate
```

### 3. Rodar as migrations
```bash
php artisan migrate
```

### 4. Rodar os seeders (popular o banco)
```bash
php artisan db:seed
```

> 💡 Dica: Você pode combinar comandos usando `&&` se quiser executar tudo de uma vez.

---

## 🔍 Variáveis de Ambiente

As configurações do Laravel e Docker são controladas pelo arquivo `.env`.  
Certifique-se de configurar as variáveis corretamente. Exemplo de `.env`:

```dotenv
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```

---

## 🔄 Comandos Úteis

| Ação                            | Comando                                                  |
|---------------------------------|-----------------------------------------------------------|
| Subir os containers             | `docker compose up -d --build`                            |
| Acessar o container Laravel     | `docker exec -it <nome_container> bash`                  |
| Parar os containers             | `docker compose down`                                    |
| Ver logs em tempo real         | `docker compose logs -f`                                 |
| Rodar comandos Artisan diretamente | `docker compose exec app php artisan <comando>`         |

---

## ✅ Verificação

Após configurar tudo corretamente:

- A aplicação estará acessível em [http://localhost](http://localhost)
- O banco de dados MySQL estará disponível via `localhost:3306`
- Você poderá rodar comandos Artisan, Composer e acessar o Tinker normalmente via container

---

## 🧪 Testando a Aplicação

Você pode testar se a aplicação está funcionando acessando a rota padrão ou criando uma rota de teste no `routes/web.php`:

```php
Route::get('/teste', function () {
    return 'Laravel está funcionando!';
});
```

---

## 🧼 Encerrando o Ambiente

Quando terminar o uso, você pode parar o ambiente com:

```bash
docker compose down
```

> Use `docker compose down -v` se quiser remover também os volumes (dados do banco serão apagados).

---

## 📚 Referências

- [Laravel Documentation](https://laravel.com/docs)
- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

## 🤝 Contribuindo

Sinta-se livre para abrir issues ou pull requests caso queira contribuir com melhorias no projeto.

---

## 📝 Licença

Este projeto está licenciado sob a [MIT License](LICENSE).

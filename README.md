
<h1>Instalação</h1>

- Necessário instalar [Composer](https://getcomposer.org) 
- Fazer o clone do projeto
- Renomear o arquivo `.env.example` para `.env`e configurar as variáveis de banco de dados `DB_...`
- Executar o comando `composer install`
- Executar o comando `php artisan key:generate`
- Executar o comando `php artisan migrate`
- Executar o comando `php artisan db:seed`
- Executar o comando `php artisan serve`

<h1>Sincronização de jogos</h1>

- Necessário criar uma conta na [twitch](https://www.twitch.tv)
- Configurar a conta para utilizar a API [IGDB](https://api-docs.igdb.com/#account-creation)
- Executar o comando `php artisan vendor:publish --provider="MarcReichel\IGDBLaravel\IGDBLaravelServiceProvider"`
- Configurar as variáveis `TWITCH_CLIENT_ID` e `TWITCH_CLIENT_SECRET` no arquivo [config/igdb.php](https://github.com/marcreichel/igdb-laravel#basic-installation)

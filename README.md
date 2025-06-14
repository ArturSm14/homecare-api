
# HomeCare Api

### Passo a passo
Clone Repositório
```sh
git clone https://github.com/ArturSm14/homecare-api.git
```

```sh
cd homecare-api/
```


Crie o Arquivo .env
```sh
cp .env.example .env
```


Suba os containers do projeto
```sh
docker-compose up -d
```


Acessar o container
```sh
docker-compose exec app bash
```


Instalar as dependências do projeto
```sh
composer install
```


Gerar a key do projeto Laravel
```sh
php artisan key:generate
```

Rodar as migrations
```sh
php artisan migrate
```

Acessar o projeto
[http://localhost:8989](http://localhost:8989)


### Acessando o RabbitMQ e Executando Filas

Acessar o painel de administração do RabbitMQ
```
http://localhost:15672
```
Credenciais padrão:
- Usuário: guest
- Senha: guest

Executar o worker para processar as filas
```sh
docker-compose exec app php artisan queue:work rabbitmq
```

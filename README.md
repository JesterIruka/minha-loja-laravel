# minha-loja-laravel
Meu primeiro projeto pós-curso de laravel

Minha especialidade não é front end, então toda a parte de design ficou inteiramente por parte do Bootstrap 4.
Meu objetivo principal foi trabalhar com backend, faltando é claro várias melhorias que estou disposto a atualizar através de pull requests.

Sinta-se à vontade para utilizar mesmo sem créditos e/ou modificar o que precisar para se aplicar às suas necessidades.

# Setup da loja

Para criar um usuário e testar basta rodar o comando
```
php artisan db:seed
```
Isto criará um usuário `root@domain.com` com a senha `123` e cargo Administrador 

### Features pendentes

- Fazer com que funcionários apenas consigam alterar o estoque
- Calcular frete **PAC/SEDEX/JADLOG** e **Frete Fixo** configurável

### Features concluídas

- Checar o rastreamento da encomenda para alterar o status da venda
- Mostrar todas as fotos de um produto ao invés de somente a primeira e possuir uma navegação para selecionar a imagem em maior escala.
- Criar função de alterar uma variação (nome, preço, estoque)
- Implementar PagSeguro

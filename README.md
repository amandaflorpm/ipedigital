# Desafio Ipê Digital

Projeto de um e-commerce desenvolvido para a [Ipê Digital](http://ipe.digital). Inspirado nas aulas de PHP 7 disponíveis em [Udemy](https://www.udemy.com/course/curso-php-7-online).


# [English] Ipê Digital Challenge

An e-commerce project developed to [Ipê Digital](http://ipe.digital). Inspirated by the PHP 7 lessons available in [Udemy](https://www.udemy.com/course/curso-php-7-online).


# Alguns recursos utilizados: [English] Requires:

- [XAMPP](https://www.apachefriends.org/pt_br/index.html): Módulos Apache e MySQL
- [MySQL](https://www.mysql.com/) Workbench
- [Composer](https://getcomposer.org/)
- [Template Almsaeed Studio](https://almsaeedstudio.com)
- [RainTPL](https://github.com/feulf/raintpl3)
- [Slim Framework](http://www.slimframework.com/)
- [PHPMailer](https://github.com/PHPMailer/PHPMailer)

# Orientações:

- [DB](https://github.com/amandaflorpm/ipedigital/tree/master/db) utilizado inicialmente
- Passo a passo da configuração do domínio virtual no windows em: [vhoststeps](https://github.com/amandaflorpm/ipedigital/tree/master/ipedigital/vhoststeps)
- O arquivo [composer](https://github.com/amandaflorpm/ipedigital/blob/master/composer.json) contém as dependências do projeto (Framework Slim, Template Rain, phpmailer) e o autoload das classes. Executem o comando "composer update" no Git Bash para instalá-los.
- As classes que configuram páginas, login, produtos, db e outros módulos do projeto estão em [sources](https://github.com/amandaflorpm/ipedigital/tree/master/vendor/hcodebr/php-classes/src)
- Conexão ao DB: [cr/DB](https://github.com/amandaflorpm/ipedigital/tree/master/vendor/hcodebr/php-classes/src/DB)

# Observações:

- Cada commit tem o comentário do que foi feito em inglês (mais acessibilidade).

- Resolvi entregar incompleto pois não queria estender mais o prazo, porém vou continuar desenvolvendo-o (quero aprender tudo que o curso propõe).

- Projeto final, o que é?
Um e-commerce completo (back e front) com admin e site, cadastro de usuários, produtos, vendas, geração de boletos, cálculo de frete, criptografia de senhas,etc.

- O que precisei aprender e por quanto tempo?
8 a 10 horas aprendendo composer, classes, framework, rotas, template, conexão ao db, virtual hosts, git...

- O que codei e por quanto tempo?
8 a 10 horas:
Conexão ao DB, virtual hosts, composer, template e autoload do projeto em geral. Classes, templates e rotas das páginas (site e admin) e login do admin.

- Próximos passos: Usuários, Grupos de Produtos, Produtos, Carrinho de Compras, Pedidos, Boletos, CEP, Frete, Hospedagem.

- Expectativa de tempo para finalizá-lo a partir de hoje (18/11/19): 
15 a 20 horas (deixe-me ser otimista)

PHP RabbitMQ Consumer Microservice

Este microsserviço PHP foi projetado para atuar como um consumidor de mensagens RabbitMQ, demonstrando a integração com um broker de mensagens, utilizando Programação Orientada a Objetos (POO) e seguindo princípios de DevOps para facilidade de deployment e manutenção. Ele é ideal para processamento assíncrono de tarefas, desacoplando serviços e aumentando a resiliência da sua arquitetura.

Explicação da Estrutura:

`src/`: Contém o código-fonte principal da aplicação.
`Consumer.php`: A classe principal responsável por conectar ao RabbitMQ e consumir mensagens.
`MessageProcessor.php`: Uma classe de exemplo para processar as mensagens recebidas, mantendo a lógica de negócio separada do transporte.
`Config.php`: Classe para gerenciar a configuração da aplicação, lendo variáveis de ambiente.
`vendor/`: Diretório para dependências do Composer. Gerado automaticamente.
`.env.example`: Exemplo de arquivo para variáveis de ambiente.
`Dockerfile`: Define como construir a imagem Docker do microsserviço.
`docker-compose.yml`: Orquestra o microsserviço junto com um servidor RabbitMQ para ambiente de desenvolvimento.
`composer.json`: Define as dependências PHP do projeto.
`composer.lock`: Gerado pelo Composer, garante que as mesmas versões das dependências sejam usadas por todos.
`consume.php`: O script de entrada que inicia o consumidor RabbitMQ.
`README.md`: Este arquivo, com a documentação do projeto.


 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

PHP (versão 8.0 ou superior)
Composer
Docker e Docker Compose


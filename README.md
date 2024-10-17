# Sistema de Saldo

O **Sistema de Saldo** é uma aplicação desenvolvida utilizando Laravel e Vue.js para gerenciar transações financeiras como **Entradas**, **Saídas** e **Transferências**. O sistema inclui funcionalidades de filtro, paginação, exportação de relatórios e um dashboard com visão geral do saldo e transações.

## Funcionalidades

- **Gestão de Transações**: Registro de transações financeiras, como **Entradas** (depósitos), **Saídas** (saques) e **Transferências**.
- **Histórico de Transações**: Exibição do histórico de transações com filtros por **data**, **tipo de transação** e **nome de usuário**.
- **Dashboard**: Resumo com o saldo atual, número total de transações, entradas, saídas e últimas 5 transações.
- **Exportação de Dados**: Exportação de relatórios de transações para formatos **XLS** e **PDF**.
- **Paginação**: Navegação entre páginas do histórico de transações.
- **Filtros Avançados**: Filtro de transações por data, tipo de transação (Entrada, Saída, Transferência) e usuário.
  
## Tecnologias Utilizadas

- **Backend**: Laravel 9 (PHP 8)
- **Frontend**: Vue.js 3 com Inertia.js
- **Estilos**: TailwindCSS
- **Banco de Dados**: MySQL 8
- **Outras Dependências**:
  - Composer
  - Node.js (npm/yarn para gerenciamento de pacotes)
  - Exportação para XLS e PDF usando bibliotecas adequadas

## Instalação

### Pré-requisitos

- PHP 8+
- Composer
- Node.js (npm ou yarn)
- MySQL 8
- Git

### Passos

1. Clone o repositório:

   git clone https://github.com/seu-usuario/sistema-de-saldo.git  
   cd sistema-de-saldo

2. Instale as dependências do PHP:

   composer install

3. Instale as dependências do JavaScript:

   npm install

4. Configure o arquivo `.env`:

   - Copie o arquivo de exemplo:

     cp .env.example .env

   - Configure as credenciais do banco de dados e outras variáveis de ambiente conforme necessário.

5. Gere a chave da aplicação Laravel:

   php artisan key:generate

6. Execute as migrações para criar as tabelas no banco de dados:

   php artisan migrate

7. Compile os assets do frontend:

   npm run dev

8. Inicie o servidor:

   php artisan serve

## Uso

- Acesse a aplicação em `http://localhost:8000`.
- Use os botões de **Entrada**, **Saída** e **Transferência** para adicionar novas transações.
- Filtre o histórico de transações por data, tipo ou usuário para encontrar registros específicos.
- Exporte os dados de transações usando os botões de exportação.

## Estrutura de Banco de Dados

### Tabela: `balances`

| Campo        | Tipo      | Descrição                |
|--------------|-----------|--------------------------|
| `id`         | INT       | Identificador único       |
| `user_id`    | INT       | ID do usuário relacionado |
| `amount`     | DECIMAL   | Valor atual do saldo      |
| `created_at` | TIMESTAMP | Data de criação           |
| `updated_at` | TIMESTAMP | Data de atualização       |

### Tabela: `historics`

| Campo                | Tipo      | Descrição                             |
|----------------------|-----------|---------------------------------------|
| `id`                 | INT       | Identificador único                   |
| `user_id`            | INT       | ID do usuário que fez a transação     |
| `type`               | CHAR(1)   | Tipo de transação ('I', 'O', 'T')     |
| `amount`             | DECIMAL   | Valor da transação                    |
| `user_id_transaction`| INT       | ID do usuário para transferências     |
| `created_at`         | TIMESTAMP | Data da transação                     |

## Funcionalidades de Exportação

O sistema permite a exportação dos dados de transações nos seguintes formatos:

- **XLS**: Exporta uma planilha com todos os registros filtrados.
- **PDF**: Exporta um relatório em PDF das transações filtradas.

## Contribuição

Sinta-se à vontade para contribuir com o projeto! Para contribuir:

1. Faça um fork do repositório.
2. Crie uma branch com a sua feature ou correção de bug (`git checkout -b minha-feature`).
3. Faça o commit das suas mudanças (`git commit -am 'Adiciona minha feature'`).
4. Envie um push para a branch (`git push origin minha-feature`).
5. Crie um novo Pull Request.

## Licença

Este projeto está licenciado sob a **MIT License**.

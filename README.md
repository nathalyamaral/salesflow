# README - SalesFlow

## 🚀 Sobre o Projeto
SalesFlow é uma API desenvolvida em **Laravel**, utilizando a arquitetura **DDD + Hexagonal**, seguindo **PSR-1 e PSR-12**, **Clean Code**, **SOLID**, com ambiente totalmente **Dockerizado** e testes automatizados com **PHPUnit + Code Coverage**.

## 📦 Tecnologias Utilizadas
- **Laravel 10** (Framework PHP)
- **Docker + Docker Compose** (Ambiente isolado)
- **MySQL 8** (Banco de Dados)
- **MailHog** (Teste de e-mails)
- **PHPUnit + Pest** (Testes automatizados)
- **PHPStan + PHP-CS-Fixer** (Análise estática e formatação de código)

---

## 🔧 Instalação e Configuração
### **1️⃣ Pré-requisitos**
Antes de começar, certifique-se de ter instalado:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/)

### **2️⃣ Clonar o repositório**
```bash
git clone SEU_REPOSITORIO.git
cd salesflow
```

### **3️⃣ Executar o Setup**
O projeto possui um **script automatizado** para instalação e configuração:
```bash
chmod +x setup
./setup
```

Isso fará:
✅ Subir os containers Docker.
✅ Instalar as dependências do Laravel.
✅ Criar o banco de dados e rodar migrações.
✅ Gerar a chave de aplicação e limpar o cache.

---

## 🚀 Executando o Projeto
Após rodar o `setup`, a API estará disponível em:
🔗 **http://localhost:8000**

📬 **Mailhog (Testar e-mails)**: [http://localhost:8025](http://localhost:8025)

---

## 🔍 Rodando Testes e Code Coverage
Para rodar os testes e gerar o relatório de cobertura de código:
```bash
docker exec -it salesflow_app php artisan test --coverage-html=storage/coverage
```
Acesse o relatório gerado:
```bash
xdg-open storage/coverage/index.html # Para Linux
open storage/coverage/index.html     # Para macOS
```

---

## 📜 Estrutura do Projeto (DDD + Hexagonal)
```
app/
├── Application/        # Casos de uso e regras de aplicação
│   ├── UseCases/
│   ├── DTOs/
│   ├── Services/
│
├── Domain/             # Entidades e lógica de negócio
│   ├── Entities/
│   ├── Repositories/
│   ├── ValueObjects/
│
├── Infrastructure/     # Comunicação externa (DB, Email, Framework)
│   ├── Persistence/
│   ├── Mail/
│   ├── Framework/
│
├── Tests/              # Testes unitários e integração
```

---

## 🛠️ Troubleshooting
Caso o projeto não inicie corretamente, tente:
```bash
docker-compose down -v
./setup
```
Se ainda houver problemas, rode manualmente:
```bash
docker exec -it salesflow_app php artisan config:clear
docker exec -it salesflow_app php artisan cache:clear
docker exec -it salesflow_app php artisan migrate --seed
```

---

## 📌 Configuração Manual (Caso necessário)
### Criar banco de dados manualmente
Se o banco não for criado automaticamente:
```bash
docker exec -it salesflow_db mysql -u root -proot -e "CREATE DATABASE salesflow;"
```

### Rodar migrações manualmente
```bash
docker exec -it salesflow_app php artisan migrate --seed
```

---

## 📄 Licença
Este projeto está sob a licença MIT. Sinta-se livre para utilizá-lo e contribuir! 😊

---

## 🔥 Contato
📧 Email: nathalyamaral07@gmail.com
💼 LinkedIn: [nathaly](https://linkedin.com/in/nathalyamaral)

---

## 🚀 Autor
👩‍💻 Nome do Desenvolvedor - [GitHub](https://github.com/nathalyamaral)

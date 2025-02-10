# SalesFlow

SalesFlow é uma aplicação full-stack para gestão de vendas e vendedores. O backend é construído com Laravel e o frontend utiliza Vue.js. A aplicação é totalmente dockerizada e conta com suporte a filas, cache e jobs assíncronos.

## Tecnologias Utilizadas

### Backend:
- **Linguagem**: PHP 8.2
- **Framework**: Laravel
- **Banco de Dados**: MySQL 8
- **Servidor Web**: Apache
- **Sistema de Filas**: Redis + Laravel Queue
- **Cache**: Redis
- **Jobs Assíncronos**: Laravel Queues
- **Serviço de E-mail**: MailHog (para desenvolvimento)
- **Docker**: Contêinerização completa para facilitar o ambiente de desenvolvimento

### Frontend:
- **Framework**: Vue.js 3 + Vite
- **Gerenciador de Rotas**: Vue Router
- **Consumo de API**: Fetch API
- **Estilização**: CSS puro

## APIs Implementadas
A API do SalesFlow fornece os seguintes endpoints:

### **Vendedores**
- `POST /api/sellers` - Cadastra um novo vendedor
- `GET /api/sellers` - Lista todos os vendedores

### **Vendas**
- `POST /api/sales` - Cadastra uma nova venda
- `GET /api/sales/{seller_id}` - Lista todas as vendas de um vendedor
- `GET /api/sales/{seller_id}?date=YYYY-MM-DD` - Lista as vendas de um vendedor filtrando por data

### **Relatórios**
- Um job é executado diariamente às 23h59 para enviar por e-mail um relatório com a soma das vendas do dia para cada vendedor.
- O job pode ser disparado manualmente através da interface no frontend.

## Testes e Conformidade com Padrões
O projeto segue as boas práticas de desenvolvimento, incluindo:
- **Testes Unitários** e **Testes de Integração**
- **Cobertura de Código** com PHPUnit
- **Conformidade com PSR-12** para padronização do código

### Comandos para Rodar os Testes e Verificar Conformidade
```bash
# Rodar testes unitários e de integração
cd backend
./composer test

# Gerar relatório de cobertura de código
cd backend
./composer coverage
```

## Instruções de Execução

### 1. Clonar o Repositório
```bash
git clone https://github.com/nathalyamaral/salesflow.git
cd salesflow
```

### 2. Configurar Permissões no Script de Setup
Antes de executar o script de setup, conceda permissões de execução:
```bash
chmod +x setup.sh
```

### 3. Rodar o Script de Setup
Esse script irá:
- Criar e subir os containers Docker
- Instalar dependências do backend e frontend
- Copiar arquivos `.env`
- Rodar migrações e seeders
```bash
./setup.sh
```

### 4. Acessar a Aplicação
Após a execução do script, os serviços estarão disponíveis nos seguintes endereços:
- **Frontend**: http://localhost:5173/
- **Backend**: http://localhost:8000/
- **MailHog** (para visualizar e-mails enviados): http://localhost:8025/

### 5. Testando a API
Para testar as APIs, pode-se utilizar ferramentas como Insomnia, Postman ou simplesmente cURL no terminal.

### 6. Executando Jobs Manualmente
Para rodar o job de envio de relatório manualmente, acesse a interface no frontend e clique no botão correspondente ou execute o seguinte comando dentro do container do backend:
```bash
docker exec -it salesflow_backend php artisan queue:work
```

---

## 📖 Documentação da API (Swagger)

A API do SalesFlow segue o padrão OpenAPI 3.0 e possui uma documentação interativa gerada com Swagger.
Após rodar o setup, acesse:

🔗 **URL:** [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

### **Exemplo de Especificação OpenAPI**
```json
{
  "openapi": "3.0.0",
  "info": {
    "title": "SalesFlow API",
    "description": "Documentação da API do SalesFlow para gestão de vendedores e vendas.",
    "version": "1.0.0"
  },
  "servers": [
    {
      "url": "http://localhost:8000/api",
      "description": "Servidor local"
    }
  ],
  "paths": {
    "/sellers": {
      "get": {
        "summary": "Lista todos os vendedores",
        "operationId": "getSellers",
        "tags": ["Sellers"],
        "responses": {
          "200": {
            "description": "Lista de vendedores",
            "content": {
              "application/json": {
                "schema": {
                  "type": "array",
                  "items": {
                    "$ref": "#/components/schemas/Seller"
                  }
                }
              }
            }
          }
        }
      },
      "post": {
        "summary": "Cadastra um novo vendedor",
        "operationId": "createSeller",
        "tags": ["Sellers"],
        "requestBody": {
          "required": true,
          "content": {
            "application/json": {
              "schema": {
                "$ref": "#/components/schemas/Seller"
              }
            }
          }
        },
        "responses": {
          "201": {
            "description": "Vendedor cadastrado com sucesso"
          }
        }
      }
    },
    "/sales/{seller_id}": {
      "get": {
        "summary": "Lista todas as vendas de um vendedor",
        "operationId": "getSalesBySeller",
        "tags": ["Sales"],
        "parameters": [
          {
            "name": "seller_id",
            "in": "path",
            "required": true,
            "schema": {
              "type": "integer"
            }
          },
          {
            "name": "date",
            "in": "query",
            "required": false,
            "schema": {
              "type": "string",
              "format": "date"
            },
            "description": "Filtra as vendas por data (YYYY-MM-DD)"
          }
        ],
        "responses": {
          "200": {
            "description": "Lista de vendas",
            "content": {
              "application/json": {
                "schema": {
                  "type": "array",
                  "items": {
                    "$ref": "#/components/schemas/Sale"
                  }
                }
              }
            }
          }
        }
      }
    }
  },
  "components": {
    "schemas": {
      "Seller": {
        "type": "object",
        "properties": {
          "id": {
            "type": "integer"
          },
          "name": {
            "type": "string"
          },
          "email": {
            "type": "string",
            "format": "email"
          }
        }
      },
      "Sale": {
        "type": "object",
        "properties": {
          "id": {
            "type": "integer"
          },
          "seller_id": {
            "type": "integer"
          },
          "amount": {
            "type": "number",
            "format": "float"
          },
          "commission": {
            "type": "number",
            "format": "float"
          },
          "date": {
            "type": "string",
            "format": "date-time"
          }
        }
      }
    }
  }
}

Este README fornece um guia completo para o setup e execução do projeto. 🚀

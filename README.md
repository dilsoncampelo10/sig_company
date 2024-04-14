# Documentação de API

## Companies:

### GET - /api/companies 

- Resposta Com todas as empresas

### GET - /api/companies/{id}

- Resposta Com a empresa do id enviado

### POST - /api/companies 

- Envia no corpo da requisição um json com dados da empresa e o id do sócio, exemplo:

{	
	"name": "Vox ",
	"cnpj": "99.999.999/9999-99",
	"site": "http://www.voxtecnologia.com.br/",
	"phone": "(83) 3031-0123",
	"partner_id": 1
}


### PUT - /api/companies/{id}

- Envia no corpo da requisição um json com dados da empresa e o id por parâmetro da url

### DELETE - /api/companies/{id}

- Envia o id por parâmetro para exclusão


## Partner:

### GET - /api/companies 

- Resposta Com todas os sócios

### GET - /api/companies/{id}

- Resposta Com o sócio do id enviado

### POST - /api/companies 

- Envia no corpo da requisição um json com dados do sócio

{
	"name":"Fulano",
	"email":"fulano@gmail.com",
	"password": "123456"
}

### PUT - /api/companies/{id}

- Envia no corpo da requisição um json com dados do sócio e o id por parâmetro da url

### DELETE - /api/companies/{id}

- Envia o id por parâmetro para exclusão


### POST - /api/login

- Envia o e-mail e senha do sócio e recebe o próprio sócio e o token jwt
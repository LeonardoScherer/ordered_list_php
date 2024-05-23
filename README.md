# Documentação
###### Este sistema oferece uma funcionalidade de ordenação de listas, permitindo aos usuários enviar uma lista de palavras e receber essa lista ordenada. O sistema pode ser acessado via uma API onde você envia um JSON ou através de uma interface web onde você pode enviar um arquivo com palavras separadas por vírgulas.

### Funcionalidades
<li>Ordenação de Lista via API: Envia um JSON com uma lista de palavras e recebe a lista ordenada.</li>
<li>Ordenação de Lista via Interface Web: Envia um arquivo contendo palavras separadas por vírgulas e recebe a lista ordenada.</li>

### Instalação


```
git clone https://github.com/LeonardoScherer/ordered_list_php
```

### Interface Web
<p>Acessando a URL raiz (/), você poderá fazer o upload de um arquivo .txt contendo palavras separadas por vírgulas para ordenar a lista.</p>
<p>Passos para Ordenação</p>

<li>
Acesse a URL /.
</li>
<li>
Faça o upload de um arquivo .txt contendo palavras separadas por vírgulas. 
</li>
<p>Exemplo de conteúdo do arquivo:</p>

```
uva, banana, amora
```

### API
<li>URL raiz (/)</li>
<li>Método: POST</li>
<li>Headers: Content-Type: application/json</li>
<li>Body: { "data": ["banana", "uva", "amora"] }</li>
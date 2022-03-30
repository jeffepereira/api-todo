## Api ToDo

Este projeto visa disponibilizar uma **api** para gerenciamento de To-dos.

Para facilitar e viablizar a execução deste projeto em máquinas que não possuam dependências de desenvolvimento, foi usado a ferramenta Kool, que cria containers com os **presets** necessários.

Instalação, rápida e prática 👇

-   [Kool](https://kool.dev/docs/getting-started/installation) ❤️

Para subir o ambiente, execute o **_comando_** abaixo na raiz do projeto. ⚙

```
kool run setup
```

Este comando deverá ser executado apenas uma vez. Quando for necessário derrubar ou subir os containers novamente, os **_comandos_** abaixo deverão ser usados. 🏃‍♂💨

```
kool start 🛫
kool stop  🛬
```

Caso queira verificar o **_status_** dos containers este é o comando. 📡

```
kool status
```

Para rodar os **_testes_** 🛠

```
kool run phpunit
```

### Api

Url da api >> http://0.0.0.0:8199

Na raiz do projeto se encontra um arquivo de `Collection` do `Postman` para facilitar o **teste**. 😎

`Api_Todo_Postman.json`

#### Modelos de retorno do _resource_

###### _SHOW_

`http://0.0.0.0:8199/1`

```json
{
    "data": {
        "id": 1,
        "type": "todo",
        "attributes": {
            "title": "Primeira tarefa",
            "description": "Contratar internet",
            "finished_at": "2023-01-01 14:59:54",
            "created_at": "2022-03-30 04:10:15",
            "updated_at": "2022-03-30 04:10:15"
        }
    }
}
```

###### _INDEX_

`http://0.0.0.0:8199/`

```json
{
    "data": [
        {
            "id": 1,
            "type": "todo",
            "attributes": {
                "title": "Primeira tarefa",
                "description": "Comprar material de escritório",
                "finished_at": "2021-08-22 09:24:37",
                "created_at": "2022-03-30 04:05:54",
                "updated_at": "2022-03-30 04:05:54"
            }
        },
        {
            "id": 2,
            "type": "todo",
            "attributes": {
                "title": "Segunda tarefa",
                "description": "Levar criança na escola",
                "finished_at": null,
                "created_at": "2022-03-30 04:10:15",
                "updated_at": "2022-03-30 04:10:15"
            }
        }
    ]
}
```

###### _INDEX_ com paginate

`http://0.0.0.0:8199?paginate=10`

```json
{
    "data": [
        {
            "id": 1,
            "type": "todo",
            "attributes": {
                "title": "Primeira tarefa",
                "description": "Comprar material de escritório",
                "finished_at": "2021-08-22 09:24:37",
                "created_at": "2022-03-30 04:05:54",
                "updated_at": "2022-03-30 04:05:54"
            }
        }
        ...
    ],
    "links": {
        "first": "http://0.0.0.0:8199?page=1",
        "last": "http://0.0.0.0:8199?page=2",
        "prev": null,
        "next": "http://0.0.0.0:8199?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 2,
        "links": [
            {
                "url": null,
                "label": "pagination.previous",
                "active": false
            },
            {
                "url": "http://0.0.0.0:8199?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": "http://0.0.0.0:8199?page=2",
                "label": "2",
                "active": false
            },
            {
                "url": "http://0.0.0.0:8199?page=2",
                "label": "pagination.next",
                "active": false
            }
        ],
        "path": "http://0.0.0.0:8199",
        "per_page": 10,
        "to": 10,
        "total": 20
    }
}
```

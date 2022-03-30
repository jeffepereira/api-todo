## Api ToDo

Este projeto visa disponibilizar uma **api** para gerenciamento de To-dos.

Para facilitar e viablizar a execução deste projeto em máquinas que não possuam dependências de desenvolvimento, foi usado a ferramenta Kool, que cria containers com os **presets** necessários.

Instalação, rápida e prática 👇

-   [Kool](https://kool.dev/docs/getting-started/installation)

Para subir o ambiente, execute o **comando** abaixo na raiz do projeto.

```
kool run setup
```

Este comando deverá ser executado apenas uma vez. Quando for necessário derrubar ou subir os containers novamente, os **comandos** abaixo deverão ser usados.

```
kool start
kool stop
```

Caso queira verificar o **status** dos containers este é o comando.

```
kool status
```

Para rodar os testes

```
kool run phpunit
```

### Api

Retornos do **resource**

_SHOW_

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

_INDEX_

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
            "id": 1,
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

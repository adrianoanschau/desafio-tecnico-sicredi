# Desafio Técnico Sicredi - por Adriano Anschau

## Sobre o Desafio
```
 No cooperativismo, cada associado possui um voto e as decisões são tomadas em assembleias, por votação.
 A partir disso, você precisa criar uma solução back-end para gerenciar essas sessões de votação.
 Essa solução deve ser executada na nuvem e promover as seguintes funcionalidades através de uma API
 REST:
 ● Cadastrar uma nova pauta;
 ● Abrir uma sessão de votação em uma pauta (a sessão de votação deve ficar aberta por um tempo
 determinado na chamada de abertura ou 1 minuto por default);
 ● Receber votos dos associados em pautas (os votos são apenas 'Sim'/'Não'. Cada associado é
 identificado por um id único e pode votar apenas uma vez por pauta);
 ● Contabilizar os votos e dar o resultado da votação na pauta.
 ```

## Requisitos

Linguagens/Tecnologias:
- PHP 7.2 (linguagem principal)
- PHPUnit (testes unitários automatizados)
- OpenAPI - Swagger (documentação de API) 

## Links
- [Documentação da API](http://desafio-tecnico-sicredi.herokuapp.com/api/v1/documentation)
- [API em modo Produção](https://desafio-tecnico-sicredi.herokuapp.com/api/v1)
- [Repopsitório](https://gitlab.com/adrianoanschau/desafio-tecnico-sicredi)

## A Solução

#### Modelos/Entidades

- **Schedule** - Representa cada Pauta;
- **Associate** - Representa os Associados;
- **ScheduleSession** - Representa as sessões de votação abertas para cada Pauta;
- **Vote** - Representa os votos adicionados para cada sessão de votação

**Obs.:** Na dúvida sobre a possibilidade de cada Pauta poder ou não ter mais do que uma sessão de votação, desenvolvi para que houvesse a possibilidade de existir mais do que uma sessão de votação por pauta, porém, para esta primeira versão, a aplicação não permite a criação de uma segunda sessão para a mesma pauta. Desta forma, para uma nova versão, adicionar esta funcionalidade se torna facilitada, pois a aplicação já está preparada para este recurso.

### A Aplicação

- **Criação de uma nova Pauta**: O usuário cria uma nova pauta adicionando título e descrição;
- **Abertura de sessão de votação**: Uma nova sessão de votação é aberta para uma pauta existente, adicionando-se um tempo limite para que a mesma fique aberta, caso o tempo não seja informado, o valor de 60 segundos (1 minuto) é definido como padrão.
- **Fechamento de sessão de votação**: Uma sessão é fechada automaticamente após transcorrido o tempo previamente definido, comuso da referência de data de abertura acrescido do tempo em segundos definido para tempo de abertura.
- **Cadastro prévio de Associados**: Um associado pode ser previamente cadastrado no sistema, com nome e documento (CPF) pára o seu registro
- **Voto em uma sessão**: O voto em uma sessão de votação pode ser feito com a opção: SIM ou NÃO, juntamente com a identificação do Associado, sendo este por referência ou apenas com o número do documento, em caso de associado previamente cadastrado no sistema. Também é possível votar com informações de um usuário que ainda não está cadastrado, neste caso informa-se o Nome e o Documento (CPF) e o mesmo será automaticamente cadastrado e seu voto contabilizado.
- **Validação de Documento**: Toda tentativa de inserção de cadastro de Associado, o seu documento de CPF é validado.

### A Validação do CPF

O sistema, internamente, realizada validação do documento (CPF) do candidato a Associado, caso o documento não esteja válido, a sua solicitação é recusada.
Em caso positivo, o mesmo é inserido no sistema e a sua solicitação é processada.

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Explain

Como não foi possível eu tirar dúvidas ao longo do período que estive desenvolvendo, por que fiz ao longo do fim de semana e ontem a noite escrevi alguns testes, eu identifiquei que apenas através dos dois endpoints e métodos sugeridos no escopo do teste não seria possível atender o requisito de páginação. Então implementei a API com 3 recursos que foram os seguintes:

- Recurso para retornar lista de News com limite de 10 resultados e número de páginas disposíveis exemplo: [localhost:8000/api/news](localhost:8000/api/news).
- Recurso de News por página onde é possível informar o número da página que deseja requisitar exemplo: [localhost:8000/api/news/page/1](localhost:8000/api/news/page/1).
- Recurso para retornar uma news por seu id interno fornecido nos atributos quando listado exemplo: [localhost:8000/api/news/1](localhost:8000/api/news).

Optei por não fazer uso de banco de dados por se tratar de uma consulta em uma fonte de dados de terceiros, o custo para aplicação trazer os dados para uma database interna nesse cenário é muito alta e faz pouco sentido, a minha estratégia foi implementar as ordenações e paginações direto no serviço implementado para fazer a busca e realizar um cache desses dados com uma expiração de 15 minutos só para fins de teste.

## Arquitetura

Eu busquei isolar toda a lógica em uma camada de regras de negócios, tentando deixar o controller do laravel responsável apenas por tratar a requisição, conforme se recomenda nas melhores práticas de aplicação do padrão MVC de arquitetura.

Para isso criei uma classe de domain denominada FeedService que é injetada no controller para prover os métodos relacionados com as regras de negócio da aplicação, claro que cabe um refactor sempre para buscar um isolamento melhor das responsabilidades mas busquei deixar os métodos o mais atômicos e reutilizáveis possível. Tem uma pequena gambiarra usando o encode e decode do objeto gerado pela classe SimpleXMLElement(), mas se trata de um arranjo técnico para não precisar deserializar o objeto para usar o store default do cache que é o sistema de arquivos porque teria que reverter o processo no recuperar o dado, nesse cenário se costuma usar o redis como store com a library pre/redis para fazer o trabalho de serializar e deserializar os arrays e objetos para o store, mas por com uma questão de não agregar complexidade no setup preferi deixar o store padrão usando o driver file. 

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Contato e feedbacks

Qualquer dúvida ou sugestão pode entrar em contato no meu email pessoal via [antonivargas@gmail.com](mailto:antonivargas@gmail.com). Qualquer feedback em relação ao material produzido para este teste será muito bem vindo, ficaria mesmo muito grato pois servirá para eu continuar buscando evoluir minhas aptidões técnicas e crescimento profissional.

## API Documentation

Foi utilizado para produzir esta documentação de referência o [FLATDOC](http://ricostacruz.com/flatdoc/).

# Trabalho de _Test Driven Development_

Neste trabalho, a funcionalidade escolhida para aplicar o método TDD foi
o cadastro de produtos. As demais funcionalidades também foram desenvolvidas
utilizando-se testes, mas no cadastro de produto cuidou-se para manter o histórico
das iterações salvo.

As iterações foram registradas como uma sequência de commits. Assim, pode-se
ver o que foi feito a cada iteração observando-se a diferença de um commit para
o seu antecessor.

Os resultados de cada execução de testes foram registrados no arquivo
_test-results.xml_ no formato _junit_.

O sistema foi desenvolvido utilizando o framework Laravel, que já vem com
ferramentas de testes. Os testes são executados pela ferramenta _phpunit_.

O comando utilizado para executar os testes a cadaiteração foi o seguinte:

```php artisan test --testdox --log-junit test-results.xml```

Link para apresentação do teste de aceitação:

https://youtu.be/0RR17_a0ylI

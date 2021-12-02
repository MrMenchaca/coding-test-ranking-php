## Introducción

Este repositorio contiene un API parcialmente desarrollada para desarrollar un servicio que se encargue de medir la calidad de los anuncios.

Los supuestos están basados en un hipotético *equipo de gestión de calidad de los anuncios*, que demanda una serie de verificaciones automáticas para clasificar los anuncios en base a una serie de características concretas.

## Tecnologías

Se han usado las siguientes tecnologías:

* PHP 8
* Symfony Local Web Server
* Symfony Framework MVC
* Composer
* PHPUnit Testing Framework

## Ejecución

Para llamar a los endpoints se necesita ejecutar el siguiente comando:

* symfony server:start

Las rutas de los endpoints accesibles son las siguientes:
* "/updateAdsScore" -> Actualiza el score de todos los anuncios.
* "/getIrrelevantAds" -> Devuelve los anuncios irrelevantes.
* "/getAllAdsByScore" -> Devuelve los anuncios relevantes ordenados de mayor a menor.

## Diseño

Para la estructura general he usado el patrón MVC (Modelo-Vista-Controlador):

![Alt text](img/Estructura.jpg "Estructura")

Para el diseño del dominio he usado varios patrones:

* **Strategy**. Se aplica en las jerarquías paralelas ITypology y IPicQuality
  - IPicQuality. Encapsula la funcionalidad que relaciona el score con cada calidad de imagen. Al usar este patrón, delegamos en las propias calidades la responsabilidad de saber cuanto score valen ellas mismas. Así, si en un futuro hiciese falta añadir o eliminar calidades  (2K o 4K), no haría falta modificar clases ya existentes. Finalmente, si se diese este supuesto, con esta jerarquía es más intuitivo ver cómo se gestionan las calidades.
  - ITypology. Encapsula la funcionalidad que varía en función del tipo de anuncio. Al usar este patrón, delegamos en los tipos la responsabilidad de saber cómo deben comportarse ante diferentes situaciones.  

* **Singleton**. Se aplica en las clases que hereden de IPicQuality y en InFileSystemPersistence
  - Hd y Sd. Dado que una calidad de imagen no tiene sentido que se pueda crear varias veces, mediante estre patrón conseguimos crear una única instancia.
  - InFileSystemPersistence. Al simular ser una base de datos, la instancia del objeto debería ser siempre la misma.

![Alt text](img/Dominio.jpg "Dominio")


## Otros posibles diseños y problemas

Otros posibles diseños de más general a más concreto son los siguientes:

* **Visitor**. Se usaría para calcular el score de los anuncios. Este patrón se usa cuando necesitamos realizar una operación sobre una estructura de objetos. Lo positivo es que podríamos definir más operaciones a iterar sobre el dominio sin modificar las clases concretas y habría una clara diferenciación. El problema es que, el dominio está en una fase muy temprana y preveo que la estructura sufrirá una modificación continua. Por cada clase concreta añadida o eliminada, habría que modificar cada Visitor. Contando con esto, la solución actual me parece mejor.

* **Typology pase a heredar directamente de Ad**. Es decir, crear una clase abstracta Ad y que cada Typology heredase de esta, consiguiendo clases concretas como AdFlat, AdChalet o AdGarage. Esto podría ahorrarnos el crear una jerarquía paralela en un proyecto tan pequeño, pero si tirasemos por esta estructura, condicionariamos mucho el diseño a futuros cambios. 

* **Composite**. Para la funcionalidad que comprueba si es el anuncio es completo. Podríamos crear una interfaz ICheck, de la que heredase varias clases, una por cada comprobación que queremos hacer y otras que gestionasen de la forma que nosotros escogamos las comprobaciones que nosotros queramos. Como punto fuerte es que podrían modificarse dinamicamente las comprobaciones a relizar. Además se podrían reutilizar las comprobaciones y se vería de una forma más intuitiva con esta jerarquía. El problema es que necesitamos comprobar atributos únicos a cada tipo, por lo que no podríamos generalizar los parámetros a checkear de una forma sencilla.


## Consideraciones

Los siguientes puntos son consideraciones sobre el proyecto:

* Aunque se traten varios tipos de datos, he hecho un unico servicio (AdService). Esto se debe a que, al tener la base de datos en local, cuando obtengo los anuncios, obtengo todos los datos que contiene. Aunque esto en una base de datos real no sucediese, existen métodos mediante los cuales, puedes obtener clases que Ad tiene como atributos. Si esto se usase no haría falta usar mas services ya que de base de datos solo obtenemos datos de otras tablas, no los modificamos.

* Con cada llamada a un endpoint, se actualiza el score de los anuncios. Esto se debe a que la base de datos no es persistente y no se guarda en memoria, por lo que "simulo" que lo hace, actualizando los scores justo antes de obtener los anuncios. 

* En los endpoint devuelvo un html. En una aplicación real, los controladores deberían devolver datos y no la capa de vista. Esto se hace para poder comprobar por pantalla que la funcionalidad se comporta correctamente.

* Para los test he usado recursos de Symfony, que comprueban si en la vista se muestran los elementos que deberían aparecer. De esta forma compruebo que todo el proceso se realiza bien y pasa por todas las capas.

Orientación
==========

Secciones
-------

Las secciones de un template se crean con la funcion **section_*** donde el (*) es el nombre de la seccion que se desea crear, por ejemplo:

    * section_singleline
    * section_multiline
    * section_loop
    * section_image
    * section_gallery
    * section_product
    * etc...
    
Como podemos ver el sufíjo es el nombre de la sección.

Opciones
_____

En la funcion se pueden/deben especificar una serie de opciones, estas aveces varian dependiendo del tipo de seccion que se esté usando.

```html+jinja
{{ section_*(name = null, options = null) }}
```

El argumento name es usado para hacer más especifica una sección, y en las opciones pasamos configuraciones adicionales.

Por ejemplo si tenemos dos secciones de tipo image, pero queremos que cada una tenga una funcionalidad diferente, podemos especializar las secciones dandole un nombre a cada una, con lo cual sería como tener dos secciones diferentes en un mismo template.

Ejemplo:

```html+jinja
<img {{ section_image('principal') }} src="{{ asset("...") }}" />
<img {{ section_image('secundaria') }} src="{{ asset("...") }}" />
```

Acá tenemos dos secciones de tipo image que aunque son del mismo tipo, cada una tiene un nombre diferente, con lo cual podemos hacer que se comporten de forma distinta. y así logramos reusar una sección de diferentes maneras.

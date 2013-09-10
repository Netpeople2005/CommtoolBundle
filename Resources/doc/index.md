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

En la función se pueden/deben especificar una serie de opciones, estas aveces varian dependiendo del tipo de seccion que se esté usando.

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

Creando un Commtool
-------

Para crear un commtool se debe crear una clase que extienda de **\Optime\Bundle\CommtoolBundle\AbstractCommtoolBuilder**

```php
<?php

namespace Optime\Promowin\PromotionsBundle\Commtool;

use Optime\Bundle\CommtoolBundle\AbstractCommtoolBuilder;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Commtool\TemplateBundle\Model\SectionConfigInterface;
use Optime\Promowin\PromotionsBundle\Entity\Product;
use Optime\Promowin\PromotionsBundle\Entity\Promotion;
use Symfony\Component\Templating\Helper\CoreAssetsHelper;

/**
 * Este es un ejemplo del commtool realizado para avaya promowin, en el cual existen 3 secciones:
 * 
 * Una sección singleline para el titulo de la promoción.
 * Una sección multiline para colocar la descripción de la promoción.
 * Y una sección loop que contendrá los productos usados en la promoción.
 *
 */
class CommtoolProduct extends AbstractCommtoolBuilder
{

    /** 
     * Instancia de la promocióp
     * @var Promotion
     */
    protected $promotion;

    /**
     * Esta clase permite crear rutas web hacia imagenes, css, etc...
     * @var CoreAssetsHelper
     */
    protected $assetHelper;

    function __construct(Promotion $promotion, CoreAssetsHelper $assetHelper)
    {
        $this->promotion = $promotion;
        $this->assetHelper = $assetHelper;
    }

    public function build(BuilderInterface $builder, array $options = null)
    {
        $promotion = $this->promotion;
        $commtool = $this;

        //acá agregamos la sección de tipo singleline, llamada title.
        $builder->addNamed('title', 'singleline', array(
            'data' => $promotion->getName(), //pasamos el nombre de la promo a la sección con el título.
        ));
        
        //agregamos la sección de la descripción.
        $builder->addNamed('description', 'multiline', array(
            'is_html' => true,
        ));
        
        //agregamos el loop de productos.
        
        //cuando se agrega un loop, dicho control utiliza el nombre que se le da para saber que tipo de sección se va a repetir en el loop. en este caso la sección/control es product.
        //si en algún momento debemos dar un nombre que no es una sección existente, debemos pasar en la opciones
        //el indice type y un nombre de sección válido.
        
        $builder->addNamed('product', 'loop', array(
            // acá tenemos un ejemplo donde indicamos que el loop es de tipo text.
            //'type' => 'text',
            
            //el indice data puede recibir directamente el valor a usar ó un callback que devuelva el valor.
            //dicho callback recibe tres argumentos:
            // * el valor actual.
            // * el control creado.
            // * la configuración de la sección en BD.
            'data' => function($a, ControlInterface $b, SectionConfigInterface $c)
            use ($promotion, $commtool) { //para este caso la funcion usa la promoción y la instancia de esta misma clase
            
                //la idea es recorrer los productos que posee la promoción y crear un array para luego devolverlo
                //donde dicho array contendrá los valores para cada una de las secciones en el template.
                $promotionProducts = $promotion->getStrategy();

                $data = array();

                $index = 0;
                $currentBu = null;
                $oldBu = null;

                foreach ($promotionProducts as $promoProduct) {
                    $product = $promoProduct->getProduct();

                    $currentBu = $product->getCategory()->getBusinessUnits();
                    if (!$oldBu) {
                        $oldBu = $currentBu;
                    } elseif ($oldBu !== $currentBu) {
                        $oldBu = $currentBu;
                        $index++;
                    }

                    if (!isset($data[$index])) {
                        $data[$index] = array(
                            'product' => array(
                                'product_name' => $product->getDescription(),
                                'product_image' => $commtool->getProductImage($product),
                            )
                        );
                    }
                    $detail = array(
                        'part_number' => $product->getName(),
                        'reward' => $promoProduct->getValue(),
                        'points' => $promoProduct->getWinpoints(),
                    );
                    $data[$index]['product']
                            ['product_detail'][] = array(
                        'product_detail' => $detail
                    );
                }

                return $data;
            },
        ));
    }

    /**
     * Acá indicamos cual plantilla vamos a usar para pintar los controles del commtool.
     */
    public function getLayout()
    {
        return 'PromowinPromotionsBundle:Commtool:product_layout.html.twig';
    }

    /**
     * Esta funcion devuelve la url para la imagen de los productos por unidad de negocio.
     */
    public function getProductImage(Product $product)
    {
        $id = $product->getCategory()->getBusinessUnits()->getExternalId();
        return $this->assetHelper
                        ->getUrl("bundles/promowinpromotions/images/{$id}.jpg");
    }

}
```

y luego obtener una instancia de un template, y en base a esos dos objetos crear el commtool de la siguiente manera:

```php
/**
 * @ParamConverter("template", class="CommtoolTemplateBundle:Template")
 */
public function showEditorAction(Template $template)
{
    $commtool = new PromowinCommtool();
    
    return $this->render('PromowinPromotionsBundle:Promotion:configure/editor.html.twig', array(
                'commtool' => $commtool,
    ));
}
```

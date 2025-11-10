<?php

namespace Sprint\Migration;


class FEB1120250211203042 extends Version
{
    protected $author = "admin";

    protected $description = "";

    protected $moduleVersion = "4.18.0";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $iblockId = $helper->Iblock()->getIblockIdIfExists(
            'catalog',
            'Catalog'
        );

        $helper->Iblock()->addSectionsFromTree(
            $iblockId,
            array (
  0 => 
  array (
    'NAME' => 'Дымоходы',
    'CODE' => 'dymokhody',
    'SORT' => '1',
    'ACTIVE' => 'Y',
    'XML_ID' => NULL,
    'DESCRIPTION' => '',
    'DESCRIPTION_TYPE' => 'html',
    'CHILDS' => 
    array (
      0 => 
      array (
        'NAME' => 'Одностенные',
        'CODE' => 'odnostennye',
        'SORT' => '500',
        'ACTIVE' => 'Y',
        'XML_ID' => NULL,
        'DESCRIPTION' => '',
        'DESCRIPTION_TYPE' => 'html',
      ),
      1 => 
      array (
        'NAME' => 'Двустенные',
        'CODE' => 'dvustennye',
        'SORT' => '500',
        'ACTIVE' => 'Y',
        'XML_ID' => NULL,
        'DESCRIPTION' => '',
        'DESCRIPTION_TYPE' => 'html',
      ),
    ),
  ),
  1 => 
  array (
    'NAME' => 'Аксессуары для бани и камина',
    'CODE' => 'aksessuary-dlya-bani-i-kamina',
    'SORT' => '2',
    'ACTIVE' => 'Y',
    'XML_ID' => NULL,
    'DESCRIPTION' => '',
    'DESCRIPTION_TYPE' => 'html',
    'CHILDS' => 
    array (
      0 => 
      array (
        'NAME' => 'Сетки на трубу',
        'CODE' => 'setki-na-trubu',
        'SORT' => '500',
        'ACTIVE' => 'Y',
        'XML_ID' => NULL,
        'DESCRIPTION' => '',
        'DESCRIPTION_TYPE' => 'html',
      ),
      1 => 
      array (
        'NAME' => 'Решетки вентиляционные',
        'CODE' => 'reshetki-ventilyatsionnye',
        'SORT' => '500',
        'ACTIVE' => 'Y',
        'XML_ID' => NULL,
        'DESCRIPTION' => '',
        'DESCRIPTION_TYPE' => 'html',
      ),
    ),
  ),
  2 => 
  array (
    'NAME' => 'Турбодефлекторы',
    'CODE' => 'turbodeflektory',
    'SORT' => '500',
    'ACTIVE' => 'Y',
    'XML_ID' => NULL,
    'DESCRIPTION' => '<p>Турбодефлектор&nbsp;&mdash; это&nbsp;элемент системы естественной вентиляции, предназначенный для эффективного вытягивания отработанного воздуха из&nbsp;помещения. Конструктивно, он&nbsp;представляет собой комбинацию многолопастного вертикально-осевого ветряка (вариация ротора Савониуса) и&nbsp;центробежного насоса, а&nbsp;работает за&nbsp;счет энергии ветра, без использования электричество.</p>
<p>Ротационный дефлектор усиливает тягу в&nbsp;вентканале и&nbsp;помогает нормализовать циркуляцию воздуха и&nbsp;решить такие проблемы вентиляции как: возникновение обратной тяги (когда воздух всасывается в&nbsp;воздуховод вместо, того чтобы выходить наружу), опрокидывание тяги (изменение направления движения воздуха на&nbsp;противоположное из-за разницы температур), перетягивание тяги в&nbsp;вентиляционных каналах. Втулка из&nbsp;дюралюминия (основной конструкционный авиационный материал) защищает внутреннюю часть дефлектора от&nbsp;обмерзания и&nbsp;коррозии, что увеличивает срок службы изделия.</p>
<p>Дефлектора (диаметром до&nbsp;155&nbsp;мм) используются для вентканалов таких помещений как: бытовые погреба, гаражи, неотапливаемые помещения.</p>',
    'DESCRIPTION_TYPE' => 'html',
    'CHILDS' => 
    array (
      0 => 
      array (
        'NAME' => 'Турбодефлекторы из оцинкованной стали',
        'CODE' => 'turbodeflektory-iz-otsinkovannoy-stali',
        'SORT' => '500',
        'ACTIVE' => 'Y',
        'XML_ID' => NULL,
        'DESCRIPTION' => '',
        'DESCRIPTION_TYPE' => 'html',
      ),
      1 => 
      array (
        'NAME' => 'Турбодефлекторы из нержавеющей стали',
        'CODE' => 'turbodeflektory-iz-nerzhaveyushchey-stali',
        'SORT' => '500',
        'ACTIVE' => 'Y',
        'XML_ID' => NULL,
        'DESCRIPTION' => '',
        'DESCRIPTION_TYPE' => 'html',
      ),
    ),
  ),
)        );
    }
}

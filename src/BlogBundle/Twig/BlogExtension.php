<?php
namespace BlogBundle\Twig;

class BlogExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('turksat', array($this, 'turksatFilter')),
        );
    }

    public function turksatFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = $price.' Türk Lirası';

        return $price;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction("turksatFunc", array($this, 'turksatFunction'))
        );
    }

    public function turksatFunction ($name) {
        return "<strong>".$name."</strong>";
    }

    public function getName()
    {
        return 'app_extension';
    }
}
<?php


namespace Ivan\MyNewAttribute\Model\Product;


class ProductWithSizeChart extends \Magento\Catalog\Model\Product
{
    public function getSizeChartFront()
    {
        return $this->getResource()
            ->getAttribute('size_chart')
            ->getFrontend()
            ->getValue($this);
    }
}
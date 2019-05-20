<?php


namespace Ivan\DynamicShipping\Model;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    public function __construct(
        $name,
        $primaryFieldName = 'id',
        $requestFieldName = 'id',
        array $data = [],
        array $meta = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $result = [
            'items' => [
                ['code2' => 'AU', 'code3' => 'AUS', 'code_num' => '036'],
                ['code2' => 'AT', 'code3' => 'AUT', 'code_num' => '040'],
                ['code2' => 'AZ', 'code3' => 'AZE', 'code_num' => '031']
            ],
            'totalRecords' => 3
        ];
        return $result;
    }
}
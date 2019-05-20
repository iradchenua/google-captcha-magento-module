<?php


namespace Ivan\DynamicShipping\Setup;


use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        $connection = $setup->getConnection();
        $table = $connection->newTable(
            $setup->getTable('ivan_dynamicshipping_carrier')
        )
        ->addColumn(
            'dynamicshipping_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
            'dynamic shipping id'
        )
        ->addColumn(
            'price',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER
        )
        ->addColumn(
                'shipping_method',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT
        )
        ->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN
        )
        ->addColumn(
            'code',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable => false']
        )
        ->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable => false']
        );
        $connection->createTable($table);
    }
}
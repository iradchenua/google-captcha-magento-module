<?php


namespace Ivan\MyNewAttribute\Setup;

use Magento\Catalog\Model\Product;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    private $eavSetupFactory;

    private $eavConfig;

    private $attributeResource;

    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Customer\Model\ResourceModel\Attribute $attributeResource
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->attributeResource = $attributeResource;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        /**
         * Add attributes to the eav/attribute
         */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'size_chart',
            [
                'label' => 'size chart',
                'type' => 'text',
                'input' => 'textarea',
                'frontend' => 'Ivan\MyNewAttribute\Model\SizeChart\Frontend\SizeChart',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'default' => '
                {
                    "Adjustable": "26in (66cm) – 60in (152cm)",
                    "Small":	"26in (66cm) – 34in (86cm)",
                    "Medium":	"33in (84cm) – 42in (107cm)",
                    "Large":	"41in (104cm) – 51in (130cm)",
                    "X-Large":	"50in (127cm) – 60in (152cm)"
                 }
                ',
                'required' => true,
                'user_defined' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true
            ]
        );

    }
}

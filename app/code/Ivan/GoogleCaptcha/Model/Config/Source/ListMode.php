<?php


namespace Ivan\GoogleCaptcha\Model\Config\Source;


class ListMode implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'checkbox', 'label' => __('Check box')],
            ['value' => 'invisible', 'label' => __('Invisible')]
        ];
    }
}
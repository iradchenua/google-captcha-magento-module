<?php


namespace Ivan\GoogleCaptcha\Model\Config\Source;


class ListMode implements \Magento\Framework\Option\ArrayInterface
{
    public const INVISIBLE = 'invisible';
    public const CHECK_BOX = 'checkBox';

    public function toOptionArray()
    {
        return [
            ['value' => 'checkBox', 'label' => __('Check box')],
            ['value' => 'invisible', 'label' => __('Invisible')]
        ];
    }
}
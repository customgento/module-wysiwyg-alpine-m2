<?php

declare(strict_types=1);

namespace CustomGento\WysiwygAlpine\Plugin;

use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Framework\DataObject;

class AllowAlpineInWysiwyg
{
    private const ALPINE_COMPONENTS
        = [
            'x-data',
            'x-init',
            'x-show',
            //            'x-bind:[some regex]',
            //            ':[some regex]',
            //            'x-on:[some regex]',
            //            '@[some regex]',
            'x-text',
            'x-html',
            'x-model',
            'x-for',
            'x-transition',
            'x-effect',
            'x-ignore',
            'x-ref',
            'x-cloak',
            'x-teleport',
            'x-if',
            'x-id'
        ];

    public function afterGetConfig(Config $subject, DataObject $result): DataObject
    {
        $alpineAttributes = implode('|', self::ALPINE_COMPONENTS);
        $settings = $result->getData('settings');

        $extendedSettings = isset($settings['extended_valid_elements'])
            ? $settings['extended_valid_elements'] . ','
            : '';

        $settings['extended_valid_elements'] = $extendedSettings . '@['. $alpineAttributes .'],p,div';

        $result->setData('settings', $settings);

        return $result;
    }
}
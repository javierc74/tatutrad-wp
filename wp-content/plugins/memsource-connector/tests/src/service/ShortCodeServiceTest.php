<?php

namespace Memsource\Tests\Service;

use Memsource\Service\ShortCodeService;

class ShortCodeServiceTest extends \WP_UnitTestCase
{
    /**
     * @dataProvider parseShortCodeDataProvider
     */
    public function testParseShortCode($content, $shortCodeName, $expectedResult)
    {
        $shortCodeService = new ShortCodeServiceHelper();
        $result = $shortCodeService->parseShortCode($content, $shortCodeName);
        $this->assertSame($expectedResult, $result);
    }

    public function parseShortCodeDataProvider() {
        return [
            'empty content' => [
                '',
                'tag',
                false
            ],
            'content without shortcode' => [
                'lorem ipsum...',
                'tag',
                false
            ],
            'shortcode without content' => [
                '[tag][/tag]',
                'tag',
                ['', '']
            ],
            'shortcode with text content' => [
                '[tag]abc[/tag]',
                'tag',
                ['', 'abc']
            ],
            'shortcode with attribute' => [
                '[tag id=""][/tag]',
                'tag',
                [' id=""', '']
            ],
            'shortcode with attribute and text content' => [
                '[tag id=""]abc[/tag]',
                'tag',
                [' id=""', 'abc']
            ],
            'shortcode within paired shortcodes - in content' => [
                '[tag][caption /][/tag]',
                'tag',
                ['', '[caption /]']
            ],
            'shortcode within paired shortcodes - in attribute' => [
                '[tag id="[id]"]abc[/tag]',
                'tag',
                [' id="[id]"', 'abc']
            ],
            'shortcode within paired shortcodes - in attribute and content' => [
                '[tag id="[id]"][caption /][/tag]',
                'tag',
                [' id="[id]"', '[caption /]']
            ]
        ];
    }
}

class ShortCodeServiceHelper extends ShortCodeService {
    public function __construct() {}
}

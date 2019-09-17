<?php

namespace Memsource\Service\Content;

use Memsource\Service\WPMLService;
use Memsource\Utils\ArrayUtils;


abstract class AbstractContentService
{


    /** @var WPMLService */
    protected $wpmlService;



    public function __construct(WPMLService $WPMLService)
    {
        $this->wpmlService = $WPMLService;
    }



    /**
     * Check if is language active.
     * @param $langCode string
     * @return string
     * @throws \InvalidArgumentException if language is not active
     */
    protected function isActiveLanguage($langCode)
    {
        if ($this->wpmlService->isActiveLanguage($langCode) === false) {
            throw new \InvalidArgumentException(sprintf('Language \'%s\' is not active.', $langCode));
        }
        return $langCode;
    }



    /**
     * Insert or update a translation.
     * @param $args array
     * @return array
     * @throws \InvalidArgumentException
     */
    public function saveTranslation(array $args)
    {
        ArrayUtils::checkKeyExists($args, ['lang']);
        $this->isActiveLanguage($args['lang']);

        return $args;
    }

}
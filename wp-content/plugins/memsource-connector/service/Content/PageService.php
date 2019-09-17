<?php

namespace Memsource\Service\Content;


class PageService extends AbstractPostService
{


    const LABEL = 'Pages';
    const TYPE = 'page';



    /**
     * @inheritdoc
     */
    public function getType()
    {
        return self::TYPE;
    }



    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return self::LABEL;
    }
}
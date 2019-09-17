<?php

namespace Memsource\Service\Content;


class PostService extends AbstractPostService
{


    const LABEL = 'Posts';
    const TYPE = 'post';



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
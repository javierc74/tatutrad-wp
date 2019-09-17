<?php

namespace Memsource\Service\Content;


interface IContentService
{


    /**
     * @param $args array
     * @return array
     */
    public function getItems(array $args);



    /**
     * @param $args array
     * @return array|null
     * @throws \InvalidArgumentException
     */
    public function getItem(array $args);



    /**
     * Insert or update a translation.
     * @param $args array
     * @return int id of content
     * @throws \InvalidArgumentException
     */
    public function saveTranslation(array $args);



    /**
     * @return string custom name of content
     */
    public function getType();



    /**
     * @return string custom label
     */
    public function getLabel();



    /**
     * If type of content is folder for show its tree of items in Memsource CLOUD.
     * @return bool
     */
    public function isFolder();
}
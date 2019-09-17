<?php

namespace Memsource\Service\Content;

use Memsource\NotFoundException;
use Memsource\Utils\ArrayUtils;
use Memsource\Utils\StringUtils;


abstract class AbstractCategoryService extends AbstractContentService implements IContentService
{


    /**
     * Get type of content.
     * @return string
     */
    abstract public function getType();



    /**
     * Get one item of content by id.
     * @param $id int
     * @return array|null
     * @throws NotFoundException
     */
    abstract public function getOneById($id);



    /**
     * Insert or update a translation.
     * @param $args array
     * @return int id of content
     * @throws \InvalidArgumentException
     */
    public function saveTranslation(array $args)
    {
        parent::saveTranslation($args);

        ArrayUtils::checkKeyExists($args, ['id', 'title', 'content']);
        $args['lang'] = strtolower($args['lang']);
        $this->getOneById($args['id']); //check if tag exists
        $wpmlContentType = $this->getWpmlContentType();
        $translation = $this->wpmlService->getTranslation($wpmlContentType, $args['id'], $args['lang']);

        if ($translation === null) {
            return $this->saveNewTranslation($args['id'], $args['lang'], $args['title'], $args['content']);
        }
        return $this->update($translation[$args['lang']], $args['title'], $args['content']);
    }



    /**
     * Create array with api response.
     * @param $data array
     * @return array
     */
    protected function createApiResponse(array $data)
    {
        return [
            'id' => $data['term_id'],
            'revision_id' => NULL,
            'date' => NULL,
            'date_gmt' => NULL,
            'modified' => NULL,
            'modified_gmt' => NULL,
            'password' => NULL,
            'slug' => NULL,
            'status' => NULL,
            'type' => $this->getType(),
            'link' => NULL,
            'title' => $data['name'],
            'size' => StringUtils::size($data['name']) + StringUtils::size($data['description']),
            'content' => $this->toMemsourceHTML($data['term_id'], $data['description'])
        ];
    }



    /**
     * Save a new translation.
     * @param $id int id of original content
     * @param $lang string target language
     * @param $title string
     * @param $content string content which will be save
     * @return int id of the new saved content
     */
    abstract protected function saveNewTranslation($id, $lang, $title, $content);



    /**
     * @param $id int
     * @param $title string
     * @param $content string
     * @return int
     * @throws \Exception
     */
    protected function update($id, $title, $content)
    {
        //because in the method wp_update_term is loaded source content and it defends correct saving
        $this->removeGetTermFilter();
        return $id;
    }



    /**
     * Create a format of item for Memsource converter.
     * @param $id int
     * @param $description string
     * @return string
     */
    protected function toMemsourceHTML($id, $description)
    {
        return sprintf('<div id="%d"><div id="description">%s</div></div>', $id, $description);
    }



    /**
     * Get data from special Memsource HTML format.
     * @param $html string
     * @return array
     * @throws \Exception
     */
    protected function getDataFromMemsourceHTML($html)
    {
        $pattern = '/<div id="(\d+)"><div id="description">(|.+?)<\/div><\/div>/s';
        preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
        if (!$matches) {
            throw new \Exception('No result has been matched.');
        }
        $result = [];
        foreach ($matches as $match) {
            $result[] = [
                'id' => $match[1],
                'description' => $match[2]
            ];
        }

        return $result;
    }



    /**
     * Get wpml content type key.
     * @return string
     */
    protected function getWpmlContentType()
    {
        return $this->wpmlService->getContentType($this->getType());
    }



    /**
     * Remove wpml filter.
     * @return bool
    */
    protected function removeGetTermFilter()
    {
        global $sitepress;
        remove_filter('get_term', array($sitepress, 'get_term_adjust_id'), 1);
        return true;
    }
}
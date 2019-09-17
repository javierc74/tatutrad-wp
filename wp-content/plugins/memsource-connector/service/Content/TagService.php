<?php

namespace Memsource\Service\Content;

use Memsource\NotFoundException;
use Memsource\Utils\ArrayUtils;


class TagService extends AbstractCategoryService
{


    /** @var string custom label */
    const LABEL = 'Tags';

    /** @var string custom name of content */
    const TYPE = 'tag';

    /** @var string WordPress name of content */
    const WP_TYPE = 'post_tag';



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



    /**
     * @inheritdoc
     */
    public function getItems(array $args)
    {
        $tags = get_terms(self::WP_TYPE, [
            'order' => 'ASC',
            'hide_empty' => false
        ]);
        $tagResponses = [];
        foreach ($tags ?: [] as $tag) {
            $tagResponses[] = $this->createApiResponse((array)$tag);
        }
        return $tagResponses;
    }



    /**
     * @inheritdoc
     */
    public function getItem(array $args)
    {
        ArrayUtils::checkKeyExists($args, ['id']);
        $tag = get_tag($args['id'], ARRAY_A);
        return $tag ? $this->createApiResponse($tag) : null;
    }



    /**
     * @inheritdoc
     */
    public function getOneById($id)
    {
        $tag = get_tag($id, ARRAY_A);
        if (!$tag) {
            throw new NotFoundException('Tag not found.');
        }
        return $tag;
    }



    /**
     * @inheritdoc
    */
    public function isFolder()
    {
        return true;
    }



    /**
     * Save a new tag.
     * @param $title string
     * @param $content string
     * @return int id of the new tag
     * @throws \Exception
     */
    protected function insertNew($title, $content)
    {
        $params = $this->getDataFromMemsourceHTML($content)[0];
        $response = wp_insert_term($title, self::WP_TYPE, [
            'description' => $params['description'],
            'slug' => sanitize_title($title),
        ]);
        if ($response instanceof \WP_Error) {
            throw new \Exception($response->get_error_message());
        }
        return $response['term_id'];
    }



    /**
     * @inheritdoc
     */
    protected function saveNewTranslation($id, $lang, $title, $content)
    {
        $targetTagId = $this->insertNew($title, $content);
        $wpmlContentType = $this->wpmlService->getContentType($this->getType());
        $this->wpmlService->insertTranslation($wpmlContentType, $id, $targetTagId, $lang);

        return $targetTagId;
    }



    /**
     * @inheritdoc
     */
    protected function update($id, $title, $content)
    {
        parent::update($id, $title, $content);

        $params = $this->getDataFromMemsourceHTML($content)[0];
        $response = wp_update_term($id, self::WP_TYPE, [
            'name' => $title,
            'description' => $params['description']
        ]);
        if ($response instanceof \WP_Error) {
            throw new \Exception($response->get_error_message());
        }

        return $response['term_id'];
    }
}
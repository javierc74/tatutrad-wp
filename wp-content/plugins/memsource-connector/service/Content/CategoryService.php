<?php

namespace Memsource\Service\Content;

use Memsource\NotFoundException;
use Memsource\Utils\ArrayUtils;


class CategoryService extends AbstractCategoryService
{


    /** @var string custom label */
    const LABEL = 'Categories';

    /** @var string custom name of content */
    const TYPE = 'category';

    /** @var string WordPress name of content */
    const WP_TYPE = 'category';



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
     * @param $args array
     * @return array
     */
    public function getItems(array $args)
    {
        $categories = get_terms([
            'taxonomy' => $this->getType(),
            'order' => 'ASC',
            'hide_empty' => false,
        ]);
        $categoryResponses = [];
        foreach ($categories ?: [] as $category) {
            $categoryResponses[] = $this->createApiResponse((array)$category);
        }
        return $categoryResponses;
    }



    /**
     * @inheritdoc
     */
    public function getItem(array $args)
    {
        ArrayUtils::checkKeyExists($args, ['id']);
        $category = $this->getOneById($args['id']);
        return $category ? $this->createApiResponse($category) : null;
    }



    /**
     * Get parent translation id if exists
     * @param $categoryId int id of child
     * @param $lang string target language
     * @return int|null
     */
    public function getParentTranslationId($categoryId, $lang)
    {
        $category = $this->getOneById($categoryId);
        if ($category['category_parent']) {
            $wpmlContentType = $this->getWpmlContentType();
            $translation = $this->wpmlService->getTranslation($wpmlContentType, $category['category_parent'], $lang);
            if ($translation) {
                return $translation[$lang];
            }
        }
        return null;
    }



    /**
     * @inheritdoc
     */
    public function getOneById($id)
    {
        $category = get_category($id, ARRAY_A);
        if (!$category) {
            throw new NotFoundException('Not found.');
        }
        return $category;
    }



    /**
     * Insert a new category into database
     * @param $title string
     * @param $content string
     * @param $parentId int|null
     * @return int id of inserted category
     * @throws \Exception
     */
    public function insertNew($title, $content, $parentId = null)
    {
        $params = $this->getDataFromMemsourceHTML($content)[0];
        $response = wp_insert_term($title, $this->getType(), [
            'description' => $params['description'],
            'slug' => sanitize_title($title),
            'parent' => $parentId ?: 0,
        ]);
        if ($response instanceof \WP_Error) {
            throw new \Exception($response->get_error_message());
        }
        return $response['term_id'];
    }



    /**
     * @inheritdoc
     */
    public function update($id, $title, $content)
    {
        parent::update($id, $title, $content);

        $params = $this->getDataFromMemsourceHTML($content)[0];
        $response = wp_update_term($id, $this->getType(), [
            'name' => $title,
            'description' => $params['description'],
        ]);
        if ($response instanceof \WP_Error) {
            throw new \Exception($response->get_error_message());
        }
        return $response['term_id'];
    }



    /**
     * @inheritdoc
     */
    public function isFolder()
    {
        return true;
    }



    /**
     * @inheritdoc
     */
    protected function saveNewTranslation($categoryId, $lang, $title, $content)
    {
        $parentTranslationId = $this->getParentTranslationId($categoryId, $lang);
        $targetCategoryId = $this->insertNew($title, $content, $parentTranslationId !== null ? $parentTranslationId : null);
        $wpmlContentType = $this->getWpmlContentType();
        $this->wpmlService->insertTranslation($wpmlContentType, $categoryId, $targetCategoryId, $lang);

        return $targetCategoryId;
    }


}
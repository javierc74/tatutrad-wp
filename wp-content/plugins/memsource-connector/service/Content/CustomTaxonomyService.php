<?php

namespace Memsource\Service\Content;

use Memsource\NotFoundException;


class CustomTaxonomyService extends CategoryService
{


    use CustomTypeTrait;



    /**
     * @inheritdoc
     */
    public function getOneById($id)
    {
        $item = get_term($id, $this->getType(), ARRAY_A, 'raw');
        if (!$item) {
            throw new NotFoundException('Not found.');
        }
        return $item;
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
        if ($category['parent']) {
            $translation = $this->wpmlService->getTranslation($this->getWpmlContentType(), $category['parent'], $lang);
            if ($translation) {
                return $translation[$lang];
            }
        }
        return null;
    }



    /**
     * todo move to method getContentType of wpml service
     * @return string
     */
    protected function getWpmlContentType()
    {
        return 'tax_' . $this->getType();
    }
}
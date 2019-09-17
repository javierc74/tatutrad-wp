<?php

namespace Memsource\Service;


class WPMLService
{


    /**
     * Get translation of a content.
     * @param $contentType string
     * @param $sourceContentId int
     * @param $language string
     * @return array|null
     */
    public function getTranslation($contentType, $sourceContentId, $language)
    {
        $translation = wpml_get_content_translation($contentType, $sourceContentId, $language);
        return is_int($translation) ? null : $translation;
    }



    /**
     * Insert a new translation for a content.
     * @param $contentType string
     * @param $sourceId int
     * @param $targetId int
     * @param $language string
     * @return bool|null|int|string
     * @throws \Exception
     */
    public function insertTranslation($contentType, $sourceId, $targetId, $language)
    {
        global $sitepress;
        $trid = $sitepress->get_element_trid($sourceId, $contentType);
        $returnCode = $sitepress->set_element_language_details($targetId, $contentType, $trid, $language);
        if ($returnCode === WPML_API_ERROR) {
            throw new \Exception('Translation has not been saved.');
        }
        return true;
    }



    /**
     * Get information if is active language.
     * @param $languageCode string
     * @return bool
     */
    public function isActiveLanguage($languageCode)
    {
        return isset($this->getActiveLanguages()[$languageCode]);
    }



    /**
     * @return array
     */
    public function getActiveLanguages()
    {
        global $sitepress;
        return $sitepress->get_languages(false, true) ?: [];
    }



    /**
     * @return string|null
     */
    public function getDefaultLanguage()
    {
        return wpml_get_default_language() ?: null;
    }



    /**
     * Get WPML type of content
     * @param $type string
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getContentType($type)
    {
        $types = [
            'post' => 'post_post',
            'page' => 'post_page',
            'tag' => 'tax_post_tag',
            'category' => 'tax_category'
        ];
        if (!isset($types[$type])) {
            throw new \InvalidArgumentException(sprintf('Unknown type \'%s\'.', $type));
        }

        return $types[$type];
    }

}
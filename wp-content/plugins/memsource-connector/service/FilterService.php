<?php

namespace Memsource\Service;


use Memsource\Utils\DatabaseUtils;
use WP_Query;

class FilterService {

    private $optionsService;
    private $languageService;

    function __construct(OptionsService &$optionsService, LanguageService &$languageService) {
        $this->optionsService = &$optionsService;
        $this->languageService = &$languageService;
        add_filter('pre_get_posts', array($this, 'addQueryFilters'));
    }

    function addQueryFilters(WP_Query $query, $force_where = false) {
        if (!$this->optionsService->wpmlActive()) {
            // do not filter on a single post page (non-admin)
            if ($force_where || $query->is_main_query() && !is_singular()) {
                add_filter('posts_where', array($this, 'filterByLanguage'));
            }
        }
        return $query;
    }

    function filterByLanguage($where = '') {
        global $wpdb;
        $language = $this->languageService->getSelectedLanguageCode();
        if ($language != 'all') {
            $posts_table_name = $wpdb->prefix . DatabaseUtils::TABLE_POSTS;
            $translations_table_name = $wpdb->prefix . DatabaseUtils::TABLE_TRANSLATIONS;
            $where .= ' and ' . $posts_table_name . '.ID in (select item_id from ' . $translations_table_name . ' where target_language = \'' . $language . '\')';
        }
        return $where;
    }

}
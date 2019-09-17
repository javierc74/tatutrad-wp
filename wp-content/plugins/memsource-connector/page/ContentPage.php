<?php

namespace Memsource\Page;

use Memsource\Service\DatabaseService;


class ContentPage extends AbstractPage
{


    /** @var string */
    const MENU_SLUG = 'memsource-connector-content-management';

    /** @var DatabaseService */
    protected $databaseService;



    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }



    function initPage()
    {
        add_submenu_page('memsource-connector', 'Translatable content', 'Translatable content', 'manage_options', self::MENU_SLUG, array($this, 'renderPage'));
    }



    function renderPage()
    {
        ?>
        <div class="memsource-admin-header">
            <img class="memsource-logo" src="<?php echo MEMSOURCE_PLUGIN_DIR_URL; ?>/images/site-memsource.png"/>
            <span class="memsource-label"><?php _e('Translatable content', 'memsource'); ?></span>
        </div>
        <div class="memsource-space"></div>
        <div class="memsource-admin-section-description"><?php _e('<p>This page gives you the option to configure additional settings for translatable content types supported by the connector.</p>', 'memsource-translatable-content-description'); ?></div>
        <div class="memsource-space"></div>
        <div class="memsource-admin-title"><?php _e('Custom fields', 'memsource'); ?></div>
        <div class="memsource-admin-section-description"><?php _e('<p>Select which custom fields should be exported for translation with a post or a page. Whenever a new theme or a page builder is installed to WordPress, the list of the custom fields is automatically updated.</p>', 'memsource-custom-fields-description'); ?></div>
        <?php
            $selectAllBlock = '<p style="padding: 2px 7px"><label><input type="checkbox" class="select-all"> Select all</label></p>';
            echo $selectAllBlock;

            $totalPages = max(1, ceil($this->databaseService->findCustomFieldsTotalCount() / DatabaseService::PAGE_SIZE));

            if (isset($_GET['pagination']) && (int) $_GET['pagination'] > 0) {
                $currentPage = (int) $_GET['pagination'];
            } else {
                $currentPage = 1;
            }
        ?>
        <hr>
        <form id="memsource-content-settings-form" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="memsource_content_settings_form"/>
            <input type="hidden" name="referer" value="<?php echo esc_url(admin_url('admin.php')) . '?page=' . self::MENU_SLUG . "&pagination=$currentPage"; ?>">
            <input type="hidden" name="pagination" value="<?php echo $currentPage ?>">
            <table style="width: 50%; text-align: left;">
                <thead>
                    <tr>
                        <th class="manage-column column-title column-primary"><?php _e('Export', 'memsource'); ?></th>
                        <th class="manage-column column-title column-primary"><?php _e('Name', 'memsource'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $items = $this->getItems();
                    $itemsCount = count($items);
                    $i = 1;

                    foreach ($items as $item) {
                        if ($i < $itemsCount || $itemsCount <= DatabaseService::PAGE_SIZE) {
                            echo sprintf('<tr><td><input type="checkbox" class="item" name="%s" value="1" %s></td><td>%s</td></tr>', $item['hash'], ($item['checked'] ? 'checked' : ''), $item['name']);
                            $i++;
                        }
                    }

                    if (!$items) {
                        echo sprintf('<tr><td colspan="2">No content found.</td></tr>');
                    }
                ?>
                </tbody>
            </table>
            <hr>
            <?php echo $selectAllBlock; ?>
            <table style="width: 50%; text-align: left;">
                <tr>
                    <td>
                        <input type="submit" class="memsource-button" value="<?php _e('Save', 'memsource'); ?>"/>
                    </td>
                    <td style="text-align: center;">
                    <?php
                        echo "Showing page $currentPage of $totalPages total. ";

                        if ($currentPage > 1) {
                            echo ' | <a href="' . add_query_arg('pagination', $currentPage - 1) . '">Previous page</a>';
                        }

                        if ($itemsCount > DatabaseService::PAGE_SIZE) {
                            echo ' | <a href="' . add_query_arg('pagination', $currentPage + 1) . '">Next page</a>';
                        }
                    ?>
                    </td>
                </tr>
            </table>
        </form>

        <script>
            var items = jQuery('#memsource-content-settings-form .item');
            var selectAllCheckbox = jQuery('.select-all');

            //select all on request
            selectAllCheckbox.change(function(){
                var checked = jQuery(this).prop('checked');
                items.prop('checked', checked);
                selectAllCheckbox.prop('checked', checked);
            });

            //uncheck items for select all when is changing an item
            items.click(function(){
                selectAllCheckbox.prop('checked', false);
            });
        </script>
        <?php
    }



    /**
     * Handler for submitted form.
     */
    public function formSubmit()
    {
        global $wpdb;

        $wpdb->query('START TRANSACTION');

        foreach ($this->getItems() as $value) {
            $this->databaseService->saveContentSettings(DatabaseService::CUSTOM_FIELD_TYPE, $value['key'], (isset($_POST[$value['hash']]) ? '1' : '0'));
        }

        $wpdb->query('COMMIT');

        wp_redirect($_POST['referer']);
    }



    /**
     * @return array
     */
    protected function getItems()
    {
        $items = [];

        if (isset($_GET['pagination']) && (int) $_GET['pagination'] > 0) {
            $fields = $this->databaseService->findCustomFieldKeys((int) $_GET['pagination']);
        } elseif (isset($_POST['pagination']) && (int) $_POST['pagination'] > 0) {
            $fields = $this->databaseService->findCustomFieldKeys((int) $_POST['pagination']);
        } else {
            $fields = $this->databaseService->findCustomFieldKeys(1);
        }

        $contentSettings = $this->databaseService->findContentSettingsByType(DatabaseService::CUSTOM_FIELD_TYPE);

        foreach ($fields as $hash => $field) {
            $items[] = [
                'hash' => $hash,
                'key' => $field,
                'checked' => isset($contentSettings[$hash]) ? $contentSettings[$hash]['send'] : true,
                'name' => $field,
            ];
        }

        return $items;
    }
}
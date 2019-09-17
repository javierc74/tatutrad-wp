<?php

namespace Memsource\Page;

use Memsource\Service\DatabaseService;
use Memsource\Service\LanguageService;


class LanguageMappingPage extends AbstractPage
{


    /** @var string */
    const MENU_SLUG = 'memsource-connector-language-mapping';

    /** @var DatabaseService */
    protected $databaseService;

    /** @var LanguageService */
    protected $languageService;



    public function __construct(DatabaseService $databaseService,
                                LanguageService $languageService)
    {
        $this->databaseService = $databaseService;
        $this->languageService = $languageService;
    }



    /**
     * @inheritdoc
     */
    public function initPage()
    {
        add_submenu_page('memsource-connector', 'Language mapping', 'Language mapping', 'manage_options', self::MENU_SLUG, array($this, 'renderPage'));
    }



    /**
     * @inheritdoc
     */
    public function renderPage()
    {
        ?>
        <div class="memsource-admin-header">
            <img class="memsource-logo"
                 src="<?php echo MEMSOURCE_PLUGIN_DIR_URL; ?>/images/site-memsource.png"/>
            <span class="memsource-label"><?php _e('Language mapping', 'memsource'); ?></span>
        </div>
        <div class="memsource-space"></div>
        <div class="memsource-admin-section-description"><?php _e('<p>This page gives you the option to map default WPML language codes to Memsource language codes. See our documentation for the list of all 
                                                                   <a href="https://help.memsource.com/hc/en-us/articles/115003929811-Supported-Languages" target="_blank">supported languages</a>.</p>
                                                                   <p>The <b>Restore default</b> option will replace any customized language codes with WPML default language codes.</p>', 'memsource-language-mapping-description'); ?></div>
        <?php
        if (isset($_GET['valid']) && $_GET['valid'] === 'false') {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><?php _e('The form is not valid. Each field must be filled and contain a unique code. Please, fill in the form and save again.', 'sample-text-domain'); ?></p>
            </div>
            <?php
        }
        ?>
        <form id="memsource-language-mapping-form" method="POST"
              action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="memsource_language_mapping_form"/>
            <input type="hidden" name="referer"
                   value="<?php echo esc_url(admin_url('admin.php')) . '?page=' . self::MENU_SLUG; ?>">
            <table style="width: 50%">
                <thead style="text-align: left;">
                <tr>
                    <th><?php _e('Active language', 'memsource'); ?></th>
                    <th><?php _e('Code', 'memsource'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $activeLanguages = $this->languageService->getActiveLanguages();
                $activeLanguages['target'][] = $activeLanguages['source'];
                $mapping = $this->databaseService->findAllLanguageMapping();
                foreach ($activeLanguages['target'] as $value) {
                    echo sprintf('<tr><td>%s</td><td><input type="text" value="%s" name="%s" maxlength="15" id="mapping_input_%3$s"> <a role="button" style="cursor: pointer" onclick="fillDefaultValue(\'%3$s\')">Restore default</a></td></tr>',
                        $value['native_name'], isset($mapping[$value['code']]) ? $mapping[$value['code']]['memsource_code'] : $value['code'], $value['code']);
                }
                ?>
                </tbody>
            </table>
            <input type="submit" class="memsource-button" value="<?php _e('Save', 'memsource'); ?>"/>
        </form>
        <script>
            function fillDefaultValue(languageCode) {
                document.getElementById('mapping_input_' + languageCode).value = languageCode;
            }
        </script>
        <?php
    }



    /**
     * Handle for sent form.
     * @return void
     */
    public function formSubmit()
    {
        global $wpdb;

        $invalid = false;
        $wpdb->query('START TRANSACTION');
        foreach ($_POST as $key => $value) {
            if (!in_array($key, ['action', 'submit', 'referer'], true)) { //process only inputs with code
                $value = strtolower(trim($value));
                //check completion and duplicity
                $invalid = !$value || (($mapping = $this->databaseService->findOneLanguageMappingByMemsourceCode($value)) && $mapping['code'] !== $key);
                if ($invalid === true) {
                    break;
                }
                $this->databaseService->saveLanguageMapping($key, $value);
            }
        }
        $wpdb->query($invalid === false ? 'COMMIT' : 'ROLLBACK');
        wp_redirect($_POST['referer'] . '&valid=' . ($invalid === false ? 'true' : 'false'));
    }

}
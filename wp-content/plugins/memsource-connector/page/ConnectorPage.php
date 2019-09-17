<?php

namespace Memsource\Page;


use Memsource\Service\AuthService;
use Memsource\Service\MemsourceApiService;
use Memsource\Service\OptionsService;

class ConnectorPage extends AbstractPage {

    private $optionsService;
    private $memsourceApiService;
    private $authService;

    function __construct(OptionsService &$optionsService, MemsourceApiService &$memsourceApiService, AuthService &$authService) {
        $this->optionsService = &$optionsService;
        $this->memsourceApiService = &$memsourceApiService;
        $this->authService = &$authService;
    }

    function initPage() {
        add_menu_page('Memsource Connector', 'Memsource', 'manage_options', 'memsource-connector', array($this, 'renderPage'), plugin_dir_url(__FILE__) . '../memsource.svg');
        add_submenu_page('memsource-connector', 'Memsource Connector', 'Connector', 'manage_options', 'memsource-connector', array($this, 'renderPage'));
    }

    function renderPage() {
        $list_statuses = $this->optionsService->getListStatuses();
        $insert_status = $this->optionsService->getInsertStatus();
        $translate_status = $this->optionsService->getTranslateStatus();
        ?>
        <script>
            jQuery(document).ready(function() {
                initClipboard('<?php _e('Copied!', 'memsource'); ?>');
                checkListStatuses();
            });
            function generateToken() {
                var data = {
                    action: 'generate_token'
                };
                jQuery.post(ajaxurl, data, function(response) {
                    jQuery('#token-text-field').val(response.token);
                });
            }
            function disconnectFromMemsource(formId) {
                if (confirm("<?php _e('Do you really want to disconnect from Memsource?', 'memsource'); ?>")) {
                    jQuery('#' + formId).submit();
                }
            }
            function checkListStatuses() {
                var element = jQuery('#list-status-warning');
                var checked = jQuery('#list-status-section').find('input:checked');
                if (checked.length === 0) {
                    element.html('<span class="red-icon"><?php _e('Not selecting any statuses will result in no content being offered for translation. Saving changes now will choose publish status automatically.', 'memsource'); ?></span>');
                } else {
                    element.html('');
                }
            }
        </script>
        <div class="memsource-admin-area">
        <div class="memsource-admin-header">
            <img class="memsource-logo"
                 src="<?php echo MEMSOURCE_PLUGIN_DIR_URL ?>/images/site-memsource.png"/>
            <span class="memsource-label"><?php _e('Settings', 'memsource'); ?></span>
        </div>
        <div class="memsource-space"></div>
        <div
            class="memsource-admin-title"><?php _e('Connect Memsource plugin to Memsource Cloud', 'memsource'); ?></div>
        <div class="memsource-admin-section">
            <div class="memsource-admin-section-title"><?php _e('Connector', 'memsource'); ?></div>
            <div class="memsource-admin-section-description">
                <p><?php _e('Memsource enables integrations with several CMS systems and online repositories, including WordPress. Connectors allow users to connect their Memsource account with these systems, draw content for translations directly from them into Memsource, and deliver translated content back into the system in the same file format.', 'memsource'); ?></p>
                <p class="memsource-subtitle"><?php _e('When should you use the connector?', 'memsource'); ?></p>
                <p><?php _e('If you will be selecting the content for translation from within Memsource, use the settings below to establish the connection between your WordPress site and Memsource. The connector feature also allows for a fully automated process of pulling translation content from WordPress.', 'memsource'); ?></p>
                <p><?php _e('See our documentation for a step-by-step guide on how to <a href="https://wiki.memsource.com/wiki/WordPress_Plugin#Setting_up_the_WordPress_Connector_in_Memsource_Cloud" target="_blank">Set up the WordPress Connector in Memsource Cloud</a> and how to <a href="https://wiki.memsource.com/wiki/Automated_Project_Creation" target="_blank">Automate Project Creation in Memsource Cloud</a>.', 'memsource'); ?></p>
            </div>
            <div id="memsource-admin-toggle-connector" class="memsource-expand-link">
                <span class="dashicons dashicons-admin-generic gray-icon"></span>
                <span id="memsource-admin-link-connector" class="clickable underline"
                      onclick="toggleSection('connector', '<?php _e('Show Connector settings', 'memsource'); ?>', '<?php _e('Hide Connector settings', 'memsource'); ?>')">
                    <?php _e('Show Connector settings', 'memsource'); ?>
                </span>
                <span id="memsource-admin-arrow-connector" class="dashicons dashicons-arrow-down gray-icon"></span>
            </div>
            <div id="memsource-admin-section-connector" class="memsource-section-init">
                <label for="token-text-field"><?php _e('Memsource Connector authentication token', 'memsource'); ?>
                    :</label>
                <div class="memsource-space-small"></div>
                <input id="token-text-field" type="text" name="token"
                       value="<?php echo $this->optionsService->getToken(); ?>"
                       readonly class="memsource-token-field"/>
                <button id="token-copy" class="btn"
                        data-clipboard-target="#token-text-field"><?php _e('Copy to clipboard', 'memsource'); ?></button>
                <span id="token-copy-result"></span>
                <div class="memsource-space-small"></div>
                <span class="clickable underline"
                      onclick="generateToken()"><?php _e('Generate new token', 'memsource'); ?></span>
                <div class="memsource-space-big"></div>
                <form method="POST" action="<?php echo admin_url('admin.php'); ?>">
                    <input type="hidden" name="action" value="save_connector_options"/>
                    <div id="list-status-section" class="checkbox-section">
                        <?php _e('Import posts with the following status', 'memsource'); ?>:<br/>
                        <input type="checkbox" id="list-status-publish" name="list-status-publish" onclick="checkListStatuses()"
                               value="publish" <?php echo(in_array("publish", $list_statuses) ? " checked" : ""); ?>/><label
                            for="list-status-publish"><?php _e('publish', 'memsource'); ?></label><br/>
                        <input type="checkbox" id="list-status-draft" name="list-status-draft" onclick="checkListStatuses()"
                               value="draft" <?php echo(in_array("draft", $list_statuses) ? " checked" : ""); ?>/><label
                            for="list-status-draft"><?php _e('draft', 'memsource'); ?></label><br/>
                    </div>
                    <div class="checkbox-section">
                        <?php _e('Set status for exported posts to', 'memsource'); ?>:<br/>
                        <input type="radio" id="insert-status-publish" name="insert-status"
                               value="publish" <?php echo($insert_status == "publish" ? " checked" : ""); ?>/><label
                            for="insert-status-publish"><?php _e('publish', 'memsource'); ?></label><br/>
                        <input type="radio" id="insert-status-draft" name="insert-status"
                               value="draft" <?php echo($insert_status == "draft" ? " checked" : ""); ?>/><label
                            for="insert-status-draft"><?php _e('draft', 'memsource'); ?></label><br/>
                    </div>
                    <div class="memsource-space-small"></div>
                    <div id="list-status-warning"></div>
                    <div class="memsource-space"></div>
                    <input type="submit" class="memsource-button" value="<?php _e('Save', 'memsource'); ?>"/>
                </form>
            </div>
        </div>
        </div>
    <?php
    }

}
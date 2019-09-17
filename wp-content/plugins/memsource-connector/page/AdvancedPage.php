<?php

namespace Memsource\Page;


use Memsource\Service\OptionsService;
use Memsource\Utils\SystemUtils;

class AdvancedPage extends AbstractPage {

    private $optionsService;

    function __construct(OptionsService &$optionsService) {
        $this->optionsService = &$optionsService;
    }

    function initPage() {
        add_submenu_page('memsource-connector', 'Advanced Options', 'Advanced', 'manage_options', 'memsource-connector-advanced', array($this, 'renderPage'));
    }

    function renderPage() {
        ?>
        <script>
            jQuery(document).ready(function() {
                initClipboard('<?php _e('Copied!', 'memsource'); ?>');
            });
            function checkApiPrefix() {
                var prefix = jQuery('#apiPrefix').val();
                if (prefix && prefix.trim().length > 0) {
                    var apiPrefix = prefix.trim();
                    if (/^https:\/\/.+\/web$/.test(apiPrefix)) {
                        jQuery('#api-prefix-form').submit();
                    } else {
                        alert('<?php _e('Invalid API prefix. It must start with "https://" and end with "/web".', 'memsource'); ?>');
                    }
                }
            }
            function resetApiPrefix() {
                if (confirm('<?php _e('Do you really want to reset Memsource API prefix to ' . OptionsService::DEFAULT_API_PREFIX . '?', 'memsource'); ?>')) {
                    jQuery('#apiPrefix').val('<?php echo OptionsService::DEFAULT_API_PREFIX; ?>');
                    jQuery('#api-prefix-form').submit();
                }
            }
            function emailToMemsource() {
                if (confirm("<?php _e('Do you really want to send the log file to Memsource?', 'memsource'); ?>")) {
                    var data = {
                        action: 'zip_and_email_log'
                    };
                    jQuery('#email-spinner').addClass('is-active');
                    jQuery.post(ajaxurl, data, function(response) {
                        jQuery('#email-spinner').removeClass('is-active');
                        jQuery('#email-result').html('File ' + response.zipFile + ' has been sent to Memsource.');
                    });
                }
            }
            function deleteLogFile() {
                if (confirm("<?php _e('Do you really want to delete the log file?', 'memsource'); ?>")) {
                    var data = {
                        action: 'delete_log'
                    };
                    jQuery('#delete-spinner').addClass('is-active');
                    jQuery.post(ajaxurl, data, function(response) {
                        jQuery('#delete-spinner').removeClass('is-active');
                        var files = [];
                        if (response.logDeleted) {
                            files.push(response.logDeleted);
                        }
                        if (response.zipDeleted) {
                            files.push(response.zipDeleted);
                        }
                        jQuery('#delete-result').html('Files ' + files.join(', ') + ' has been deleted.');
                    });
                }
            }
        </script>
        <div class="memsource-admin-header">
            <img class="memsource-logo"
                 src="<?php echo MEMSOURCE_PLUGIN_DIR_URL ?>/images/site-memsource.png"/>
            <span class="memsource-label"><?php _e('Advanced Settings', 'memsource'); ?></span>
        </div>
        <div class="memsource-space"></div>
        <div
            class="memsource-admin-section-description"><?php _e('This page contains options and tools to help us investigate potential issues with the plugin. Please do not do any changes here unless we ask you to do so.', 'memsource'); ?></div>
        <div class="memsource-space"></div>
        <form id="api-prefix-form" method="POST" action="<?php echo admin_url('admin.php'); ?>">
            <input type="hidden" name="action" value="set_api_prefix"/>
            <label for="apiPrefix"><?php _e('Memsource API prefix', 'memsource'); ?>:</label>
            <input id="apiPrefix" class="memsource-url-field" type="text" name="apiPrefix" value="<?php echo $this->optionsService->getMemsourceApiPrefix(); ?>"/>
            <input type="button" class="memsource-button" value="<?php _e('Update', 'memsource'); ?>" onclick="checkApiPrefix()"/>
            <?php if ($this->optionsService->getMemsourceApiPrefix() != OptionsService::DEFAULT_API_PREFIX) { ?>
                <span class="clickable underline" onclick="resetApiPrefix()"><?php _e('Reset to default value', 'memsource'); ?></span>
            <?php } ?>
        </form>
        <div class="memsource-space"></div>
        <form method="POST" action="<?php echo admin_url('admin.php'); ?>">
            <input type="hidden" name="action" value="set_debug_mode"/>
            <input id="debugMode" type="checkbox" name="debugMode"
                <?php echo($this->optionsService->isDebugMode() ? " checked" : "") ?>/>
            <label for="debugMode"><?php _e('Debug mode', 'memsource'); ?></label>
            <div class="memsource-space"></div>
            <input type="submit" class="memsource-button" value="<?php _e('Save', 'memsource'); ?>"/>
        </form>
        <div class="memsource-space"></div>
        <?php if ($this->optionsService->isDebugMode()) {
            ?>
            <div id="memsource-admin-toggle-options" class="memsource-expand-link">
                <span id="memsource-admin-link-options" class="clickable underline"
                      onclick="toggleSection('options', '<?php _e('Show Memsource Plugin options', 'memsource'); ?>', '<?php _e('Hide Memsource Plugin options', 'memsource'); ?>')">
                    <?php _e('Show Memsource Plugin options', 'memsource'); ?>
                </span>
                <span id="memsource-admin-arrow-options" class="dashicons dashicons-arrow-down normal-icon"></span>
            </div>
            <div id="memsource-admin-section-options" class="memsource-section-init">
                <?php
                $textarea = '';
                $memsource_options = $this->optionsService->getAllMemsourceOptions();
                foreach ($memsource_options as $option) {
                    $textarea .= $option['option_name'] . ': ' . $option['option_value'] . "\n";
                }
                ?>
                <textarea id="memsource-options" class="textarea-options"
                          title="<?php _e('Memsource Plugin options', 'memsource'); ?>"
                          readonly><?php echo $textarea; ?></textarea>
                <br/>
                <button id="options-copy" class="btn"
                        data-clipboard-target="#memsource-options"><?php _e('Copy to clipboard', 'memsource'); ?></button>
                <span id="options-copy-result"></span>
            </div>
            <div class="memsource-space"></div>
            <?php _e('Memsource log file name', 'memsource'); ?>: <?php echo SystemUtils::LOG_FILE_NAME; ?><br/>
            <?php _e('Memsource log file size', 'memsource'); ?>: <?php echo SystemUtils::getLogFileSizeFormatted(); ?>
            <div class="memsource-space"></div>
            <?php if (SystemUtils::getLogFileSize() > 0) { ?>
                <div>
                    <input id="email-button" class="memsource-button auto-size" type="button"
                           value="<?php _e('Zip and email log file to Memsource', 'memsource'); ?>"
                           onclick="emailToMemsource()"/>
                    <span id="email-spinner" class="spinner"></span>
                </div>
                <div id="email-result"></div>
                <div class="memsource-space"></div>
                <div>
                    <input id="delete-button" class="memsource-button auto-size" type="button"
                           value="<?php _e('Delete the log file', 'memsource'); ?>"
                           onclick="deleteLogFile()"/>
                    <span id="delete-spinner" class="spinner"></span>
                </div>
                <div id="delete-result"></div>
            <?php } ?>
        <?php } ?>
        <?php
    }

}
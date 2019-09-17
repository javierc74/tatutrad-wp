<?php

namespace Memsource\Service;


use Memsource\Service\Content\PostService;
use Memsource\Utils\PostUtils;

class TranslationService {

    const CUSTOMFIELD_META_TYPE = 'customfield_meta';

    private $memsourceApiService;
    private $languageService;
    private $postService;
    private $optionsService;

    function __construct(MemsourceApiService &$memsourceApiService,
                         LanguageService &$languageService,
                         PostService &$postService,
                         OptionsService &$optionsService) {
        $this->memsourceApiService = &$memsourceApiService;
        $this->languageService = &$languageService;
        $this->postService = &$postService;
        $this->optionsService = &$optionsService;
        add_action('wp_ajax_get_automation_widgets', array($this, 'getAutomationWidgets'));
        add_action('wp_ajax_get_automation_widget', array($this, 'getAutomationWidget'));
        add_action('wp_ajax_get_services', array($this, 'getServices'));
        add_action('wp_ajax_setup_work', array($this, 'setupWork'));
        add_action('wp_ajax_get_quotes', array($this, 'getQuotes'));
        add_action('wp_ajax_get_due_date', array($this, 'getDueDate'));
        add_action('wp_ajax_save_due_date', array($this, 'saveDueDate'));
        add_action('wp_ajax_get_work', array($this, 'getWork'));
        add_action('wp_ajax_create_project', array($this, 'createProject'));
        add_action('wp_ajax_get_translation_status', array($this, 'getTranslationStatus'));
        add_action('wp_ajax_cancel_translation', array($this, 'cancelTranslation'));
    }

    function cleanUnfinishedWork($post_id) {
        $work_data = $this->postService->getWorkData($post_id);
        foreach ($work_data as $data) {
            if ($data['status'] == PostService::STATUS_CREATED) {
                $this->postService->deleteWorkData($post_id, $data['work_uuid'], $data['target_language']);
            }
        }
    }

    function getAutomationWidgets() {
        $response = $this->memsourceApiService->sendApiRequest('/rest/v1/automationWidget', []);
        $widgets = json_decode($response);
        if ($widgets && $widgets->widgets && sizeof($widgets->widgets) > 0 && !$this->optionsService->getAutomationWidgetId()) {
            $this->optionsService->updateAutomationWidgetId($widgets->widgets[0]->urlId);
        }
        header('Content-Type: application/json');
        if ($widgets && $widgets->widgets) {
            echo json_encode($widgets->widgets);
        }
        wp_die();
    }

    function getAutomationWidget() {
        $widgetId = $this->optionsService->getAutomationWidgetId();
        $response = $this->memsourceApiService->sendApiRequest('/rest/v1/automationWidget/' . $widgetId, []);
        $widget = json_decode($response);
        header('Content-Type: application/json');
        echo json_encode($widget);
        wp_die();
    }

    function getServices() {
        $response = $this->memsourceApiService->sendApiRequest('/api/v8/service/list', []);
        $services = json_decode($response);
        header('Content-Type: application/json');
        echo json_encode($services->services);
        wp_die();
    }

    function setupWork() {
        $post_id = $_POST['postId'];
        $source_language = $this->languageService->getSourceLanguage();
        $target_languages = explode(',', $_POST['targetLanguages']);
        $jobWidgetUrlId = $this->optionsService->getAutomationWidgetId();
        $serviceId = $_POST['serviceId'];
        $changed = $_POST['changed'];
        // check if a Work is already created for these languages (uuid stored in the post metadata)
        $work_uuid = $this->postService->getWorkUuid($post_id, $target_languages);
        // if not, create it with selected languages and service, and store uuid for this post
        if (!$work_uuid) {
            $payload = [
                "clientType" => "WORDPRESS",
                "jobWidgetUrlId" => $jobWidgetUrlId,
                "serviceId" => $serviceId,
                "sourceLang" => $source_language,
                "targetLangs" => $target_languages,
                "sourcePermalink" => get_permalink($post_id)  // add current post URL
            ];
            $headers = ["Content-Type" => "application/json"];
            $response = $this->memsourceApiService->sendApiRequest('/worksFromParams', json_encode($payload), 'POST', $headers);
            $work = json_decode($response);
            if ($work && $work->id) {
                // create a WorkUnit from the post content
                $post = $this->postService->getPost($post_id);
                $file_name = $post->post_title . '.html';
                $result_map = $this->postService->getPostContent($post);
                $file_content = PostUtils::buildFileContent($post->post_title, $result_map);
                $web_hook = get_site_url() . '/wp-json/' . $this->optionsService->getRestNamespace() . '/webhook/job';
                $response = $this->memsourceApiService->setMultipartApiRequest(
                    '/works/' . $work->id . '/workUnits',
                    array('webHook' => $web_hook),
                    array(
                        array(
                            'name' => 'file',
                            'filename' => $file_name,
                            'content' => $file_content
                        )
                    )
                );
                $file = json_decode($response);
                $work_data = [];
                foreach ($target_languages as $language) {
                    $work_data[] = ["post_id" => $post_id, "target_language" => $language, "work_uuid" => $work->id, "status" => PostService::STATUS_CREATED];
                }
                $this->postService->saveWorkData($work_data);
                $work_uuid = $work->id;
            }
        } else {
            // otherwise change languages or service in the Work
            $headers = ['Content-Type' => 'application/json'];
            if ($changed == 'languages') {
                $payload = json_encode([
                    "sourceLang" => $source_language,
                    "targetLangs" => $target_languages
                ]);
                $this->memsourceApiService->sendApiRequest('/works/' . $work_uuid . '/langs', $payload, 'PUT', $headers);
                // change languages in the post metadata
                $work_data = [];
                foreach ($target_languages as $language) {
                    $work_data[] = ["post_id" => $post_id, "target_language" => $language, "work_uuid" => $work_uuid, "status" => PostService::STATUS_CREATED];
                }
                $this->postService->updateWorkData($post_id, $work_data);
            } else if ($changed == 'service') {
                $payload = json_encode([
                    "services" => [$serviceId]
                ]);
                $this->memsourceApiService->sendApiRequest('/works/' . $work_uuid . '/services', $payload, 'PUT', $headers);
            }
        }
        header('Content-Type: application/json');
        echo json_encode(["workUuid" => $work_uuid]);
        wp_die();
    }

    function getQuotes() {
        $work_uuid = $_POST['workUuid'];
        // analyse and get quotes
        $response = $this->memsourceApiService->sendApiRequest('/works/' . $work_uuid . '/analysis', []);
        $analysis = json_decode($response);
        header('Content-Type: application/json');
        echo json_encode($analysis);
        wp_die();
    }

    function getDueDate() {
        $work_uuid = $_POST['workUuid'];
        $response = $this->memsourceApiService->sendApiRequest('/works/' . $work_uuid . '/dueDate', []);
        $dueDate = json_decode($response);
        header('Content-Type: application/json');
        echo json_encode($dueDate);
        wp_die();
    }

    function saveDueDate() {
        $work_uuid = $_POST['workUuid'];
        $due_date = $_POST['dueDate'];
        $payload = json_encode([
            "dueDate" => $due_date
        ]);
        $headers = ["Content-Type" => "application/json"];
        $response = $this->memsourceApiService->sendApiRequest('/works/' . $work_uuid . '/dueDate', $payload, 'PUT', $headers);
        header('Content-Type: application/json');
        echo json_encode($response);
        wp_die();
    }

    function getWork() {
        $post_id = $_POST['postId'];
        $target_languages = explode(',', $_POST['targetLanguages']);
        $work_uuid = $this->postService->getWorkUuid($post_id, $target_languages);
        $response = $this->memsourceApiService->sendApiRequest('/works/' . $work_uuid, [], 'GET');
        header('Content-Type: application/json');
        echo $response;
        wp_die();
    }

    function createProject() {
        $post_id = $_POST['postId'];
        $target_languages = explode(',', $_POST['targetLanguages']);
        $work_uuid = $this->postService->getWorkUuid($post_id, $target_languages);
        $response = $this->memsourceApiService->sendApiRequest('/works/' . $work_uuid . '/submit', [], 'PUT');
        $work = json_decode($response);
        // work units
        $response = $this->memsourceApiService->sendApiRequest('/works/' . $work_uuid . '/workUnits', []);
        $work_units = json_decode($response);
        // there will be only 1 workUnit (1 post to translate)
        $work_unit = $work_units[0];
        $this->postService->saveWorkUnitId($post_id, $work_uuid, $work_unit->id);
        // set language status
        $result = $this->postService->setLanguagesStatus($post_id, $work_uuid, $target_languages, PostService::STATUS_IN_PROGRESS);
        header('Content-Type: application/json');
        echo json_encode($result);
        wp_die();
    }

    function getTranslationStatus() {
        $post_id = $_POST['postId'];
        $works = $this->postService->getWorkData($post_id);
        $languages = [];
        foreach ($works as $work) {
            $languages[] = ["code" => $work['target_language'], "status" => $work['status']];
        }
        header('Content-Type: application/json');
        echo json_encode(["languages" => $languages]);
        wp_die();
    }

    function cancelTranslation() {
        $post_id = $_POST['postId'];
        $language = $_POST['language'];
        $work_data = $this->postService->getWorkDataByLanguages($post_id, [$language]);
        $work_uuid = $work_data['work_uuid'];
        $work_unit_id = $work_data['work_unit_uuid'];
        $this->memsourceApiService->sendApiRequest('/works/' . $work_uuid . '/workUnits/' . $work_unit_id . '/language/' . $language . '/cancel', [], 'POST');
        $this->postService->deleteWorkData($post_id, $work_uuid, $language);
        header('Content-Type: application/json');
        echo json_encode(["status" => PostService::STATUS_CANCELLED]);
        wp_die();
    }

}
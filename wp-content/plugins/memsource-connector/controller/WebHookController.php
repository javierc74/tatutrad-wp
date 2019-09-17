<?php

namespace Memsource\Controller;

use Memsource\Service\MemsourceApiService;
use Memsource\Service\OptionsService;
use Memsource\Service\Content\PostService;
use Memsource\Utils\SystemUtils;
use WP_REST_Request;
use WP_REST_Server;

class WebHookController {

    private $optionsService;
    private $memsourceApiService;
    private $postService;

    function __construct(OptionsService &$optionsService, MemsourceApiService &$memsourceApiService, PostService &$postService) {
        $this->optionsService = &$optionsService;
        $this->memsourceApiService = &$memsourceApiService;
        $this->postService = &$postService;
    }

    public function registerRestRoutes() {
        $namespace = $this->optionsService->getRestNamespace();
        register_rest_route($namespace, '/webhook/job', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => array($this, 'refreshWork')
        ));
    }

    function refreshWork(WP_REST_Request $request) {
        SystemUtils::debug('Webhook received: ' . json_encode($request->get_headers()));
        $parameters = $request->get_json_params();
        SystemUtils::debug('Webhook message: ' . json_encode($parameters));
        $jobParts = $parameters['jobParts'];
        foreach ($jobParts as $jobPart) {
            $work_unit = $jobPart['workUnit'];
            if ($work_unit) {
                $work_unit_id = $work_unit['id'];
                $work_uuid = $work_unit['work']['id'];
                $status = $jobPart['status'];
                $language = $jobPart['targetLang'];
                $workflow_level = $jobPart['workflowLevel'];
                $last_workflow_level = $jobPart['project']['lastWorkflowLevel'];
                if (($status == 'COMPLETED_BY_LINGUIST' || $status == 'COMPLETED') &&
                    $workflow_level == $last_workflow_level
                ) {
                    // check if the post exists
                    $post = $this->postService->getPostByWorkUuid($work_uuid);
                    if ($post) {
                        $post_id = $post->ID;
                        // check if the work is in InProgress status
                        $can_be_translated = false;
                        $work_data = $this->postService->getWorkData($post_id);
                        foreach ($work_data as $work) {
                            if ($work['work_uuid'] == $work_uuid &&
                                $work['target_language'] == $language &&
                                $work['status'] == PostService::STATUS_IN_PROGRESS) {
                                $can_be_translated = true;
                            }
                        }
                        if ($can_be_translated) {
                            $response = $this->memsourceApiService->sendApiRequest('/works/' . $work_uuid . '/workUnits/' . $work_unit_id . '/delivery/' . $language, []);
                            preg_match('/<title( id="([^"]+)")?>(.+?)</title>(.+)$/s', $response, $output_array);
                            // extract optional $transformedSourceId from <title id="transformedSourceId">
                            $transformedSourceId = $output_array[2];
                            // extract title and content from the response
                            $title = $output_array[3];
                            $content = $output_array[4];
                            if (!ctype_space($title) && !ctype_space($content)) {
                                // store file content to the respective language version
                                $post_status = $this->optionsService->getTranslateStatus();
                                $translation = $this->postService->addOrUpdateTranslation($post->post_type, $post_status, $post_id, $language, $title, $content, $transformedSourceId);
                                $this->postService->setLanguagesStatus($post_id, $work_uuid, [$language], PostService::STATUS_COMPLETED);
                                return $translation;
                            }
                        }
                    }
                }
            }
        }
        return $parameters;
    }

}
<?php

namespace Memsource\Service;


use Memsource\Utils\SystemUtils;

class MemsourceApiService {

    private $optionsService;

    function __construct(OptionsService &$optionsService) {
        $this->optionsService = &$optionsService;
    }

    public function getApiUrlPrefix() {
        return $this->optionsService->getMemsourceApiPrefix();
    }

    public function sendApiRequest($uri, $params, $method = 'GET', $headers = array()) {
        $token = $this->optionsService->getOAuthToken();
        $response = null;
        if ($token) {
            $url = $this->getApiUrlPrefix() . $uri;
            $headers['Authorization'] = 'Bearer ' . $token;
            $args = array(
                'headers' => $headers,
                'body' => $params
            );
            if ($method == 'GET') {
                SystemUtils::debug('API call to GET ' . $url . ' with params ' . json_encode($args));
                $response = wp_remote_get($url, $args);
            } else if ($method == 'POST') {
                SystemUtils::debug('API call to POST ' . $url . ' with params ' . json_encode($args));
                $response = wp_remote_post($url, $args);
            } else {
                $args['method'] = $method;
                SystemUtils::debug('API call to ' . $method . ' ' . $url . ' with params ' . json_encode($args));
                $response = wp_remote_request($url, $args);
            }
        }
        if (!$response) {
            return 'No response.';
        }
        if (is_wp_error($response)) {
            // TODO: handle error
            return $response->get_error_data();
        }
        return wp_remote_retrieve_body($response);
    }

    public function setMultipartApiRequest($uri, $params, $files, $method = 'POST', $headers = array()) {
        // prepare multipart/form-data payload
        $payload = array();
        $boundary = wp_generate_password(24);
        $headers['Content-Type'] = 'multipart/form-data; boundary=' . $boundary;
        // add normal POST parameters
        foreach ($params as $name => $value) {
            $payload .= '--' . $boundary . "\r\n";
            $payload .= 'Content-Disposition: form-data; name="' . $name . '"' . "\r\n";
            $payload .= "\r\n";
            $payload .= $value . "\r\n";

        }
        // add files
        foreach ($files as $file) {
            $payload .= '--' . $boundary . "\r\n";
            $payload .= 'Content-Disposition: form-data; name="' . $file['name'] . '"; filename="' . $file['filename'] . '"' . "\r\n";
            $payload .= 'Content-Type: application/octet-stream' . "\r\n";
            $payload .= "\r\n";
            $payload .= $file['content'] . "\r\n";
        }
        $payload .= '--' . $boundary . '--';
        return $this->sendApiRequest($uri, $payload, $method, $headers);
    }

}

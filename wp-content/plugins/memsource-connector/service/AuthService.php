<?php

namespace Memsource\Service;


class AuthService {

    private $optionsService;

    function __construct(OptionsService &$optionsService) {
        $this->optionsService = &$optionsService;
    }

    public function checkAuth($token = NULL) {
        $token = $token ?: $_GET['token'];
        if ($token !== $this->optionsService->getToken()) {
            return array('error' => 'Invalid token: ' . $token);
        }
        if (!$this->optionsService->wpmlFound()) {
            return array('error' => 'WPML plugin not found.');
        }
        return array('token' => $token);
    }

    public function siteUrlNotSecure() {
        $site_url = get_site_url();
        return substr($site_url, 0, 8) != 'https://' && substr($site_url, 0, 16) != 'http://localhost';
    }

}
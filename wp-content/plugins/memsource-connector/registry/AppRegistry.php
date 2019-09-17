<?php

namespace Memsource\Registry;


use Memsource\Controller\ContentController;
use Memsource\Controller\UserController;
use Memsource\Page\AdvancedPage;
use Memsource\Page\ConnectorPage;
use Memsource\Page\ContentPage;
use Memsource\Page\LanguageMappingPage;
use Memsource\Page\ShortCodePage;
use Memsource\Service\AuthService;
use Memsource\Service\Content\CategoryService;
use Memsource\Service\Content\CustomPostService;
use Memsource\Service\Content\CustomTaxonomyService;
use Memsource\Service\Content\IContentService;
use Memsource\Service\Content\PageService;
use Memsource\Service\Content\TagService;
use Memsource\Service\DatabaseService;
use Memsource\Service\FilterService;
use Memsource\Service\LanguageService;
use Memsource\Service\MemsourceApiService;
use Memsource\Service\OptionsService;
use Memsource\Service\Content\PostService;
use Memsource\Service\SchemaService;
use Memsource\Service\ShortCodeService;
use Memsource\Service\TranslationService;
use Memsource\Service\UpdateService;
use Memsource\Service\WPMLService;

class AppRegistry {

    private $optionsService, $schemaService, $databaseService;
    private $memsourceApiService, $authService, $languageService, $postService, $translationService, $filterService, $wpmlService;
    private $shortCodeService, $updateService;
    private $userController, $contentController;
    private $connectorPage, $contentPage, $advancedPage, $languageMappingPage, $shortCodePage;

    function __construct() {
        require_once MEMSOURCE_PLUGIN_PATH . '/service/Content/CustomTypeTrait.php';

        require_once MEMSOURCE_PLUGIN_PATH . '/exceptions.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/service/Content/IContentService.php';

        require_once MEMSOURCE_PLUGIN_PATH . '/registry/LanguageRegistry.php';

        require_once MEMSOURCE_PLUGIN_PATH . '/utils/ActionUtils.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/utils/ArrayUtils.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/utils/DatabaseUtils.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/utils/PostUtils.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/utils/StringUtils.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/utils/SystemUtils.php';

        require_once MEMSOURCE_PLUGIN_PATH . '/service/WPMLService.php';
        $this->wpmlService = new WPMLService();
        require_once MEMSOURCE_PLUGIN_PATH . '/service/OptionsService.php';
        $this->optionsService = new OptionsService();
        require_once MEMSOURCE_PLUGIN_PATH . '/service/SchemaService.php';
        $this->schemaService = new SchemaService($this->optionsService);
        require_once MEMSOURCE_PLUGIN_PATH . '/service/DatabaseService.php';
        $this->databaseService = new DatabaseService($this->optionsService);
        require_once MEMSOURCE_PLUGIN_PATH . '/service/MemsourceApiService.php';
        $this->memsourceApiService = new MemsourceApiService($this->optionsService);
        require_once MEMSOURCE_PLUGIN_PATH . '/service/AuthService.php';
        $this->authService = new AuthService($this->optionsService);
        require_once MEMSOURCE_PLUGIN_PATH . '/service/LanguageService.php';
        $this->languageService = new LanguageService($this->optionsService, $this->databaseService, $this->wpmlService);
        require_once MEMSOURCE_PLUGIN_PATH . '/service/ShortCodeService.php';
        $this->shortCodeService = new ShortCodeService($this->optionsService);
        require_once MEMSOURCE_PLUGIN_PATH . '/service/FilterService.php';
        $this->filterService = new FilterService($this->optionsService, $this->languageService);
        require_once MEMSOURCE_PLUGIN_PATH . '/service/Content/AbstractContentService.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/service/Content/AbstractPostService.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/service/Content/AbstractCategoryService.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/service/Content/PostService.php';
        $this->postService = new PostService($this->optionsService, $this->databaseService, $this->shortCodeService, $this->filterService, $this->languageService, $this->wpmlService);
        require_once MEMSOURCE_PLUGIN_PATH . '/service/Content/CategoryService.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/service/Content/TagService.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/service/Content/PageService.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/service/TranslationService.php';;
        $this->translationService = new TranslationService($this->memsourceApiService, $this->languageService, $this->postService, $this->optionsService);
        require_once MEMSOURCE_PLUGIN_PATH . '/service/UpdateService.php';
        $this->updateService = new UpdateService();

        require_once MEMSOURCE_PLUGIN_PATH . '/service/Content/CustomPostService.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/service/Content/CustomTaxonomyService.php';

        require_once MEMSOURCE_PLUGIN_PATH . '/controller/UserController.php';
        $this->userController = new UserController($this->optionsService, $this->authService, $this->languageService, $this->memsourceApiService);
        require_once MEMSOURCE_PLUGIN_PATH . '/controller/ContentController.php';
        $this->contentController = new ContentController($this->optionsService, $this->authService, $this->databaseService);
        $this->contentController->addContentService($this->postService);
        $this->contentController->addContentService(new PageService($this->optionsService, $this->databaseService, $this->shortCodeService, $this->filterService, $this->languageService, $this->wpmlService));
        $this->contentController->addContentService(new CategoryService($this->wpmlService));
        $this->contentController->addContentService(new TagService($this->wpmlService));

        require_once MEMSOURCE_PLUGIN_PATH . '/page/AbstractPage.php';
        require_once MEMSOURCE_PLUGIN_PATH . '/page/ConnectorPage.php';
        $this->connectorPage = new ConnectorPage($this->optionsService, $this->memsourceApiService, $this->authService);
        require_once MEMSOURCE_PLUGIN_PATH . '/page/AdvancedPage.php';
        $this->advancedPage = new AdvancedPage($this->optionsService);
        require_once MEMSOURCE_PLUGIN_PATH . '/page/ShortCodePage.php';
        $this->shortCodePage = new ShortCodePage($this->optionsService, $this->shortCodeService);
        require_once MEMSOURCE_PLUGIN_PATH . '/page/LanguageMappingPage.php';
        $this->languageMappingPage = new LanguageMappingPage($this->databaseService, $this->languageService);
        require_once MEMSOURCE_PLUGIN_PATH . '/page/ContentPage.php';
        $this->contentPage = new ContentPage($this->databaseService);
    }

    function initOptions() {
        $this->optionsService->initOptions();
    }

    function initSchema() {
        $this->schemaService->createDatabaseSchema();
        $this->schemaService->seedData();
    }

    function initPages() {
        $this->connectorPage->initPage();
        $this->contentPage->initPage();
        $this->advancedPage->initPage();
        $this->languageMappingPage->initPage();
        $this->shortCodePage->initPage();
    }

    function initRestRoutes() {
        $this->userController->registerRestRoutes();
        $this->contentController->registerRestRoutes();
    }

    function initShortCodes() {
        $this->shortCodeService->init();
    }

    function getOptions() {
        return $this->optionsService;
    }

    function getUpdate() {
        return $this->updateService;
    }

    function getDatabase(){
        return $this->databaseService;
    }

    function getLanguageMappingPage() {
        return $this->languageMappingPage;
    }

    function getContentPage() {
        return $this->contentPage;
    }

    function getContentController() {
        return $this->contentController;
    }

    /**
     * Add a content service object to content controller class.
     * @param $service IContentService
     * @param $throw bool throw exception if content exist already
     * @return IContentService
     * @throws \Exception
    */
    public function addContentServiceToContentController(IContentService $service, $throw = true)
    {
        try{
            $contentController = $this->getContentController();
            $contentController->addContentService($service);
        } catch (\Exception $exception){
            if ($throw === true){
               throw $exception;
            }
        }
        return $service;
    }

    /**
     * Create CustomPostService object.
     * @param $type \WP_Post_Type
     * @return CustomPostService
    */
    public function createCustomPostService(\WP_Post_Type $type)
    {
        $customTypeService = new CustomPostService($this->optionsService, $this->databaseService, $this->shortCodeService, $this->filterService, $this->languageService, $this->wpmlService);
        $customTypeService->setType($type->name);
        $customTypeService->setLabel($type->label);
        return $customTypeService;
    }

    /**
     * Create CustomTaxonomyService object.
     * @param $taxonomy \WP_Taxonomy
     * @return CustomTaxonomyService
    */
    public function createCustomTaxonomyService(\WP_Taxonomy $taxonomy)
    {
        $service = new CustomTaxonomyService($this->wpmlService);
        $service->setType($taxonomy->name);
        $service->setLabel($taxonomy->label);
        return $service;
    }
}
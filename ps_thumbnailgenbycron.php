<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/classes/ThumbGenerator.php';

class Ps_thumbnailgenbycron extends Module
{
    protected $thumbGenerator;

    public function __construct()
    {
        $this->name = 'ps_thumbnailgenbycron';
        $this->tab = 'quick_bulk_update';
        $this->version = '1.0.0';
        $this->author = 'PululuK';
        $this->need_instance = 1;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Thumbnail generator by cron');
        $this->description = $this->l('Thumbnail generator by cron');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall my module?');

        $this->ps_versions_compliancy = [
            'min' => '1.7', 
            'max' => _PS_VERSION_
        ];

        $this->thumbGenerator = new ThumbGenerator($this);
    }

    public function install()
    {
        Configuration::updateValue('PS_THUMBNAILGENBYCRON_KEY', Tools::passwdGen(32));
        return parent::install() && $this->registerHook('backOfficeHeader');
    }

    public function getThumbGenerator()
    {
        return $this->thumbGenerator;
    }

    public function getContent()
    {
        if (((bool)Tools::isSubmit('submitPs_thumbnailgenbycronModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign($this->thumbGenerator->getTemplateVarPage());

        return $this->display(__FILE__, 'views/templates/admin/configure.tpl');
    }

    public function ajaxProcessThumbGenerator()
    {
        $status = $this->thumbGenerator->regenerateThumbnails(
            (string) Tools::getValue('type'), 
            (bool) Tools::getValue('erase')
        );

        echo json_encode([
            'status' => $status,
            'errors' => $this->thumbGenerator->getErrors(),
        ]);

        die();
    }

    public function hookBackOfficeHeader()
    {
        $isModuleController = is_a($this->context->controller, AdminModulesController::class);
        $isCurrentModuleConfigPage = Tools::getValue('configure') == $this->name;

        if ($isCurrentModuleConfigPage && $isModuleController) {
            Media::addJsDef([
                'ajax_url' => $this->context->link->getAdminLink(
                    'AdminModules',
                    true,
                    [],
                    [
                        'configure' => $this->name,
                        'action' => 'ThumbGenerator',
                        'ajax' => 1,
                    ]
                ),
            ]);

            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    public function getContext()
    {
        return $this->context;
    }
}

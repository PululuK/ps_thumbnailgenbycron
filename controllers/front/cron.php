
<?php

class Ps_thumbnailgenbycronCronModuleFrontController extends ModuleFrontController
{
    public function init()
    {
        parent::init();

        $key = Tools::getValue('key');
        if ($key == '' || $key != Configuration::get('PS_THUMBNAILGENBYCRON_KEY')) {
            die('403');
        }

        $thumbGenerator = $this->module->getThumbGenerator();

        try {
            if(!$thumbGenerator->regenerateThumbnails(
                (string) Tools::getValue('type_id'), 
                (bool) Tools::getValue('erase')
            )) {
                foreach ($thumbGenerator->getErrors() as $error) {
                    echo $error.'<br>';
                }
            } else {
                echo 'Ok <br>';
            }
        } catch (Exception $e) {
            echo $e->getMessage().'<br>';
        }

        die();
    }
}
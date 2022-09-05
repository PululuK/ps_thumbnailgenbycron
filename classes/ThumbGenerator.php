<?php


class ThumbGenerator extends AdminImagesController
{
    protected $availableTypes = [];
    protected $module;
    protected $translator;

    public function __construct(Ps_thumbnailgenbycron $module)
    {        
        $this->module = $module;
        $this->translator = $module->getTranslator();

        $this->availableTypes = [
            'categories' => $this->translator->trans('Categories', [], 'Admin.Global'),
            'manufacturers' => $this->translator->trans('Brands', [], 'Admin.Global'),
            'suppliers' => $this->translator->trans('Suppliers', [], 'Admin.Global'),
            'products' => $this->translator->trans('Products', [], 'Admin.Global'),
            'stores' => $this->translator->trans('Stores', [], 'Admin.Global'),
        ];
    }

    public function regenerateThumbnails(string $type = 'all', bool $deleteOldImages = false)
    {
        return $this->_regenerateThumbnails($type, $deleteOldImages);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getTemplateVarPage()
    {
        $formats = [];
        $allLabel = $this->translator->trans('All', [], 'Admin.Global');
        $cronUrls[$allLabel] = $this->generateCronUnl('all', true);

        foreach ($this->availableTypes as $typeId => $type) {
            $formats[$typeId] = ImageType::getImagesTypes($typeId);
            $cronUrls[$type] = $this->generateCronUnl($typeId, true);
        }

        return [
            'types' => $this->availableTypes,
            'formats' => $formats,
            'cronUrls' => $cronUrls,
        ];
    }

    protected function generateCronUnl(string $typeId, bool $erase = false)
    {
        return Context::getContext()->link->getModuleLink(
            $this->module->name, 
            'cron',
            [
                'type_id' => $typeId,
                'erase' => $erase,
                'key' => Configuration::get('PS_THUMBNAILGENBYCRON_KEY'),
            ]
        );
    }
}
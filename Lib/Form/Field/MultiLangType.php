<?php

namespace Apps\CM_GradeService\Lib\Form\Field;


abstract class MultiLangType extends AbstractType
{
    protected $oLang;
    protected $oRequest;
    protected $sDefLangId;

    public function __construct(array $aData)
    {
        $this->oLang = \Language_Service_Language::instance();
        $this->oRequest = \Phpfox_Request::instance();
        parent::__construct($aData);
        $this->aInfo['aLanguages'] = $this->oLang->getAll();
        $this->sDefLangId = $this->oLang->getDefaultLanguage();
    }

    public function getValue()
    {
        $sPhrase = parent::getValue();
        $sName = $this->aInfo['name'];
        $aLanguages = $this->aInfo['aLanguages'];
        $sModule = isset($this->aInfo['module']) ? $this->aInfo['module'] : 'core';
        if (is_null($sPhrase)) {
            //insert phrase
            $sDefText = $this->oRequest->get($sName . '_' . $this->sDefLangId, $sModule . '.' . $sName);
            $aText = [];
            foreach ($aLanguages as $aLanguage) {
                $aText[$aLanguage['language_id']] = $this->oRequest->get($sName . '_' . $aLanguage['language_id'], $sDefText);
            }
            $sPhrase = $sName . '_multi_lang_string_' . md5($sName . PHPFOX_TIME . rand(1, 9000));
            $aPhrase = [
                'product_id' => 'phpfox',
                'module' => $sModule . '|' . $sModule,
                'var_name' => $sPhrase,
                'text' => $aText
            ];
            $sPhrase = \Language_Service_Phrase_Process::instance()->add($aPhrase);

        } elseif (!is_null($sPhrase) && \Phpfox::isPhrase($sPhrase)) {
            //update phrase
            foreach ($aLanguages as $aLanguage) {
                if ($this->oRequest->get($sName . '_' . $aLanguage['language_id'])) {
                    $sText = $this->oRequest->get($sName . '_' . $aLanguage['language_id']);
                    \Language_Service_Phrase_Process::instance()->updateVarName($aLanguage['language_id'], $sPhrase, $sText);
                }
            }

        }

        return $sPhrase;
    }

    public function isEmpty()
    {
        return !(bool)$this->oRequest->get($this->aInfo['name'] . '_' . $this->sDefLangId, false);
    }

    public function getDisplay()
    {
        return _p($this->aInfo['value']);
    }
}
<?php

namespace Apps\CM_GradeService\Lib\Form\Field\Type;

use Apps\CM_GradeService\Lib\Form\Field\AbstractType;
use Phpfox;

class StringType extends AbstractType
{
    protected $aInfo  = [
        'template' => '@CM_GradeService/form/fields/string.html',
    ];

    public function setCondition(\Phpfox_Search &$oSearch, $aSearch)
    {
        $sKey = $this->aInfo['column'];
        $sTAlias = $this->aInfo['table_alias'];
        if (($sValue = $oSearch->get($sKey)) || (isset($aSearch[$sKey]) && $sValue = $aSearch[$sKey])) {
            $oSearch->setCondition('AND `' . $sTAlias . '`.`' . $sKey . '` LIKE \'%'
                . Phpfox::getLib('parse.input')->clean($sValue, 300)
                . '%\'');
        }
    }
}
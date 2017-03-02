<?php

namespace Apps\CM_GradeService\Lib\Form\Field\Type;

use Apps\CM_GradeService\Lib\Form\Field\AbstractType;

class StaticType extends AbstractType
{
    protected $aInfo  = [
        'template' => '@CM_GradeService/form/fields/static.html',
    ];

    public function getFilter($sTableAlias)
    {
        $aInfo = $this->aInfo;
        return null;
    }
}
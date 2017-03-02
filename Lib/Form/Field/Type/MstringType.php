<?php

namespace Apps\CM_GradeService\Lib\Form\Field\Type;

use Apps\CM_GradeService\Lib\Form\Field\MultiLangType;

class MstringType extends MultiLangType
{
    protected $aInfo  = [
        'template' => '@CM_GradeService/form/fields/multi-lang-string.html',
    ];
}
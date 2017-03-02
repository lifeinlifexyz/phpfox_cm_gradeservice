<?php

namespace Apps\CM_GradeService\Lib\CustomFieldType;


use Apps\CM_GradeService\Lib\Form\Field\Type\SelectType;

class Controllers extends SelectType
{
    protected $aInfo  = [
        'template' => '@CM_GradeService/form/custom_fields/controllers.html',
    ];
}
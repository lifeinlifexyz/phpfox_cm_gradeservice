<?php
namespace Apps\CM_GradeService\Lib\Form\Field\Type;

use Apps\CM_GradeService\Lib\Form\Field\AbstractType;

class SubmitType extends AbstractType
{
    protected $aInfo = [
        'template' => '@CM_GradeService/form/fields/submit.html',
    ];
}
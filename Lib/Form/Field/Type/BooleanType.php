<?php
namespace Apps\CM_GradeService\Lib\Form\Field\Type;

use Apps\CM_GradeService\Lib\Form\Field\AbstractType;

class BooleanType extends AbstractType
{
    protected $aInfo  = [
        'template' => '@CM_GradeService/form/fields/boolean.html',
    ];

    protected $aColumnDefinitions = [
        [
            'type' => 'tinyint(1)',
            'default' => 'DEFAULT \'0\'',
        ]
    ];

    public function getDisplay()
    {
        return (isset($this->aInfo['value']) && $this->aInfo['value']) ? _p('Yes') : _p('No');
    }
}
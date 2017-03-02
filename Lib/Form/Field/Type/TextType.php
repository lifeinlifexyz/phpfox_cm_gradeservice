<?php
namespace Apps\CM_GradeService\Lib\Form\Field\Type;

class TextType extends StringType
{

    protected $aColumnDefinitions = [
        [
            'type' => 'VARCHAR(5000)',
            'null' => 'NULL',
        ]
    ];

    protected $aInfo  = [
        'template' => '@CM_GradeService/form/fields/text.html',
    ];

}
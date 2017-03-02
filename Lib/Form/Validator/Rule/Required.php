<?php
namespace Apps\CM_GradeService\Lib\Form\Validator\Rule;

class Required extends AbstractRule
{

    public function validate($sField, $sValue)
    {
        if (empty($sValue)) {
            $sMessage = empty($this->sErrorMessage)
                ? 'The field "' . $sField .'" is required'
                : $this->sErrorMessage;

            $this->oValidator->addError($sField, $sMessage);
        }
    }
}
<?php

namespace Apps\CM_GradeService\Lib\Form\Validator\Rule;

Interface IRule
{
    /**
     * @param $aMessages
     * @return $this
     */
    public function setErrorMessage($aMessages);
}
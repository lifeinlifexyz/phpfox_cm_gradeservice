<?php

namespace Apps\CM_GradeService\Lib\Form\DataBinding;

interface IForm
{
    /**
     * @return $this
     */
    public function save();

    /**
     * @return boolean
     */
    public function isValid();
}
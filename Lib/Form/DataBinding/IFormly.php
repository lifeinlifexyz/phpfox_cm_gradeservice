<?php

namespace Apps\CM_GradeService\Lib\Form\DataBinding;

interface IFormly
{
    /**
     * return array of fields info
     * @return array
     */
     public function getFieldsInfo();

    /**
     * return primary key name(id)
     * @return string
     */
     public function getKeyName();

    /**
     * return id value. It is new object if null
     * @return string | int | null
     */
     public function getKey();

    /**
     * @param $mKey - string | int
     * @return $this
     */
     public function setKey($mKey);

    /**
     * return table name
     * @return string
     */
    public function getTableName();

    /**
     * @param array $aFormData
     * @return IForm
     */
    public function getForm(array $aFormData = []);


}
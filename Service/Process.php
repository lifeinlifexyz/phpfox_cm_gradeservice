<?php

namespace Apps\CM_GradeService\Service;

use Apps\CM_GradeService\Lib\Form\DataBinding\FormlyTrait;
use Apps\CM_GradeService\Lib\Form\DataBinding\IFormly;
use Phpfox;

class Process extends \Phpfox_Service implements IFormly
{
    use FormlyTrait;

    protected $_sTable = 'gradeservice_questions';
    protected $sKeyName = 'question_id';

    /**
     * return array of fields info
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'question' => [
                'type' => 'mstring',
                'name' => 'question',
                'module' => 'gradeservice',
                'title' => _p('Question'),
                'rules' => 'required',
            ],
            'm_connection' => [
                'type' => 'controllers',
                'name' => 'm_connection',
                'title' => _p('Controller'),
                'controllers' => Phpfox::getService('admincp.component')->get(true),
            ],
            'max_rate' => [
                'type' => 'string',
                'name' => 'max_rate',
                'title' => _p('Max rate'),
                'rules' => 'required|num|2:min|15:max',
            ],
            'is_active' => [
                'type' => 'boolean',
                'name' => 'is_active',
                'title' => _p('Active'),
                'rules' => '0:1:in',
                'filter' => function ($sValue) {
                    return (int)$sValue;
                }
            ],
        ];
    }

    /**
     * @param $iStatus integer
     * @param $iId int
     * @return bool
     */
    public function setStatus($iStatus, $iId)
    {
        return $this->database()->update(\Phpfox::getT($this->_sTable),
            ['`is_active`' => $iStatus], '`' . $this->mKey . '` = ' . (int) $iId);
    }

    public function delete($iId)
    {
        $this->database()->delete(\Phpfox::getT($this->_sTable),  '`' . $this->mKey . '` = ' . $iId);
    }
}
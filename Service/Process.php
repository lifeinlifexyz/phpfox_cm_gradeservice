<?php

namespace Apps\CM_GradeService\Service;

use Apps\CM_GradeService\Lib\Cache\CMCache;
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
        $aControllers = Phpfox::getService('gradeservice')->getUsedControllers();

        foreach($aControllers as $key => $iContrller) {
            $aControllers[$key] = (int)  $iContrller;

        }

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
                'rules' => empty($aControllers) ? 'num' : implode(':', $aControllers) . ':notin',
                'errorMessages' => [
                   'm_connection.notin' => _p('This controller used already'),
                ],
            ],
            'max_rate' => [
                'type' => 'string',
                'name' => 'max_rate',
                'title' => _p('Max rate'),
                'rules' => 'required|num|2:min|10:max',
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
        CMCache::remove('gradeservice_questions');
        return $this->database()->update(\Phpfox::getT($this->_sTable),
            ['`is_active`' => $iStatus], '`' . $this->sKeyName . '` = ' . (int) $iId);
    }

    public function delete($iId)
    {
        CMCache::remove('gradeservice_questions');
        $this->database()->delete(\Phpfox::getT($this->_sTable),  '`' . $this->sKeyName . '` = ' . (int)$iId);
    }

    public function rate($iId, $iRate)
    {

        $sAlreadyRates = Phpfox::getCookie('gradeservice_rate');
        $aAlreadyRates = empty($sAlreadyRates) ? [] : json_decode($sAlreadyRates, true);
        $aAlreadyRates[$iId] = $iId;
        Phpfox::setCookie('gradeservice_rate', json_encode($aAlreadyRates));

        $this->database()->insert(Phpfox::getT('gradeservice_rating'), [
            'question_id' => $iId,
            'rating' => $iRate,
            'user_id' => Phpfox::getUserId(),
            'time_stamp' => PHPFOX_TIME,
            'ip_address' => $this->request()->getIp(),
        ]);

        if ($iRate > -1) {
            $aRating = $this->calculateRating($iId);

            $this->database()
                ->update(Phpfox::getT($this->_sTable), $aRating, '`question_id` = ' .$iId);
            CMCache::remove('gradeservice_questions');
        }
    }

    public function calculateRating($iId)
    {
        return $this->database()
            ->select('avg(`rating`) as `rating`, count(*) as `count`')
            ->from(Phpfox::getT('gradeservice_rating'))
            ->where('`question_id` = ' . $iId)
            ->get();
    }
}
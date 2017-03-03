<?php

namespace Apps\CM_GradeService\Service;

use Apps\CM_GradeService\Lib\Cache\CMCache;
use Phpfox;
use Phpfox_Plugin;

class GradeService extends \Phpfox_Service
{

    protected $_sTable = 'gradeservice_questions';
    protected $_sModule;
    protected $_sController;
    protected $_aActiveQuestions = [];

    public function all()
    {
        return $this->database()
            ->select("*")
            ->from(\Phpfox::getT($this->_sTable))
            ->order("`question_id` DESC")
            ->all();
    }

    public function getRatingDetails($iQuestionId)
    {
        return $this->database()
            ->select('u.*, r.*')
            ->from(Phpfox::getT('gradeservice_rating'), 'r')
            ->leftJoin(Phpfox::getT('user'), 'u', 'u.user_id = r.user_id')
            ->where('question_id=' . $iQuestionId)
            ->all();
    }

    public function getActive()
    {
        $that = $this;
        return CMCache::remember('gradeservice_questions', function() use ($that) {
            return $this->database()
                ->select("*")
                ->from(\Phpfox::getT($this->_sTable))
                ->where('is_active=1')
                ->order("`question_id` DESC")
                ->all();
        });
    }

    public function getUserRates()
    {
        static $aGSUserRates;

        if (!empty($aGSUserRates)) {
            return $aGSUserRates;
        }
        $aRates = $this->database()
            ->select('*')
            ->from(Phpfox::getT('gradeservice_rating'))
            ->where([
                ' AND user_id=' . Phpfox::getUserId(),
            ])->all();

        foreach($aRates as $aRate) {
            $aGSUserRates[$aRate['user_id']][$aRate['question_id']] = $aRate;
        }

        return $aGSUserRates;
    }

    public function hasUserRate($iId)
    {
        $sRates = \Phpfox::getCookie('gradeservice_rate');
        $aRate = empty($sRates) ? [] : json_decode($sRates, true);
        if (isset($aRate[$iId])) {
            return true;
        }

        $aUserRate = $this->getUserRates();
        return isset($aUserRate[Phpfox::getUserId()][$iId]);
    }

    public function getModuleQuestions()
    {

        $this->_sModule = \Phpfox_Module::instance()->getModuleName();
        $this->_sController = \Phpfox_Module::instance()->getControllerName();

        (($sPlugin = Phpfox_Plugin::get('gradeservice.get_module_questions')) ? eval($sPlugin) : false);

        $sController = strtolower($this->_sModule . '.' . str_replace(['\\', '/'], '.', $this->_sController));

        if (empty($this->_aActiveQuestions)) {
            $aQuestions = $this->getActive();
            foreach($aQuestions as &$aQuestion) {
                $this->_aActiveQuestions[$aQuestion['m_connection']] = $aQuestion;
            }
        }

        $aRes = null;
        if (isset($this->_aActiveQuestions[$sController])
            && !$this->hasUserRate($this->_aActiveQuestions[$sController]['question_id'])) {

            $aRes = $this->_aActiveQuestions[$sController];

        } elseif(isset($this->_aActiveQuestions[str_replace('.index', '', $sController)])
            && !$this->hasUserRate($this->_aActiveQuestions[str_replace('.index', '', $sController)]['question_id']))  {

            $aRes = $this->_aActiveQuestions[str_replace('.index', '', $sController)];
        } elseif (isset($this->_aActiveQuestions[$this->_sModule])
            && !$this->hasUserRate($this->_aActiveQuestions[$this->_sModule]['question_id'])) {

            $aRes = $this->_aActiveQuestions[$this->_sModule];

        } elseif (isset($this->_aActiveQuestions[''])
            && !$this->hasUserRate($this->_aActiveQuestions['']['question_id'])) {

            $aRes = $this->_aActiveQuestions[''];

        }

        return $aRes;
    }

}
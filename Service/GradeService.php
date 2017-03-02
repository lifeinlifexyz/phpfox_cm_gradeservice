<?php

namespace Apps\CM_GradeService\Service;

use Phpfox;

class GradeService extends \Phpfox_Service
{

    protected $_sTable = 'gradeservice_questions';

    public function all()
    {
        return $this->database()
            ->select("*")
            ->from(\Phpfox::getT($this->_sTable))
            ->order("`question_id` DESC")
            ->all();
    }

    public function getActive()
    {
        return $this->database()
            ->select("*")
            ->from(\Phpfox::getT($this->_sTable))
            ->where('is_active=1')
            ->order("`question_id` DESC")
            ->all();
    }

}
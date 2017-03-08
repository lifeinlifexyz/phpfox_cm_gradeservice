<?php


namespace Apps\CM_GradeService\Block;


use Phpfox;

class Question extends \Phpfox_Component
{
    public function process()
    {
        if (!\Phpfox::isUser() || !Phpfox::getUserParam('gradeservice.view_gradeservice')) {
            return false;
        }
        $aQuestion = \Phpfox::getService('gradeservice')->getModuleQuestions();

        if (!empty($aQuestion)) {

            $aRate = [];
            for($i = 1; $i <= $aQuestion['max_rate']; $i++){
                $aRate[] = $i;
            }
            $aQuestion['rate'] = $aRate;
            $this->template()->assign('aQuestion', $aQuestion);
            return 'block';
        }
        return false;
    }
}
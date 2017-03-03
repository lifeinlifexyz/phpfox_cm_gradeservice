<?php


namespace Apps\CM_GradeService\Block;


class Question extends \Phpfox_Component
{
    public function process()
    {
        if (!\Phpfox::isUser()) {
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
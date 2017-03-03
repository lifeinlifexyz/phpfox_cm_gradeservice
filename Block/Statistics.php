<?php


namespace Apps\CM_GradeService\Block;


class Statistics extends \Phpfox_Component
{
    public function process()
    {
        if (!\Phpfox::isAdmin()) {
            return false;
        }

        $aQuestions = \Phpfox::getService('gradeservice')->getActive();

        $aRating = [];
        $aVotes = [];

        foreach($aQuestions as $aQuestion) {
            if (empty($aQuestion['m_connection'])) {
                $aQuestion['m_connection'] = _p('Site Wide');
            }
            $aRating[$aQuestion['m_connection']] = $aQuestion['rating'];
            $aVotes[$aQuestion['m_connection']] = $aQuestion['count'];
        }
        $this->template()
            ->assign([
            'sRating' => json_encode($aRating),
            'sVotes' => json_encode($aVotes),
        ]);
        return 'block';
    }
}
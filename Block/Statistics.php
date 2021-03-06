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

        if (empty($aQuestions)) {
            return false;
        }

        $aRating = [];
        $aVotes = [];
        $bHasStat = false;

        foreach($aQuestions as $aQuestion) {
            if ($aQuestion['rating'] == -1) {
                continue;
            }
            if (empty($aQuestion['m_connection'])) {
                $aQuestion['m_connection'] = _p('Site Wide');
            }
            if ($aQuestion['rating'] > 0 || $aQuestion['count']) {
                $bHasStat = true;
            }
            $aRating[$aQuestion['m_connection']] = $aQuestion['rating'];
            $aVotes[$aQuestion['m_connection']] = $aQuestion['count'];
        }

        if (!$bHasStat) {
            return false;
        }
        $this->template()
            ->assign([
            'sRating' => json_encode($aRating),
            'sVotes' => json_encode($aVotes),
        ]);
        return 'block';
    }
}
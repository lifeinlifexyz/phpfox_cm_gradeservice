<?php
namespace Apps\CM_GradeService\Ajax;

use Phpfox;
use Phpfox_Ajax;

class Ajax extends Phpfox_Ajax
{
    public function setStatus()
    {
        \Phpfox::isAdmin(true);
        \Phpfox::getService('gradeservice.process')->setStatus($this->get('status'), $this->get('id'));
    }

    public function rate()
    {
        Phpfox::isUser(true);
        Phpfox::getUserParam('gradeservice.view_gradeservice', true);

        $iId = (int)$this->get('id');
        $iRate = (int)$this->get('rate');

        Phpfox::getService('gradeservice.process')->rate($iId, $iRate);
        $this->call('$("#grade-service").addClass("rated").addClass("hover").addClass("cm-alert").addClass("cm-alert-success");');

        if ($iRate >= 0) {
            $this->call('$("#grade-service").html("' . _p('Thanks for your feedback') . '");');
        }

        $this->call('setTimeout(function(){$("#grade-service").slideUp(300);},3000);');

    }
}
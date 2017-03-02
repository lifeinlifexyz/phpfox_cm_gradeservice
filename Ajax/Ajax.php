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
}
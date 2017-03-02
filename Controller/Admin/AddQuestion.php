<?php

namespace Apps\CM_GradeService\Controller\Admin;

use Apps\CM_GradeService\Lib\Form\DataBinding\IFormly;
use Phpfox;
use Phpfox_Component;
use Phpfox_Plugin;

defined('PHPFOX') or exit('NO DICE!');

class AddQuestion extends Phpfox_Component
{
    public function process()
    {
        Phpfox::isAdmin(true);
        /**
         * @var $oProcess IFormly
         */
        $oProcess = Phpfox::getService('gradeservice.process');
        if (($iId = $this->request()->getInt('id'))) {
            $oProcess->setKey($iId);
        }

        $oForm = $oProcess->getForm([
            'action' => $this->url()->makeUrl('current'),
        ]);


        if ($_POST && $oForm->isValid()) {
            $oForm->save();
            $this->url()->send('admincp.app',
                [
                    'id' => 'CM_GradeService',
                ],
                _p('Successfully saved the question.'));
        }
        $sTitle = !empty($iId) ? _p('Edit question') : _p('Add question');
        $this->template()
            ->setTitle($sTitle)
            ->setBreadCrumb($sTitle)
            ->assign('form', $oForm);
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('gradeservice.component_controller_admincp_add_question_clean')) ? eval($sPlugin) : false);
    }
}
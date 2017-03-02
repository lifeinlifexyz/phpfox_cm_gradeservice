<?php

namespace Apps\CM_GradeService\Controller\Admin;

use Apps\CM_GradeService\Lib\Form\DataBinding\IFormly;
use Phpfox;
use Phpfox_Component;
use Phpfox_Plugin;

defined('PHPFOX') or exit('NO DICE!');

class Questions extends Phpfox_Component
{
	public function process()
	{
		Phpfox::isAdmin(true);
		/**
		 * @var $oGradeService IFormly
		 */
		$oGradeService = Phpfox::getService('gradeservice');
		$aDelete = $this->request()->getArray('delete');

		if (!empty($aDelete)) {
			foreach($aDelete as $sFieldID) {
				Phpfox::getService('gradeservice.process')->delete($sFieldID);
			}
			$sMessage =  (count($aDelete) > 1) ? _p('Successfully deleted questions.') : _p('Successfully deleted the question.');
			$this->url()->send('admincp.app', ['id' => 'CM_GradeService'], $sMessage);
		}

		$this->template()
			->setTitle(_p('Questions'))
			->setBreadCrumb(_p('Questions'))
			->assign('aQuestions', $oGradeService->all());
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('gradeservice.component_controller_admincp_fields_clean')) ? eval($sPlugin) : false);
	}
}
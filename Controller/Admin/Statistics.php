<?php

namespace Apps\CM_GradeService\Controller\Admin;

use Apps\CM_GradeService\Lib\Form\DataBinding\IFormly;
use Apps\CM_GradeService\Service\GradeService;
use Phpfox;
use Phpfox_Component;
use Phpfox_Plugin;

defined('PHPFOX') or exit('NO DICE!');

class Statistics extends Phpfox_Component
{
	public function process()
	{
		Phpfox::isAdmin(true);
		/**
		 * @var $oGradeService GradeService
		 */
		$oGradeService = Phpfox::getService('gradeservice');

		$this->template()
			->setTitle(_p('Statistics'))
			->setBreadCrumb(_p('Statistics'));

		if (($iId = $this->request()->getInt('id'))) {
			$aRates = $oGradeService->getRatingDetails($iId);

			if (empty($aRates)) {
				return false;
			}

			$this->template()->assign([
				'aRates' => $aRates,
			]);

			return 'block';
		}
	}

	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('gradeservice.component_controller_admincp_stat_clean')) ? eval($sPlugin) : false);
	}
}
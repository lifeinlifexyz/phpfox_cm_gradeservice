<?php

//todo:: close the download dir for read

\Phpfox_Module::instance()
    ->addServiceNames([
    ])
    ->addComponentNames('controller', [
    ])
    ->addAliasNames('gradeservice', 'CM_GradeService');

event('app_settings', function ($settings){
    if (isset($settings['cm_dd_enabled'])) {
        \Phpfox::getService('admincp.module.process')->updateActivity('CM_GradeService', $settings['cm_gradeservice_enabled']);
    }
});

if (setting('cm_gradeservice_enabled') && Phpfox::getUserParam('gradeservice.view_gradeservice')) {
    \Phpfox_Module::instance()->addComponentNames('ajax', [
        'gradeservice.ajax'        => '\Apps\CM_GradeService\Ajax\Ajax',
    ])->addComponentNames('block', [
        'gradeservice.question'    => '\Apps\CM_GradeService\Block\Question'
    ]);
}

group('/admincp/gradeservice/', function(){

    route('questions', 'gradeservice.admincp.questions');

    /**
     * set status
     */
    route('questions/status', function(){
        \Phpfox::isAdmin(true);
        $iStatus = request()->getInt('status');
        $iIds = request()->get('ids');
        Phpfox::getService('gradeservice.question')->setStatus($iStatus, $iIds);
    });

    /**
     * delete question
     */
    route('questions/delete', function(){
        \Phpfox::isAdmin(true);
        Phpfox::getService('gradeservice.question')->delete(request()->getInt('id'));
    });

});
group('/gradeservice/', function (){

    route('admincp/add-question', 'gradeservice.admincp.add-question');
});
<?php

defined('PHPFOX') or exit('NO DICE!');
?>
<div class="modal" tabindex="-1" role="dialog" id="grade-service" data-id="{$aQuestion.question_id}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p class="grade-service-question">{phrase var=$aQuestion.question}</p>
                <p class="grade-service-rates">
                    {foreach from=$aQuestion.rate item=iRate}
                    <a title="{$iRate}" href="#?call=gradeservice.rate&amp;id={$aQuestion.question_id}&amp;rate={$iRate}"class="cm-vote-action">
                        <span>{$iRate}</span>
                    </a>
                    {/foreach}
                </p>
            </div>
        </div>
    </div>
</div>
{literal}
<script>
    $Behavior.openGrageServiceWindow = function(){

        $('#grade-service').modal('show');
        $('.modal-backdrop').removeClass("modal-backdrop");

        $('#grade-service').on('hidden.bs.modal', function() {

            if ($(this).hasClass('rated')) {
                return;
            }

            var sParams = 'id=' + $(this).data('id') + '&rate=-1';
            $.ajaxCall('gradeservice.rate', sParams + '&global_ajax_message=true');
        });

        $('.cm-vote-action').off('click').on('click', function(e){
            e.preventDefault();
            aParams = $.getParams(this.href);
            var sParams = '';
            for (sVar in aParams)
            {
                sParams += '&' + sVar + '=' + aParams[sVar] + '';
            }
            sParams = sParams.substr(1, sParams.length);

            $Core.ajaxMessage();
            $.ajaxCall(aParams['call'], sParams + '&global_ajax_message=true');
            return false;
        })
    }
</script>
{/literal}
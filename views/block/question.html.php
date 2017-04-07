<?php

defined('PHPFOX') or exit('NO DICE!');
?>
<div id="grade-service" data-id="{$aQuestion.question_id}">
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
{literal}
<script>
    $Behavior.initGrageService = function(){
        var container = $('#grade-service');

        container.slideDown(300);

        setTimeout(function(){
            if (!container.hasClass('hover')) {
                container.slideUp(300, function(){
                    container.trigger('cm_gs_close');
                });
            }
        },10000);

        container.on('mouseenter', function(){
            $(this).addClass('hover');
        });

        container.on('mouseleave', function(){
            $(this).removeClass('hover');
        });

        container.on('cm_gs_close', function() {
            if ($(this).hasClass('rated')) {
                return;
            }
            var sParams = 'id=' + $(this).data('id') + '&rate=-1';
            $.ajaxCall('gradeservice.rate', sParams + '&global_ajax_message=true');
        });

        container.find('.close').off('click').on('click', function(){
            container.slideUp(300, function(){
                container.trigger('cm_gs_close');
            });
        });

        container.find('.cm-vote-action').off('click').on('click', function(e){
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
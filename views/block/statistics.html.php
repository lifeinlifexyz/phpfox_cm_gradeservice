<?php

defined('PHPFOX') or exit('NO DICE!');
?>
<div>
    <div class="block">
        <div class="title">
            {_p('Assessment service')}
        </div>
        <div class="content">
            <div class="t_center">
                <div class="row">
                    <div class="col-sm-6">
                        <div id="cm-gs-chart-votes" data-data='{$sVotes}' title="{_p('Votes')}"></div>
                    </div>
                    <div class="col-sm-6">
                        <div id="cm-gs-chart-rating" data-data='{$sRating}' title="{_p('Rating')}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

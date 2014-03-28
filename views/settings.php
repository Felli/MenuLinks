<?php
// Copyright 2013 borowicz.info
// This file is part of esoTalk. Please see the included license file for usage information.

if (!defined("IN_ESOTALK")) exit;

$form = $data["MenuLinks"];
?>
<?php echo $form->open(); ?>

<div class="section">

<ul class="form">

<li>
<label style="text-align: right;"><?php echo T('menu bottom'); ?></label>
<?php echo $form->input('linksBottomMenu', 'textarea', array('style' => 'height:150px; width:350px')); ?>
</li>

<li>
<label style="text-align: right;"><?php echo T('menu top'); ?></label>
<?php echo $form->input('linksTopMenu', 'textarea', array('style' => 'height:150px; width:350px')); ?>
</li>

<li>
<small>
<?php echo T('semicolon separated description and link per line'); ?>: 
borowicz website<b>;</b>borowicz.info 
<br /><?php echo T('will generate code'); ?>: 
>> &lt;a href=&quot;http://borowicz.info&quot; title=&quot;borowicz website&quot;&gt;borowicz website&lt;/a&gt;
</small>
</li>

<li>
<label style="text-align: right;"><?php echo T('before /body tag'); ?></label>
<?php echo $form->input('beforeBody', 'textarea', array('style' => 'height:100px; width:300px')); ?>
<small>
<?php echo T('include html before </body> e.g.:'); ?> <a href="http://piwik.org" target="_blank" >Piwik Stat</a>
</small>
</li>

<li>
<label style="text-align: right;"><?php echo T('head tag section'); ?></label>
<?php echo $form->input('headSection', 'textarea', array("style" => "height:100px; width:300px")); ?>
<small>
<?php echo T('include html in head section e.g.:'); ?> <a href="http://www.google.com/analytics/" target="_blank" >google Analytics</a>
</small>
</li>


</ul>

</div>

<div class="buttons">
<?php echo $form->saveButton("MenuLinksSave"); ?>
</div>

<?php echo $form->close(); ?>

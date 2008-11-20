<h1><?php echo __('Funky Cache Plugin'); ?></h1>
<?php error_reporting(E_ALL); ?>

<form action="<?php echo get_url('plugin/funky_cache/clear'); ?>" method="post">
<fieldset style="padding: 0.5em;">
    <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Cached pages'); ?></legend>
    <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
    <?php foreach ($cached_page as $page): ?>
        <tr>
            <td class="field"><?php print $page->url ?></td>
            <td class="field"><?php print $page->created_on ?></td>
            <td class="help"><?php echo __('here be the dragons') ?></td>
        </tr>	
    <?php endforeach; ?>
    </table>
</fieldset>
<p class="buttons">
    <input class="button" name="commit" type="submit" accesskey="c" value="<?php echo __('Clear all'); ?>" />
</p>
</form>

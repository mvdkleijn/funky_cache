<?php
/*
 * Funky Cache plugin for Wolf CMS. <http://www.wolfcms.org>
 *
 * Copyright (C) 2012 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (c) 2008-2009 Mika Tuupola
 *
 * This file is part of the Funky Cache plugin for Wolf CMS. It is licensed
 * under the MIT license.
 *
 * For details, see:  http://www.opensource.org/licenses/mit-license.php
 */
?>
<h1><?php echo __('Funky Cache'); ?></h1>

<form action="<?php echo get_url('plugin/funky_cache/clear'); ?>" method="post">
    <fieldset style="padding: 0.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('Cached pages'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <?php foreach ($pages as $page): ?>
                <tr>
                    <td class="field"><?php print $page->publicUrl() ?></td>
                    <td class="field"><?php print DateDifference::getString(new DateTime($page->created_on)); ?></td>
                    <td class="field"><a href="<?php echo get_url('plugin/funky_cache/delete/').$page->id; ?>"><img src="<?php echo PLUGINS_URI; ?>/funky_cache/images/delete.png" title="Delete this cached page." /></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </fieldset>
    <p class="buttons">
        <input class="button" name="commit" type="submit" accesskey="c" value="<?php echo __('Clear all'); ?>" />
    </p>
</form>

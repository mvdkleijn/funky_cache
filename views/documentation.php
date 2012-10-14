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
<h1><?php echo __('Funky Cache - Example rewrite rules');?></h1>

<h2><?php echo __('Introduction');?></h2>
<p>
    <?php echo __('The Funky Cache plugin works by using mod_rewrite or equivalent rewrite functionality. Below you will find generated examples for the most used HTTP servers.');?>
    <?php echo __('Please be aware the author of this plugin cannot guarantee the accuracy of these examples and does not know all rewrite systems.');?>
</p>
<p>
    <?php echo __('Always check the plugin settings after enabling it!');?>
</p>

<h2>Apache</h2>
<p>
    Caching relies on correctly set mod_rewrite rules. The section below is the set of mod_rewrite rules you should place in your
    .htaccess file. It was generated based on your settings.
</p>
<p>
    You should place these rules <strong>before</strong> the standard Wolf CMS rules and <strong>after</strong> the RewriteBase line.
</p>
<code><pre>
  # Check for cached index page from static cache folder.
  RewriteCond %{REQUEST_METHOD} ^GET$
  RewriteCond %{DOCUMENT_ROOT}<?php echo URI_PUBLIC; ?><?php echo trim(funky_cache_folder(), '/'); ?><?php echo URI_PUBLIC; ?>index<?php echo funky_cache_suffix(); ?> -s
  RewriteRule ^$ %{DOCUMENT_ROOT}<?php echo URI_PUBLIC; ?><?php echo trim(funky_cache_folder(), '/'); ?><?php echo URI_PUBLIC; ?>index<?php echo funky_cache_suffix(); ?> [L]

  # Check for other cached pages from static cache folder.
  RewriteCond %{REQUEST_METHOD} ^GET$
  RewriteCond %{DOCUMENT_ROOT}<?php echo URI_PUBLIC; ?><?php echo trim(funky_cache_folder(), '/'); ?>%{REQUEST_URI} -s
  RewriteRule (.*) %{DOCUMENT_ROOT}<?php echo URI_PUBLIC; ?><?php echo trim(funky_cache_folder(), '/'); ?>%{REQUEST_URI} [L]
</pre></code>

<h2>Nginx</h2>
<p>
    Caching relies on correctly set HttpRewriteModule rules. The section below is the set of HttpRewriteModule rules you should place in your
    config file. It was generated based on your settings.
</p>
<p>
    You should place these rules <strong>before</strong> the standard Wolf CMS rules.
</p>
<code><pre>
  # Check for cached index page from static cache folder.
  if (-f $document_root<?php echo URI_PUBLIC; ?><?php echo trim(funky_cache_folder(), '/'); ?><?php echo URI_PUBLIC; ?>index<?php echo funky_cache_suffix(); ?>) {
      rewrite ^/$ <?php echo URI_PUBLIC; ?><?php echo trim(funky_cache_folder(), '/'); ?><?php echo URI_PUBLIC; ?>index<?php echo funky_cache_suffix(); ?> last;
  }

  # Check for other cached pages from static cache folder.
  if (-f $document_root<?php echo URI_PUBLIC; ?><?php echo trim(funky_cache_folder(), '/'); ?>$request_uri) {
      rewrite (.*) <?php echo URI_PUBLIC; ?><?php echo trim(funky_cache_folder(), '/'); ?>$request_uri last;
  }
</pre></code>

<p>
    <?php echo __('If you have translated the rewrite rules to another platform, please let the maintainer of this plugin know.');?>
</p>

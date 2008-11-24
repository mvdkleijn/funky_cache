<h1>Funky Cache Plugin</h1>
<p>
Current documentation available at <a href="http://www.appelsiini.net/projects/funky_cache">plugin homepage</a>.
</p>
<p>
<h3>Rewrite Rules</h3>
<p>
Caching relies on correctly set mod_rewrite rules. Below is .htaccess file generated according to your settings.
</p>
<code><pre>
<?php if (trim(URL_SUFFIX)) { ?>

Options +FollowSymLinks
AddDefaultCharset UTF-8

DirectoryIndex index<?php print funky_cache_suffix() ?> index.php

&lt;IfModule mod_rewrite.c&gt;
    RewriteEngine On
    RewriteBase /

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-l
    # Administration URL rewriting.
    RewriteRule ^admin(.*)$ admin/index.php?$1 [L,QSA]

    # Rewrite index to check for static.
    RewriteCond  %{DOCUMENT_ROOT}/index<?php print funky_cache_suffix() ?> -f
    RewriteRule ^$ index.xhtml [L,QSA]

    RewriteCond %{DOCUMENT_ROOT}/%{REQUEST_URI} !-f
    RewriteCond %{DOCUMENT_ROOT}/%{REQUEST_URI} !-d
    RewriteCond %{DOCUMENT_ROOT}/%{REQUEST_URI} !-l
    # Main URL rewriting.
    RewriteRule ^(.*)$ index.php?$1 [L,QSA]
&lt;/IfModule&gt;
<?php } else { ?>
DirectorySlash Off

Options +FollowSymLinks
AddDefaultCharset UTF-8

DirectoryIndex index<?php print funky_cache_suffix() ?> index.php

&lt;IfModule mod_rewrite.c&gt;
    RewriteEngine On
    RewriteBase /
    
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-l
    # Administration URL rewriting.
    RewriteRule ^admin(.*)$ admin/index.php?$1 [L,QSA]

    # Rewrite index to check for static.
    RewriteCond  %{DOCUMENT_ROOT}/index<?php print funky_cache_suffix() ?> -f
    RewriteRule ^$ index<?php print funky_cache_suffix() ?> [L,QSA] 

    # Rewrite to check for cached page.
    RewriteCond %{REQUEST_FILENAME}<?php print funky_cache_suffix() ?> -f
    RewriteRule ^([^.]+)$ $1<?php print funky_cache_suffix() ?> [L,QSA]

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-l
    # Main URL rewriting.
    RewriteRule ^(.*)$ index.php?$1 [L,QSA]
&lt;/IfModule&gt;

<?php } ?>
</pre></code>

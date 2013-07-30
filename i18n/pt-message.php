<?php

    /**
     * Language file for plugin funky_cache
     *
     * @package Plugins
     * @subpackage funky_cache
     *
     * @author @frontenderch
     * @version Wolf 0.7.7
     */

    return array(
        // index.php
        'Cache' => 'Esconderijo',
        'Should cache' => 'Deve armazenar em cache',

        // views/index.php
        'Funky Cache' => 'Funky Cache',
        'Cached pages' => 'Páginas em cache',
        'Clear all' => 'Limpar',

        // views/documentation.php
        'Funky Cache - Example rewrite rules' => 'Funky Cache - Exemplo de regras de reescrita',
        'Introduction' => 'Introdução',
        'The Funky Cache plugin works by using mod_rewrite or equivalent rewrite functionality. Below you will find generated examples for the most used HTTP servers.' => 'O plugin Cache funky funciona usando mod_rewrite ou funcionalidade reescrita equivalente. Abaixo você encontrará exemplos gerados para os servidores HTTP mais usados??.',
        'Please be aware the author of this plugin cannot guarantee the accuracy of these examples and does not know all rewrite systems.' => 'Lembre-se de o autor deste plugin não pode garantir a precisão desses exemplos e não sabe todos os sistemas de reescrita.',
        'Always check the plugin settings after enabling it!' => 'Sempre verifique as configurações do plugin depois de ativar isso!',
        'If you have translated the rewrite rules to another platform, please let the maintainer of this plugin know.' => 'Se você traduziu as regras de reescrita para outra plataforma, por favor deixe o mantenedor deste plugin sei.',

        // views/settings.php
        'Funky Cache Plugin' => 'Plugin de Funky Cache',
        'Cache settings' => 'Configurações de cache',
        'Cache by default' => 'Cache, por padrão',
        'Yes' => 'Sim',
        'No' => 'Não',
        'Choose yes if you want your pages to be cached by default. Otherwise you must set caching for each page manually.' => 'Escolha Sim, se você quiser suas páginas para ser armazenada em cache por padrão. Caso contrário, você deve definir o cache para cada página manualmente.',
        'Cache file suffix' => 'Sufixo de arquivos de cache',
        'Suffix for cache files written to disk. If you use other than .html you also need to update your mod_rewrite rules.' => 'Sufixo para arquivos de cache gravados no disco. Se você usar o que não. Html você também precisa atualizar as regras do mod_rewrite.',
        'Cache folder' => 'Pasta de cache',
        'Folder where static cache files are written. Relative to document root. When you change this you also need to update your mod_rewrite rules.' => 'Pasta onde os arquivos de cache estáticas são escritas. Em relação a raiz do documento. Quando você mudar isso, você também precisa atualizar as regras do mod_rewrite.',
        'Save' => 'Salvar',

        // views/sidebar.php
        'Example rewrite rules' => 'Regras de reescrita exemplo',
        'Settings' => 'configurações',
        'About Funky Cache' => 'Sobre o Cache funky',
        'The Funky Cache plugin allows you to cache pages on the filesystem. It works by using mod_rewrite or equivalent rewrite functionality.' => 'O plugin Cache funky permite armazenar em cache páginas no sistema de arquivos. Ela funciona usando mod_rewrite ou funcionalidade reescrita equivalente.',
        'Homepage' => 'Página principal',

        // FunkyCacheController.php
        'Page was deleted from cache.' => 'Página foi excluída do cache.',
        'The cached page could not be deleted. Try manually from the commandline.' => 'A página em cache não pode ser excluído. Tente manualmente a partir da linha de comando.',
        'Cache cleared successfully.' => 'Cache apagada com sucesso.',
        'One or more cached pages could not be deleted. Try manually from the commandline.' => 'Uma ou mais páginas em cache não pode ser excluído. Tente manualmente a partir da linha de comando.',
        'The cache settings have been updated.' => 'As configurações de cache foram atualizados.',
        'The cache settings could not be updated due to an error.' => 'As configurações de cache não pôde ser atualizado devido a um erro. ',

    );

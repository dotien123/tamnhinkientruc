<?php

//get data
$tplShareGlobal = \Lib::tplShareGlobal('admin/');
$tplShareGlobal['site_title'] = "Quản trị";

//add to tpl
\View::share('def', $tplShareGlobal);
\View::share('menuLeft', \Menu::getMenu(0, true));
\View::share('menuTop', \Menu::getMenu(1));
\View::share('defLang', \Lib::getDefaultLang());
$config = \App\Models\ConfigSite::getConfig('config', '');
\View::share('config', !empty($config) ? json_decode($config, true) : null);

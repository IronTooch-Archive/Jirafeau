<?php
/*
 *  Jirafeau, your web file repository
 *  Copyright (C) 2020  Jérôme Jutteau <jerome@jutteau.fr>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
define('JIRAFEAU_ROOT', '/www/');
define('JIRAFEAU_CFG', JIRAFEAU_ROOT . 'lib/config.local.php');

require(JIRAFEAU_ROOT . 'lib/settings.php');
require(JIRAFEAU_ROOT . 'lib/functions.php');
require(JIRAFEAU_ROOT . 'lib/lang.php');

function env_2_cfg_string(&$cfg, $config_name, $default = null)
{
    $env_name = strtoupper($config_name);
    $r = getenv($env_name);
    if ($r === false) {
        if (is_null($default)) {
            return false;
        } else {
            $r = $default;
        }
    }
    echo("setting $config_name to '$r'\n");
    $cfg[$config_name] = $r;
    return true;
}

function env_2_cfg_bool(&$cfg, $config_name, $default = null)
{
    $env_name = strtoupper($config_name);
    $r = getenv($env_name);
    if ($r === false) {
        if (is_null($default)) {
            return false;
        } else {
            $r = $default;
        }
    } else {
        $r = ($r == "1") ? true : false;
    }
    echo("setting $config_name to " . ($r ? "true" : "false") . "\n");
    $cfg[$config_name] = $r;
    return true;
}

function env_2_cfg_int(&$cfg, $config_name, $default = null)
{
    $env_name = strtoupper($config_name);
    $r = getenv($env_name);
    if ($r === false) {
        if (is_null($default)) {
            return false;
        } else {
            $r = $default;
        }
    } else {
        $r = intval($r);
    }
    echo("setting $config_name to $r\n");
    $cfg[$config_name] = $r;
    return true;
}

function env_2_cfg_string_array(&$cfg, $config_name)
{
    $env_name = strtoupper($config_name);
    $r = getenv($env_name);
    if ($r === false) {
        return;
    }
    $r = explode(",", $r);
    $c = count($r);
    echo("setting $config_name array with $c value(s)n\n");
    $cfg[$config_name] = $r;
    return true;
}

function setup_admin_password(&$cfg)
{
    if (strlen($cfg['admin_password']) > 0) {
        return true;
    }
    echo("setting up admin password\n");
    $p = getenv('ADMIN_PASSWORD');
    if ($p === false) {
        $p = jirafeau_gen_random(20);
        echo("auto-generated admin password: $p\n");
    }
    $cfg['admin_password'] = hash('sha256', $p);
    return true;
}

function set_rights($path)
{
    $uid = getenv('USER_ID');
    if ($uid === false) {
        $uid = 100;
    }
    $gid = getenv('GROUP_ID');
    if ($gid === false) {
        $gid = 82;
    }
    if (!chown($path, $uid)) {
        echo("setting up user $uid for $path: failed\n");
        return false;
    }
    if (!chgrp($path, $gid)) {
        echo("setting up group $gid for $path: failed\n");
        return false;
    }
    if (!chmod($path, 0770)) {
        echo("setting up permissions $path: failed\n");
        return false;
    }
    return true;
}

function setup_var_folder(&$cfg)
{
    env_2_cfg_string($cfg, 'var_root', '/data/');
    $var_root = $cfg['var_root'];
    if (!is_dir($var_root)) {
        mkdir($var_root, 0770, true);
    }
    $err = jirafeau_check_var_dir($var_root);
    if ($err['has_error']) {
        echo("error: cannot create $var_root folder\n");
        return false;
    }
    return set_rights($var_root) &&
           set_rights($var_root . 'async') &&
           set_rights($var_root . 'files') &&
           set_rights($var_root . 'links');
}

function setup_webroot(&$cfg)
{
    if (!env_2_cfg_string($cfg, 'web_root')) {
        echo("warning: you may want to have set WEB_ROOT to your website URL (like 'jirafeau.mydomain.tld/')\n");
    }
}

function run_setup(&$cfg)
{
    $setup_ok = setup_admin_password($cfg) &&
                setup_var_folder($cfg);
    setup_webroot($cfg);
    env_2_cfg_string($cfg, 'file_hash');
    env_2_cfg_bool($cfg, 'preview');
    env_2_cfg_bool($cfg, 'title');
    env_2_cfg_string($cfg, 'organisation');
    env_2_cfg_string($cfg, 'contactperson');
    env_2_cfg_string($cfg, 'style');
    env_2_cfg_string($cfg, 'availability_default');
    env_2_cfg_bool($cfg, 'one_time_download');
    env_2_cfg_bool($cfg, 'enable_crypt');
    env_2_cfg_bool($cfg, 'debug');
    env_2_cfg_int($cfg, 'maximal_upload_size');
    env_2_cfg_string_array($cfg, 'upload_password');
    env_2_cfg_string_array($cfg, 'upload_ip');
    env_2_cfg_string_array($cfg, 'upload_ip_nopassword');
    env_2_cfg_string_array($cfg, 'proxy_ip');
    env_2_cfg_bool($cfg, 'store_uploader_ip');

    if ($setup_ok) {
        $cfg['installation_done'] = true;
        jirafeau_export_cfg($cfg);
        echo("You can now connect to your Jirafeau instance\n");
        exit(0);
    } else {
        echo("Some Jirafeau options failed");
        exit(1);
    }
}

run_setup($cfg);

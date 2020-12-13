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

function env_2_cfg_string($cfg, $config_name, $env_name)
{
    $r = getenv($env_name, true);
    if ($r === false) {
        return;
    }
    echo("setting up '" . $env_name . "' option\n");
    $cfg[$config_name] = $r;
    jirafeau_export_cfg($cfg);
}

// TODO: lots of other options to implement
env_2_cfg_string($cfg, 'file_hash', 'FILE_HASH');
echo("docker config done\n");

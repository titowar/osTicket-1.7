<?php
/*********************************************************************
    logs.php

    System Logs

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2012 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('admin.inc.php');

if($_POST){
    switch(strtolower($_POST['do'])){
        case 'mass_process':
            if(!$_POST['ids'] || !is_array($_POST['ids']) || !count($_POST['ids'])) {
                $errors['err'] = _('You must select at least one log to delete');
            } else {
                $count=count($_POST['ids']);
                if($_POST['a'] && !strcasecmp($_POST['a'], 'delete')) {

                    $sql='DELETE FROM '.SYSLOG_TABLE
                        .' WHERE log_id IN ('.implode(',', db_input($_POST['ids'])).')';
                    if(db_query($sql) && ($num=db_affected_rows())){
                        if($num==$count)
                            $msg=_('Selected logs deleted successfully');
                        else
                            $warn="$num "._("of")." $count "._("selected logs deleted");
                    } elseif(!$errors['err'])
                        $errors['err']=_('Unable to delete selected logs');
                } else {
                    $errors['err']=_('Unknown action - get technical help');
                }
            }
            break;
        default:
            $errors['err']=_('Unknown command/action');
            break;
    }
}

$page='syslogs.inc.php';
$nav->setTabActive('dashboard');
require(STAFFINC_DIR.'header.inc.php');
require(STAFFINC_DIR.$page);
include(STAFFINC_DIR.'footer.inc.php');
?>

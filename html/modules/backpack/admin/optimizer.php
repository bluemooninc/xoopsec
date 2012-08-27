<?php

    /** 
    MySQL Database Optimizer 1.0.0a: Optimizes all tables of a given 
                                     MySQL database.
    Copyright (C) 2000  Jeremy Brand 
                        email: jeremy@nirvani.net
                        web: http://www.nirvani.net/jeremy/

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

    ChangeLog:
      1.0.0 -> 1.0.0a (2000-12-31)
        - Added #!/usr/local/bin/php -q to denote that this program
          was intented to run as a standalone script as opposed to 
          being parsed and ran through a web server.

    **/

    /**
     **    THIS SCRIPT PERFORMS TABLE LOCKING AND SAFELY OPTIMIZE ALL TABLES 
     **    WITHIN THE GIVEN DATABASE.
     **/

    /**
     **    THIS IS TO BE RAN ON THE COMMAND LINE.
     **    THE FIRST ARGUMENT TO THE SCRIPT IS THE DATABASE NAME 
     **    OF WHICH YOU WANT TO OPTIMIZE.
     **
     **    EXAMPLE:
     **    shell> php -q this_script.php my_database_name
     **/

include '../../../include/cp_header.php';

xoops_cp_header();

    /**    CONFIG                                 CHANGE HERE            **/
    /***************************************      ***********            **/
    /** IP or hostname of MySQL server   **/      $db_host = XOOPS_DB_HOST; 
    /** MySQL user name                  **/      $db_user = XOOPS_DB_USER; 
    /** MySQL password                   **/      $db_pass = XOOPS_DB_PASS;  
    /** Program start delay in seconds   **/      $start_delay = 0;   

    /**    PROGRAM STARTS HERE    **/
    /*******************************/

    set_time_limit(0);

    function format_time($seconds)
    {
      $hour = $seconds / 3600;
      $total_time = $seconds - ($hour*3600);
      $min = $seconds / 60;
      $sec = $seconds % 60;
      $format = sprintf("%02d",$hour).":".sprintf("%02d",$min).":".sprintf("%02d",$sec);
      return $format;
    }

    mysql_connect($db_host, $db_user, $db_pass) or die(mysql_error() . "\n\n");
    mysql_select_db(XOOPS_DB_NAME) or die(mysql_error() . "\n\n");

	echo "<p><center><a href=\"index.php\">"._AM_RETURNTOSTART."</a></center>\n";
    print "<p>\n";
    print _AM_OPT_WARNING."<br />\n";
    print sprintf(_AM_OPT_STARTING, XOOPS_DB_NAME, $start_delay)."<br />\n";
    flush();
//    print "CTRL-C TO ABORT.\n\n"; flush();


    for ($i=0; $i<$start_delay; $i++)
    {
      print "."; flush();
      sleep(1);
    }
    print "<br />\n"; flush();

    $q = "SHOW TABLES";
    $r = mysql_query($q);

    $q = "LOCK TABLES";

    while($row = mysql_fetch_row($r))
    {
      $table[] = $row[0];
      $q .= " " . $row[0]." WRITE,";
    }
    $q = substr($q,0,strlen($q)-1);
    mysql_query($q);

    print "THE DATABASE '".XOOPS_DB_NAME."' IS LOCKED FOR READ/WRITE.<br />\n\n";

    $t1 = time();
    while(list($key, $val) = each($table))
    {
      $b1 = time();
      $q = "OPTIMIZE TABLE $val"; 
      print $q; flush();
      mysql_query($q) or die("QUERY: \"$q\" " . mysql_error() . "\n\n");
      $b2 = time();
      $table_time = $b2 - $b1; 
      print "\t\t(TIME ELAPSED: " . format_time($table_time). ")<br />\n"; flush();
    }
    $q = "UNLOCK TABLES";
    mysql_query($q);
    print "<br />";
    print "THE DATABASE '".XOOPS_DB_NAME."' IS NOW UNLOCKED.\n\n";
   
    $t2 = time();
    $total_time = $t2 - $t1;

    print "TOTAL TIME ELAPSED: " . format_time($total_time) . "\n\n"; flush();

xoops_cp_footer();

    exit();
?>

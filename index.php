<?php
	/**************************************************************************\
	* Simple Groupware 0.532                                                   *
	* http://www.simple-groupware.de                                           *
	* Copyright (C) 2002-2009 by Thomas Bley                                   *
	* ------------------------------------------------------------------------ *
	*  This program is free software; you can redistribute it and/or           *
	*  modify it under the terms of the GNU General Public License Version 2   *
	*  as published by the Free Software Foundation; only version 2            *
	*  of the License, no later version.                                       *
	*                                                                          *
	*  This program is distributed in the hope that it will be useful,         *
	*  but WITHOUT ANY WARRANTY; without even the implied warranty of          *
	*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the            *
	*  GNU General Public License for more details.                            *
	*                                                                          *
	*  You should have received a copy of the GNU General Public License       *
	*  Version 2 along with this program; if not, write to the Free Software   *
	*  Foundation, Inc., 59 Temple Place - Suite 330, Boston,                  *
	*  MA  02111-1307, USA.                                                    *
	\**************************************************************************/

$lang = "es";
if (!empty($_REQUEST["lang"])) $lang = $_REQUEST["lang"];
$url = "";
if (!empty($_REQUEST["url"])) $url = $_REQUEST["url"];

if ($url == "" and empty($_REQUEST["mode"])) {
  $url = "examples/features_en.js";
  if ($lang == "de") $url = "examples/features_de.js";
}
$init_data = "";
if (strpos("@".$url,"http://")==1 or strpos("@".$url,"https://")==1 or dirname($url)=="examples") {
  $init_data = @file_get_contents($url);
  if (!$init_data) $init_data = "\n\nCannot load ".$url;
}
//$init_data = @file_get_contents("datos.js");
//PARA QUE NO CARGUE UN ARCHIVO
$init_data = '';

header("Content-Type: text/html; charset=utf-8");

?>
<html>
<head>
  <title>Simple Spreadsheet</title>
  <link media="all" href="css/styles.css" rel="stylesheet" type="text/css" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style>
      .kiketable-colsizable{
          /*table-layout: fixed;*/ 
          //width : 100%;
          }
      .kiketable-colsizable td,
      .kiketable-colsizable th{
          overflow : hidden;
          }
      .kiketable-th{
          /* Don't set "position: relative" in IE */
          white-space: nowrap;   /* Only works for THs in IE */
          text-align: center;
          height: 20px;          /* value safe to change */
          }
      .kiketable-th-text{
          height: 100%;
          overflow: hidden;
          }
      .kiketable-colsizable-handler{
          float: right;
          cursor: e-resize;
          height: 100%;
          //border-left:2px outset white;
          border-right:2px inset white;
          }
      html > body .kiketable-colsizable-handler{
          //border-right:2px outset white;
          }
      .kiketable-colsizable-dragLine{
          position: absolute;
          width: 2px;
          cursor: e-resize;
          /*background-color: red;  /* value safe to change */
          }
      .kiketable-colsizable-dragArea{
          position: absolute;
          cursor: e-resize;
          /*background-color:red;   /* value safe to change */
          }
      .kiketable-colsizable-minimized{
          /*background-color: #ffd; /* value safe to change */
          color: #bbb;            /* value safe to change */
      }
	</style>
  <script src="translations/<?php echo $lang; ?>.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="js/jquery.event.drag-1.4.js"></script>
	<script type="text/javascript" src="js/jquery.kiketable.colsizable-1.1.js"></script>
  <script src="js/spreadsheet.js" type="text/javascript"></script>
</head>
<body onmouseover="showHeaderFooter(true);">
<!--
	Simple Spreadsheet is an open source Component created by Thomas Bley and licensed under GNU GPL v2.
	Simple Spreadsheet is copyright 2006-2008 by Thomas Bley.
	Translations implemented by Sophie Lee.
	More information and documentation at http://www.simple-groupware.de/
-->
<div class="data" id="data"></div>
<div id="source" align="center">
<script>
var out = "";
out += trans("Simple Spreadsheet code / CSV data / Tab separated values (copy/paste from Excel):");
document.write(out);
</script>
<br><textarea id="code" wrap="off"><?php
  echo htmlspecialchars($init_data,ENT_QUOTES);
?></textarea><br>
<script>
var out = "";
out += '<table class="default_table" id="nav_table_readonly" style="display:none; width:50%; text-align:center;">';
out += '<tr><td><input type="button" value="'+trans("Cancel")+'" onclick="cancelLoad();"></td></tr>';
out += '</table>';

out += '<table class="default_table" id="nav_table" style="width:50%;">';
out += '<tr><td colspan="2"><input type="button" value="'+trans("Load")+'" onclick="load(getObj(\'code\').value);" style="width:100%;"></td><td><input type="button" value="'+trans("Cancel")+'" onclick="cancelLoad();"></td></tr>';
out += '<tr><td>'+trans("Url")+'</td>';
out += '<td style="width:100%;"><input type="Text" id="code_url" value="" style="width:100%;"></td>';
out += '<td><input type="button" value="'+trans("Load")+'" onclick="document.location=\'spreadsheet.php?lang=en&url=\'+getObj(\'code_url\').value;"></td>';
out += '</tr></table>';

document.write(out);

<?php
/*
if (!empty($_REQUEST["mode"]) and $_REQUEST["mode"]=="viewer") {
  echo '
    isWriteable = false;
	getObj("code").readOnly = true;
	getObj("nav_table").style.display = "none";
	getObj("nav_table_readonly").style.display = "";
    getObj("code").value = top.getObj("'.$_REQUEST["data"].'").value;
    load(getObj("code").value);
	showHeaderFooter(false);
  ';
} else if (!empty($_REQUEST["mode"]) and $_REQUEST["mode"]=="editor") {
  echo '
    saveMethod = "";
    getObj("code").value = top.getObj("'.$_REQUEST["data"].'").value;
    load(getObj("code").value);
  ';
} else {*/
  echo 'load(getObj("code").value);';
//}

?>
</script>
</div>
</body>
</html>

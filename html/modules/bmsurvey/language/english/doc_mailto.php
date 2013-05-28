<?php
// $Id: doc_mailto.php,v 1.1.1.1 2005/08/10 12:14:04 yoshis Exp $
//  ------------------------------------------------------------------------ //
//                Bluemoon.Multi-Form                                      //
//                    Copyright (c) 2005 Yoshi.Sakai @ Bluemoon inc.         //
//                       <http://www.bluemooninc.biz/>                       //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
include '../../../../mainfile.php';

include '../../../../include/cp_functions.php';

	xoops_cp_header();
?>
<h1>How to use the mailto option. </h1>

You can describing mailto scheme while questioning. 

<h2>1:Describing in the section text.</h2> 
<li> Click "New field" by editing the form. 
<li> Input field name any. 
<li> Select a section text by type. 
<li> Do not set number of characters and require.
<li> Describe a mailto scheme in the text field. <br>
Example<br>
&lt;a href = "mailto:who@mail.com" &gt;Send Mail&lt;/a&gt;<br>
&lt;A HREF ="Mailto:who@mail.com?subject=title&body=notification"&gt;Send Mail&lt;/A&gt;<br>

<h2>2:Describing in the input item.</h2> 
<li> Click "New field" by editing the form. 
<li> Field name 'Mailsubject' as text box - for the subject line. 
<li> Field name 'Mailto' as text box - to send this address. 
<li> Field name 'Mailfrom' as text box - for from address. 
<li> Field name 'Mailcc' as text box - to send a carbon copy.
<li> Field name 'Mailname' as text box - for your name. This value is added at the end of body. 
<li> Field name 'Mailbody' as essay box - write your message here. 
<li> Field name 'Mailfromset' as yes/no choice.
<br>'yes' - The from address is input at 'Mailfrom'.
<br>'no'  - the from address is module preference or XOOPS admin.

<h2>3:Describing section text and input item.</h2>
It is also possible to use it mixing two though it explained the method of the section text and input items. 
In this case, the variable specified by the section text is previously substituted, and it is overwrited later in the value of the input item. 
<li> make a section text as send address and subject. 
<li> make a Mailbody field as input item. 

<h2>4:Setting of input default value</h2>
The answer result can be seen from the those who answer list box in "View Results from a Form", 
and it can be set to the input value of default that "Set default input this result" 
is clicked here from the form management tag of the module management. Moreover, release makes the form 
from "Edit an Existing Form" and choice General tab item Default Response delete response ID. 

<hr>
<h1>Application example</h1>
<h2>1:Registration to mailing list</h2>
It is possible to use it as the registration form to the mailing list. 
<p>
<LI> Set Email at 'General' of the edit form as the registration address of the mailing list. and choose 'In the questionnaire' as from option. 
<li> Field name 'Mailfrom' as text box - for from address. 
<li> Field name 'To_mailinglist' as yes/no choice.
<br>'yes' - Transmit to registration address without message.
<br>'no' - Nothing to transmit.
<?php
	xoops_cp_footer();
?>
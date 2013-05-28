<?php
// $Id: doc_popnupblog.php,v 1.1.1.1 2005/08/10 12:14:04 yoshis Exp $

include '../../../../mainfile.php';

include '../../../../include/cp_functions.php';

	xoops_cp_header();
?>

<h1>How to work with PopnupBlog(Redwood)</h1>

The answer of the questionnaire can be recorded in Blog by two methods. 

<h2>1: All answers are recorded in single Blog. </h2>
<li> At Popnupblog. Prepares the Blog and set post mail address as same as form prefrence. Takes note of Blog ID. 
<li> Go to Form Management, Set 'b'+'Blog ID'+',' to title at the general setting.
    Ex) b1,title strings
<li> Set Email as PopnupBlog recieve address.
<li> Set From Option to 'Form Address'.

<h2>2:Recorded to each users Blog. </h2>
<li> At Popnupblog. Prepared post mail address as same as account of Xoops. It takes notes of Blog ID of made Blog. 
<li> Go to Form Management, make a question text 'blogid' type as numeric at Questions. 
<li> Move to General, Set Email as PopnupBlog recieve address.
<li> Set From Option to 'Users Address'.
<h2>3:Notes</h2>
<li> Two diffrent mail addresses are needed for PopnupBlog and Multi-Form. 

<?php
	xoops_cp_footer();
?>

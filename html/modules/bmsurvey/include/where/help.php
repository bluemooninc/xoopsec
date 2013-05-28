<?php

# $Id: help.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// For eGrad2000.com
// <jflemer@alum.rpi.edu>

?>
<a name="top"></a>
<table bgcolor="#ffffff" border=2 width="98%"><tr><td>
<font size="+3">Form Help</font>
<ul>
	<li><a href="#new"><font size="+2">Creating a new form</font></a></li>
	<li><a href="#themes"><font size="+2">Creating and Assigning Form Themes</font></a></li>
	<li><a href="#test"><font size="+2">Testing a form</font></a></li>
	<li><a href="#types"><font size="+2">Response Types Examples</font></a></li>
	<li><a href="#edit"><font size="+2">Editing a form</font></a></li>
	<li><a href="#status"><font size="+2">Putting a form into production use</font></a></li>
</ul>
<font size="+3">Administration Help</font>
<ul>
	<li><a href="#upload"><font size="+2">Uploading Bulk Account and Group information</font></a></li>
	<li><a href="#analysis"><font size="+2">Cross Analysis</font></a></li>
	<li><a href="#tabulation"><font size="+2">Cross Tabulation</font></a></li>
</ul>

<hr>

<ul>
<li><h3><a name="new">Creating a new form</a></h3>
	<ol>
	<li><p>Click <b>New Form Design</b> from the Management
		Interface.</p></li>
	<li><b>General Tab:</b>
		<p>Enter a name for the form in the <b>name</b>
		field. Do not use spaces in this name, think of
		this as a filename.</p>

		<p>Choose a <b>group</b> to own this form.</p>

		<p>Fill out the <b>title</b>, <b>subtitle</b>, and
		<b>info</b> fields. These fields will be used in
		the creation of a header for the final form.</p>

		<p>If you would like to be emailed a copy of each
		submitted form, enter a valid email address in
		the <b>email</b> field. (This is intended for
		<b>backup</b>, not as the primary data collection,
		you should probably leave it blank.)</p>

		<p>If you would like to theme your form select the
		appropriate theme from the dropdown list. This will
		establish a link to a specific css style sheet for
		your form. To design a theme please refer to the section:
		<b>Creating and Assigning Form Themes</b>.</p>

		<p>The <b>Confirmation Page</b> is the page users
		will be shown after filling out the form online.
		Fill in the <b>heading</b> and <b>body text</b> for
		the this page, or leave them blank to use the
		default.</p>

		<p>Click continue, or click the <b>Questions</b>
		tab at the top to proceed to the questions
		section.</p>
	</li>
	<li><b>Questions Tab:</b>
		<p>Enter the text of your question (i.e. <em>What
		is your favorite color?</em>) in the
		<b>question</b> box. Optionally enter a <b>field
		name</b> for this question, if you leave it blank
		one will be generated for you.</p>

		<p>If you would like to require the user to respond
		to this question, select <b>yes</b> in the
		<b>required</b> field.</p>

		<p>Choose the <b>type of response</b> for this
		question. [Click here to see <a
		href="#types">Examples</a>.] Different types may
		have parameters to change how they behave, consult
		the chart below for the use of the <b>length</b>
		and <b>precision</b> fields.</p>

		<table border="0">
		  <tr><th align="left">Type</th><th align="left">Length</th><th align="left">Precision</th></tr>
		  <tr><td colspan="3"><hr size="0" noshadow="true"></td></tr>
		  <tr><td>Yes/No</td><td>n/a</td><td>n/a</td></tr>
		  <tr><td>Text</td><td>length</td><td>max length</td></tr>
		  <tr><td>Essay</td><td>columns</td><td>rows</td></tr>
		  <tr><td>Radio</td><td>n/a</td><td>n/a</td></tr>
		  <tr><td>Checkboxes</td><td>min #</td><td>max # <em>(not implemented yet)</em></td></tr>
		  <tr><td>Dropdown</td><td>n/a</td><td>n/a</td></tr>
		  <tr><td>Rate</td><td>1..N</td><td>Use "N/A"</td></tr>
		  <tr><td>Date</td><td>n/a</td><td>n/a</td></tr>
		  <tr><td>Numeric</td><td>length</td><td>precision</td></tr>
		</table>

<!-- deprecated
		<p>Choose the format for the results to be
		displayed in a report from the <b>result type</b>
		field. [Click here to see <a
		href="#results">Examples</a>.] Note: Both single
		line text and essay question types are forced to a
		<b>list</b> answer type; list is invalid for all
		other question types. A rating is forced to a
		average rank result. The default result type is
		percentages.</p>
-->

		<p>If you chose a response type that has answer
		options, fill in one answer per line on the bottom
		half of the form. If you need more lines, click
		<b>Add another answer line</b>. [Question types
		with answer options are: Check Boxes, Dropdown Box,
		Radio Buttons, Rate.] For check boxes and radio
		buttons, you may enter <tt>&quot;!other&quot;</tt>
		on a line to create a fill in the blank option. An
		&quot;Other&quot; box defaults to using the prompt
		<em>Other: </em>, but is configurable by using the
		format:
		<br><center><tt>!other=prompt text</tt></center></p>

		<p>Add more questions by clicking the <b>New
		Question</b> button. Edit/View existing questions
		by clicking the question numbers at the top of the
		form.<p>

		<p>Click continue, or click the <b>Questions</b>
		tab at the top to proceed to the questions
		section.</p>
	</li>
	<li><b>Order Tab:</b>
		<p>On this tab, you can change the order of the
		questions, delete questions, and insert
		<b>section</b> breaks. A section break, divides
		your form into multiple pages (good for long
		forms).</p>
	</li>
	<li><b>Preview Tab:</b>
		<p>Shows a preview of your form. You can switch
		to this tab at any time to see what your form
		will look like. If you would like to make changes,
		go back to the appropriate tab and make the
		changes. If you are satisfied with the form,
		click the <b>Finish</b> tab or button at the bottom
		of the page.</p>

		<p>The <b>Next Page</b> and <b>Submit Form</b>
		buttons are inactive in the preview mode.</p>
	</li>
	<li><b>Finish Tab:</b>
		<p>Shows you the block of PHP code that you need to
		paste into the HTML of your webpage to embed the
		form.</p>
		<p>Once a form is finished, you may return to
		editing it by choosing <b>Edit an Existing
		Form</b> from the Management Interface. When all
		final edits are done, you need to change the form
		status from <b>new</b> to <b>test</b> or
		<b>active</b> mode. You can change the status by
		choosing <b>Change the Status of an Existing
		Form</b> from the Management Interface.</li>
	</ol>

	<p><a href="#top">Back to Top</a></p>
</li>
<li><h3><a name="themes">Creating and Assigning Form Themes</h3></a>
	<p>All themes (css style sheets) are contained within the css
	directory which is, by default, located in the public directory
	of this package (and its path is definable in the phpESP.ini.php file).
	Please ensure that all your css files are
	contained within this directory. In this directory you will find
	the <b>template.css</b>. To create a new theme simply copy the
	the template.css file and edit the class definitions.<b> Do not
	alter the class names</b>. Greater style flexibility is assured
	by not redefining html tags but rather by assigning classes to
	these tags. <a href="../examples/classes.html" target="themes">Click here</a> to see what these classes actually define.
	Once you've saved your new theme it will become available for
	selection from the dropdown list that is found on the <b>general
	tab</b> page.
</li>
<li><h3><a name="test">Test Mode</h3></a>
	<p>After you have created a form you can put it into
	testing mode. This allows you to access a live copy of
	it from the Management Interface. You can fill out the
	form, and view the results by choosing <b>Test a
	Form</b>. In order to test a form it must be set to
	<b>test</b> mode from the <b>Status</b> section.</p>

	<p>NOTE: Once a form is moved from <b>new</b>
	designation to <b>test</b> you can no longer make
	changes. If you just want to see how it will look, not
	test functionality, please use the <b>preview</b>
	option available in when <b>editing</b> or
	<b>creating</b> a form.</p>

	<p><a href="#top">Back to Top</a></p>
</li>
<li><h3><a name="types">Response Types</h3></a>
	<ul>

	<li>Yes/No<br>
		<input type="radio" name="bool">Yes<br>
		<input type="radio" name="bool">No
	</li>
	<li>Single Line Text Entry<br>
		<input type="text" size=30>
	</li>
	<li>Essay<br>
		<textarea cols="40" rows="4"></textarea>
	</li>
	<li>Radio Buttons<br>
		<input type="radio" name="radio">Option 1<br>
		<input type="radio" name="radio">Option 2<br>
	</li>
	<li>Check Boxes<br>
		<input type="checkbox">Option 1<br>
		<input type="checkbox">Option 2<br>
	</li>
	<li>Dropdown Box<br>
		<select>
			<option></option>
			<option>Option 1</option>
			<option>Option 2</option>
		</select>
	</li>
<!-- depreciated
	<li>Rating<br>
		<table border=0 cellspacing=0 cellpadding=0>
		<tr>
			<td width=60><input type="radio" name="rank">1</td>
			<td width=60><input type="radio" name="rank">2</td>
			<td width=60><input type="radio" name="rank">3</td>
			<td width=60><input type="radio" name="rank">4</td>
			<td width=60><input type="radio" name="rank">5</td>
			<td width=60><input type="radio" name="rank">N/A</td>
		</tr>
		</table>
	</li>
-->
	<li>Rate (scale 1..N)
	<blockquote>
		<table border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td></td>
				<td width="40" align="center" bgcolor="#eeeeee">1</td>
				<td width="40" align="center" bgcolor="#dddddd">2</td>
				<td width="40" align="center" bgcolor="#eeeeee">3</td>
				<td width="40" align="center" bgcolor="#dddddd">4</td>
				<td width="40" align="center" bgcolor="#eeeeee">5</td>
				<td width="40" align="center" bgcolor="#dddddd">N/A</td>
			</tr>
			<tr>
				<td>Option 1</td>
				<td width="40" align="center" bgcolor="#eeeeee"><input type="radio" name="118_124" value="1"></td>
				<td width="40" align="center" bgcolor="#dddddd"><input type="radio" name="118_124" value="2"></td>
				<td width="40" align="center" bgcolor="#eeeeee"><input type="radio" name="118_124" value="3"></td>
				<td width="40" align="center" bgcolor="#dddddd"><input type="radio" name="118_124" value="4"></td>
				<td width="40" align="center" bgcolor="#eeeeee"><input type="radio" name="118_124" value="5"></td>
				<td width="40" align="center" bgcolor="#dddddd"><input type="radio" name="118_124" value="N/A"></td>
			</tr>
			<tr>
				<td>Option 2</td>
				<td width="40" align="center" bgcolor="#eeeeee"><input type="radio" name="118_125" value="1"></td>
				<td width="40" align="center" bgcolor="#dddddd"><input type="radio" name="118_125" value="2"></td>
				<td width="40" align="center" bgcolor="#eeeeee"><input type="radio" name="118_125" value="3"></td>
				<td width="40" align="center" bgcolor="#dddddd"><input type="radio" name="118_125" value="4"></td>
				<td width="40" align="center" bgcolor="#eeeeee"><input type="radio" name="118_125" value="5"></td>
				<td width="40" align="center" bgcolor="#dddddd"><input type="radio" name="118_125" value="N/A"></td>
			</tr>
			<tr>
				<td>Option 3</td>
				<td width="40" align="center" bgcolor="#eeeeee"><input type="radio" name="118_126" value="1"></td>
				<td width="40" align="center" bgcolor="#dddddd"><input type="radio" name="118_126" value="2"></td>
				<td width="40" align="center" bgcolor="#eeeeee"><input type="radio" name="118_126" value="3"></td>
				<td width="40" align="center" bgcolor="#dddddd"><input type="radio" name="118_126" value="4"></td>
				<td width="40" align="center" bgcolor="#eeeeee"><input type="radio" name="118_126" value="5"></td>
				<td width="40" align="center" bgcolor="#dddddd"><input type="radio" name="118_126" value="N/A"></td>
			</tr>
		</table>
	</blockquote>
	</li>
	<li>Date<br>
	<input type="text" name="date" size="10"> <em>(e.g. 2004/7/19)</em>
	</li>
	<li>Numeric<br>
	<input type="text" name="numeric" size="10">
	</li>
	</ul>
	<p><a href="#top">Back to Top</a></p>
</li>
<li><h3><a name="edit">Editing a form</h3></a>
	<p>Editing a form uses the same interface as creating
	a new form, refer to the help for creating a new
	form for more details.</p>

	<p><a href="#top">Back to Top</a></p>
</li>
<li><h3><a name="status">Putting a form into production use</h3></a>

	<p>Once you have created/edited a form, and are ready
	to make it available online you must activate it. Go to
	the Management Interface, click <b>Change the Status of
	an Existing Form</b>. Find the form you want to
	activate. Make note of the form ID (the left most
	column).</p>

	<p>NOTE: At this point you must <b>activate</b> the
	form. This is a one way operation. After it has been
	activated, you can no longer edit or test this form.
	All results gathered in testing mode (if any) will be
	cleared by activating it.</p>

	<p>Click on the <b>Activate</b> link for your form.
	At this point your form is active. To insert the
	form into an existing page you must place a PHP tag
	in the HTML for the page. Copy the text below and paste
	it into the HTML of the page. (It is suggested that you
	put this in the cell of a table.) Change the text
	<tt><em>SID</em></tt> to the form ID of your form
	(found on the status page).</p>
	<tt>&lt;?php $sid=<em>SID</em>; include('<?php echo($GLOBALS['FMXCONFIG']['handler']); ?>'); ?&gt;</tt>

	<p>NOTE: This code was also given to you on the
	<b>Finish</b> tab of the form design.</p>

	<p>If you would like to insert the (real-time) results
	of a form into a web page, use the following PHP
	code.</p>
	<tt>&lt;?php $sid=<em>SID</em>; $results=1; include('<?php echo($GLOBALS['FMXCONFIG']['handler']); ?>'); ?&gt;</tt>

	<p><a href="#top">Back to Top</a></p>
</li>
</ul>

<hr>
<ul>
<li><h3><a name="upload">Uploading Account and Group information</h3></a>
	<ul>
	<li><p>On either the Respondent or Designer Managment Interfaces,
		click <b>Bulk Upload</b>. You will be presented with a form asking
		for <b>File Type</b> and <b>File to Upload</b>.  From the <b>File Type</b>
		dropdown, select the file type you wish to upload.  From the
		<b>File to Upload</b> browse your local filesystem to find the specific
		file you are uploading.</p>
	</li>
	<li><b>Tab Delimited, Data File Format:</b>
		<p>The tab delimited file should contain rows of text, terminated by a newline
		character(\n), with each field in the rows delimited by the tab character(\t).
		Each of the examples below should be a single row.</p>
		<ul>
		<li><b>Respondent Format:</b>
		<p>uid, Password and Group are required fields</p>
			<b>Field Order:</b>
			<p><tt>uid\tpassword\tgroup\tfname\tlname\temail\texpiration\tdisabled\n</tt></p>
			<b>Example Row:</b>
			<p><tt>looser\tsecret\teditors\tJohn\tSmith\tsmith@yahoo.com\t20011122\tN\n</tt></p>

		</li>
		<li><b>Designer Format:</b><p\>
		<p>uid, Password and Group are required fields</p>
			<b>Field Order:</b>
			<p><tt>uid\tpassword\tgroup\tfname\tlname\temail\t
design\tstatus\texport\tgroupedit\tgroupadmin\tgrouprespondents\texpiration\tdisabled</tt></p>
			<b>Example Row:</b>
			<p><tt>looser\tsecret\teditors\tJohn\tSmith\tsmith@yahoo.com\tY\tN\tY\tN\Y\tN\t20031122\tY\n</tt></p>

		</ul>
	<li><b>CSV, Data File Format:</b><p>Not Yet Implemented</p></li>
	<li><b>XML, Data File Format:</b><p>Not Yet Implemented</p></li>
	</li>
	</ul>
	<p><a href="#top">Back to Top</a></p>

</li>

<li><h3><a name="analysis">Cross Analysis</h3></a>
	To cross analyse results from a form choose a question by
	selecting the appropriate radio button to the left of the question. You must
	then choose one or more of the question's choices by selecting the appropriate
	checkbox under the chosen question. This will display the entire results of
	this form based on the criteria you have chosen. At present, Cross Analysis
	is limited to single questions.
	<p><img src="<?php echo($FMXCONFIG['image_url']);?>cross_analysis.jpg" width="700" height="262"><br>
	<br>
	This will produce the following result:<br>
	<br>
	<img src="<?php echo($FMXCONFIG['image_url']);?>cross_analysis_result.jpg" width="700" height="284"><br>
	<br>
	The resulting display shows all the responses where question 1 choice was
	&quot;Yes&quot;.
<p><a href="#top">Back to Top</a></p>
</li>
<li><h3><a name="tabulation">Cross Tabulation</h3></a>
	Cross tabulation returns a result set based on a two question
	selection. This is achieved by choosing which question's options will form
	the rows or columns for the cross tabulated result set. Selecting a radio
	button in the red box to the right of the question indicates the row selection
	and selecting a radio button in the blue box to the right of the question
	indicates the column selection.</p>
	<p><img src="<?php echo($FMXCONFIG['image_url']);?>cross_tabulate.jpg" width="700" height="273"></p>
	<p>In the above example we have chosen to cross tabulate question1 and question
	4 where question 1 is the row selection and question 4 is the column selection.
	This returns the following result set:<br>
	<br>
	<img src="<?php echo($FMXCONFIG['image_url']);?>cross_tabulate_result1.jpg" width="700" height="187"><br>
	Alternatively we can cross tabulate the same 2 questions but set question
	4 as the row selection and question 1 as the column selection as shown below:<br>
	<br>
	<img src="<?php echo($FMXCONFIG['image_url']);?>cross_tabulate2.jpg" width="700" height="271"><br>
	<br>
	This produces the following result set:<br>
	<br>
	<img src="<?php echo($FMXCONFIG['image_url']);?>cross_tabulate_result2.jpg" width="700" height="274"> </p>
<p><a href="#top">Back to Top</a></p>
</li>
</ul>

</td>
</tr>
</table>

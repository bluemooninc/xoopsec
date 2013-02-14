<?php
// comment callback functions

function bmcart_com_update($msgid, $total_num){
    return true;
}

function bmcart_com_approve(&$comment){
	return true;
}

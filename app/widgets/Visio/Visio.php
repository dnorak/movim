<?php

/**
 * @package Widgets
 *
 * @file Visio.php
 * This file is part of Movim.
 * 
 * @brief A jabber chat widget.
 *
 * @author Timothée Jaussoin
 * 
 * See COPYING for licensing information.
 */
 
//require_once(APP_PATH . "widgets/ChatExt/ChatExt.php");

class Visio extends WidgetBase
{
	function WidgetLoad()
	{
    	$this->addcss('visio.css');
    	$this->addjs('visio.js');
    	$this->addjs('adapter.js');
    	$this->addjs('webrtc.js');

        if(isset($_GET['f'])) {
            list($jid, $ressource) = explode('/', htmlentities($_GET['f']));
            
            $cd = new modl\ContactDAO();
            $contact = $cd->get($jid);

            if(!$contact)
                $contact = new modl\Contact();

            $this->view->assign('avatar',$contact->getPhoto('l'));
            $this->view->assign('name'  ,$contact->getTrueName());
            $this->view->assign('jid'   ,$jid);
            $this->view->assign('ressource'   ,$ressource);
        } 
    }
}

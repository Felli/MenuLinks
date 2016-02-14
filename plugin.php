<?php
// Copyright 2014 borowicz.info'

if(!defined('IN_ESOTALK')) exit;

ET::$pluginInfo['MenuLinks'] = array(
	'name' => 'MenuLinks',
	'description' => 'Configure a header and/or footer menu',
	'version' => '0.3',
	'author' => 'Tristan van Bokkem (original code by borowicz.info)',
	'authorEmail' => 'tristanvanbokkem@gmail.com',
	'authorURL' => 'http://www.esotalk.org',
	'license' => 'GPLv2'
);


class ETPlugin_MenuLinks extends ETPlugin {
	
	var $c			= array(); //config
	var $out		= array();

	public function handler_init($sender) 
	{
		$this->conf();
		if ( !empty($this->c['linksBottomMenu']) )	$this->generateMenu($sender, $this->c['linksBottomMenu'], 'meta');
		if ( !empty($this->c['linksTopMenu']) )		$this->generateMenu($sender, $this->c['linksTopMenu'], 'main');
		if ( !empty($this->c['headSection']) )		$sender->addToHead($this->c['headSection']);
		
	}

	public function generateMenu($sender, $data, $menu) 
	{
		if ( !empty($data) )
		{
			$items = array();
			$items = explode("\n",$data);
			if ( count($items) )
			{
				foreach ($items as $item)
				{
					$currentItem = '';
					if ( stristr($item,';') )
					{
						$currentItem = explode(';',$item);
						$currentItem[0] = trim($currentItem[0]);
						$currentItem[1] = trim($currentItem[1]);
						if ( isset($currentItem[0]) && isset($currentItem[1]) )
						{
							if ( !stristr($currentItem[1],'http://') )
							{
								$currentItem[1] = 'http://'.$currentItem[1];
							}
							$sender->addToMenu($menu, $currentItem[1], '<a href="'.$currentItem[1].'">'.$currentItem[0].'</a>', 'top');
						}
					}
				}
			}
		}
	}
	
	public function conf()
	{
		$this->c = array();
		$this->c['linksBottomMenu'] = C('plugin.MenuLinks.linksBottomMenu');
		$this->c['linksTopMenu'] 	= C('plugin.MenuLinks.linksTopMenu');
		$this->c['beforeBody'] 		= C('plugin.MenuLinks.beforeBody');
		$this->c['headSection'] 	= C('plugin.MenuLinks.headSection');
	}

	public function handler_pageEnd($sender) 
	{
		if ( !empty($this->c['beforeBody']) ) echo "\r\n".$this->c['beforeBody'];
	}

	
	/**
	 * Setting form on admin panel
	 */ 
	public function settings($sender)
	{
		$form = ETFactory::make('form');
		$form->action = URL('admin/plugins');
		
		$form->setValue('linksBottomMenu', 	$this->c['linksBottomMenu']);
		$form->setValue('linksTopMenu', 	$this->c['linksTopMenu']);
		$form->setValue('beforeBody', 		$this->c['beforeBody']);
		$form->setValue('headSection', 		$this->c['headSection']);
		
		if ($form->validPostBack("MenuLinksSave")) 
		{
			$config = array();
			$config['plugin.MenuLinks.linksBottomMenu'] = $form->getValue('linksBottomMenu');
			$config['plugin.MenuLinks.linksTopMenu'] 	  = $form->getValue('linksTopMenu');
			$config['plugin.MenuLinks.beforeBody'] 	  = $form->getValue('beforeBody');
			$config['plugin.MenuLinks.headSection'] 	  = $form->getValue('headSection');
			
			if (!$form->errorCount()) // if no errors save config.
			{
				ET::writeConfig($config);
				$sender->message(T("message.changesSaved"), "success autoDismiss");
				$sender->redirect(URL("admin/plugins"));
			}
		}
		
		$sender->data("MenuLinks", $form);
		return $this->view("settings");
	}

}

?>

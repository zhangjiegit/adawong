<?php
return	array(
	array(
		'(<controller>)-(<category>)-(<page>)-(<keyword>).html',
		array(
			'controller'=>'welcome',
			'category'=>'[\d]+',
			'page'=>'[\d]+',
			'keyword'=>'(.+)?'
		)
		,
		array(
			'action'=>'index'
		)
	)
);
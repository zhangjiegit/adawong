<?php
return	array(
	array(
		'(<controller>)-(<category>)-(<page>)-(<keyword>).html', //新闻列表页面
		array(
			'controller'=>'welcome', //控制器
			'category'=>'[\d]+', //新闻类别id
			'page'=>'[\d]+', //页码
			'keyword'=>'(.+)?' //搜索关键字
		)
		,
		array(
			'action'=>'index'
		)
	)
);
<?php
return	array(
	array( //新闻列表页面
		'(<controller>)-(<category>)-(<page>)-(<keyword>).html',
		array(
			'controller'=>'welcome', //控制器
			'category'=>'[\d]+', //新闻类别id
			'page'=>'[\d]+', //页码
			'keyword'=>'(.+)?' //搜索关键字
		)
		,
		array(
			'controller'=>'welcome',
			'action'=>'index'
		)
	),
	array( //首页,默认路由
		'(<controller>)-(<action>).html',NULL,
		array(
			'controller'=>'welcome',
			'action'=>'say',
		),
	)
);
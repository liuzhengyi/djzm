
DROP TABLE IF EXISTS `Articles`;	-- 文章
CREATE TABLE `Articles` (
	article_id SERIAL PRIMARY KEY,
	article_name VARCHAR(90) NOT NULL,		-- 文章名称，30个汉字以内
	content TEXT NOT NULL,				-- 文章内容，此数据类型需要查看，两千汉字以内
	source VARCHAR(90) default '网络' NOT NULL,	-- 文章来源，30个汉字以内
	author VARCHAR(45) default '匿名' NOT NULL,	-- 文章作者，15个汉字以内，多个作者以空格隔开
	picture VARCHAR(255),				-- 文章配图，图片路径
	is_artist BOOLEAN DEFAULT 0 NOT NULL,		-- 是否为名家推荐类的文章 默认为否(即艺术视角类文章)
	added_by BIGINT UNSIGNED NOT NULL,		-- 录入此文章的管理员ID，有外键约束 Masters(master_id)
	pub_date DATE NOT NULL,				-- 录入时间
	no_comment BOOLEAN DEFAULT 1 NOT NULL,		-- 是否不允许评论,默认不允许，评论功能尚未开放
	is_hidden BOOLEAN DEFAULT 0 NOT NULL,		-- 是否隐藏，默认为否
	FOREIGN KEY (added_by) REFERENCES Masters(master_id)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET = UTF8;

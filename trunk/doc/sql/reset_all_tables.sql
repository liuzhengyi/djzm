
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

DROP TABLE IF EXISTS `ArtworkTypes`;
CREATE TABLE `ArtworkTypes` (			-- 古董类别，管理员可以删减
	artwork_type_id SERIAL PRIMARY KEY,
	type_name_en VARCHAR(30) NOT NULL,	-- artwork_type in Table Artworks 中的外键约束，30个字符以内，建议用拼音或英文表示
	type_name_zh VARCHAR(30) NOT NULL,	-- 类别的中文名，用于页面显示，10个汉字以内
	added_by BIGINT UNSIGNED NOT NULL,	-- 添加该类别的管理员id，有外键约束 Masters(master_id)
	addition VARCHAR(90),			-- 类别的附加说明，30个汉字以内
	FOREIGN KEY (added_by) REFERENCES Masters(master_id)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=UTF8;
DROP TABLE IF EXISTS `Artworks`;	-- 艺术品
CREATE TABLE `Artworks` (
	artwork_id SERIAL PRIMARY KEY,
--	artwork_no BIGINT UNSIGNED NOT NULL,	-- 艺术品编号，具体编号规则待商议
	artwork_name VARCHAR(120) NOT NULL,	-- 艺术品名称，40个汉字以内 不可以重名
	artwork_type VARCHAR(30) NOT NULL ,	-- 艺术品类别，有外键约束 ArtworkTypes(type_name_en)
	artwork_size varchar(50),		-- 艺术品尺寸，50个字符以内
	img_small VARCHAR(255),			-- 艺术品微缩图在文件系统上的位置，150字符以内
	img_middle VARCHAR(255),		-- 艺术品中等大小图的位置，150字符以内
	img_large VARCHAR(255),			-- 艺术品大图位置，150字符以内
	author VARCHAR(90),			-- 艺术品作者，30个汉字以内
	period varchar(90),			-- 艺术品时期，30个汉字以内
	intro VARCHAR(90),			-- 艺术品简介，30个汉字以内
	detail VARCHAR(600),			-- 艺术品详细介绍，200个汉字以内
	price INT UNSIGNED,			-- 艺术品标价，无符号整型，16777215以内，单位为元
	amount TINYINT UNSIGNED,		-- 艺术品数量，255以内
	added_by BIGINT UNSIGNED NOT NULL ,	-- 添加此艺术品的管理员ID，有外键约束 Masters(master_id)
	on_sale BOOLEAN DEFAULT 1,		-- 是否出售，默认出售
	no_comment BOOLEAN DEFAULT 0,		-- 是否不允许留言，默认允许
	is_hidden BOOLEAN DEFAULT 0,		-- 是否隐藏，默认不隐藏
--	UNIQUE(artwork_no),
	UNIQUE(artwork_name),
	FOREIGN KEY (added_by) REFERENCES Masters(master_id),
	FOREIGN KEY (artwork_type) REFERENCES ArtworkTypes(type_name_en)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET = UTF8;

drop table if exists `Links`;	-- 友链
create table `Links` (
	link_id serial primary key,
	link_name varchar(60) not null,		-- 友链名称，20个汉字以内，不可不填
	link_address varchar(255) not null,	-- 友链地址，60个字符以内，不可不填
	add_date datetime not null		-- 添加时间
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET = UTF8;
DROP TABLE IF EXISTS `Masters`;		-- 管理员
CREATE TABLE `Masters` (
	master_id SERIAL PRIMARY KEY,
	master_name VARCHAR(30) NOT NULL,
	master_password CHAR(40) NOT NULL,
	master_email CHAR(255) NOT NULL,
	master_reg_time DATETIME NOT NULL,
	is_primary BOOLEAN NOT NULL,	-- 是否为主管理员，用于控制管理员权限
	-- 主管理员拥有所有权限，非主管理员拥有除任免管理员之外的权限
	/*
	pri_master boolean not null,	-- 是否有任命管理员的权限
	pri_article boolean not null,	-- 是否有增减文章的权限
	pri_artwork boolean not null,	-- 是否有增减古董的权限
	pri_message boolean not null,	-- 是否有删除留言的权限
	*/
	UNIQUE (master_name),
	UNIQUE (master_email)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET = UTF8;

DROP TABLE IF EXISTS `Messages`;	-- 留言
/*	每条留言设定一个son_id，指示它的回复。
 *	对于回复而言，son_id为-1
 *	对于未被回复的留言，son_id 为 0
 */
CREATE TABLE `Messages` (
	message_id SERIAL PRIMARY KEY,
	message_head VARCHAR(60),		-- 留言标题，20个汉字以内，可不填
	content VARCHAR(300) NOT NULL,		-- 留言内容，一百汉字以内
	pub_time DATETIME NOT NULL,		-- 留言发布时间
	pub_name VARCHAR(30) NOT NULL,		-- 留言者名号，10个汉字以内，必填
	pub_email_or_tel VARCHAR(255) NOT NULL,	-- 留言者联系方式，邮箱或电话号码，必填
	son_id BIGINT UNSIGNED DEFAULT 0,	-- 留言的回复的id。为0代表该留言没有回复
	parent_id BIGINT UNSIGNED DEFAULT NULL,	-- 所回复的留言id。只有管理员有权回复。为NULL代表改留言不是一条回复
	is_checked BOOLEAN DEFAULT 0,		-- 是否审核通过，默认为否
	checked_by BIGINT UNSIGNED DEFAULT NULL	-- 最后一次审核者id
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET = UTF8;

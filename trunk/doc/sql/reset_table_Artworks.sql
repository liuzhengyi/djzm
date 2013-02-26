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
	on_sale BOOLEAN DEFAULT 0,		-- 是否出售，默认不出售
	no_comment BOOLEAN DEFAULT 0,		-- 是否不允许留言，默认允许
	is_hidden BOOLEAN DEFAULT 0,		-- 是否隐藏，默认不隐藏
--	UNIQUE(artwork_no),
	UNIQUE(artwork_name),
	FOREIGN KEY (added_by) REFERENCES Masters(master_id),
	FOREIGN KEY (artwork_type) REFERENCES ArtworkTypes(type_name_en)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET = UTF8;

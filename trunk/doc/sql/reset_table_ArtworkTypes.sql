
DROP TABLE IF EXISTS `ArtworkTypes`;
CREATE TABLE `ArtworkTypes` (			-- 古董类别，管理员可以删减
	artwork_type_id SERIAL PRIMARY KEY,
	type_name_en VARCHAR(30) NOT NULL,	-- artwork_type in Table Artworks 中的外键约束，30个字符以内，建议用拼音或英文表示
	type_name_zh VARCHAR(30) NOT NULL,	-- 类别的中文名，用于页面显示，10个汉字以内
	added_by BIGINT UNSIGNED NOT NULL,	-- 添加该类别的管理员id，有外键约束 Masters(master_id)
	addition VARCHAR(90),			-- 类别的附加说明，30个汉字以内
	FOREIGN KEY (added_by) REFERENCES Masters(master_id)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=UTF8;

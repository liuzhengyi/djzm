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

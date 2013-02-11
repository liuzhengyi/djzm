
drop table if exists `Links`;	-- 友链
create table `Links` (
	link_id serial primary key,
	link_name varchar(60) not null,		-- 友链名称，20个汉字以内，不可不填
	link_address varchar(255) not null,	-- 友链地址，60个字符以内，不可不填
	add_date datetime not null		-- 添加时间
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET = UTF8;


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

/*
select message_id, content, son_id from Message where son_id >= 0 limit 10;
$son_id = {1, 0, 2, 0, 4, 0, 0}j
select message_id, content from Message where message_id in ( 1, 2, 3)
*/

INSERT INTO `menu` (`parent_id`, `title`, `text`, `handler`, `image`, `i_role`) SELECT `id`, 'Birthdays', 'Дни Рождения', 'modules/birthday/template/viewBirthdays.php', 'fa-birthday-cake ', 2 FROM `menu` WHERE `title`='Clients';
INSERT INTO modules SET name="Birthdays",title='Дни Рождения',unsql='sql/uninstall.sql',dir='birthday';
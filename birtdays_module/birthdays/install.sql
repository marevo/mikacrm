INSERT INTO `menu` SET `parent_id`=(SELECT id FROM menu WHERE title='Клиенты'),`title`='Дни рождения', `handler`='templates/viewBirthdays.php', `image`='fa-birthday-cake ' ;
INSERT INTO modules SET name="birthdays";
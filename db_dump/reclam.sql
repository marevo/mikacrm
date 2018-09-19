-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 16 2018 г., 05:00
-- Версия сервера: 5.5.53
-- Версия PHP: 7.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `reclam`
--

-- --------------------------------------------------------

--
-- Структура таблицы `calendar_table`
--

CREATE TABLE `calendar_table` (
  `dt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `calendar_table`
--

INSERT INTO `calendar_table` (`dt`) VALUES
('2018-09-08');


-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contactPerson` varchar(50) NOT NULL DEFAULT 'null',
  `phone0` varchar(16) DEFAULT 'null',
  `phone1` varchar(16) DEFAULT 'null',
  `email0` varchar(30) DEFAULT 'null',
  `address` varchar(200) DEFAULT 'null',
  `birthday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `name`, `contactPerson`, `phone0`, `phone1`, `email0`, `address`, `birthday`) VALUES
(0, 'клиент не выбран', 'null', 'null', 'null', 'null', 'null', '0000-00-00'),
(1, 'чп Пупкин В С', 'Василий Пупкин', '0939999990', NULL, 'pupkin@gmail.com', 'Чернигов', '1990-03-07'),
(2, 'фирма Рога и Копыта 2', 'Владимир Кузякин', '0949999990', NULL, 'rogaandcopyta@gmail.com', 'Чернигов', '1990-06-23'),
(3, 'фирма Рога и Копыта ', '', 'null', '', '', 'Чернигов', '0000-00-00'),
(4, 'имя несуществующий клиент( нужно для проверки)', 'контакт-не существует', 'null', 'null', 'null', 'Чернигов', '0000-00-00'),
(6, 'Евич Илья', 'Евич Илья Андреевич', '0931107156', '', '', 'Чернигов, Козацкая', '0000-00-00'),
(8, 'Павел', '', '', '', '', 'Л', '0000-00-00'),
(9, 'мужичок клиент', 'мужичок', '09887767', '', '', 'чернигов', '0000-00-00');

-- --------------------------------------------------------

--
-- Структура таблицы `contactsclients`
--

CREATE TABLE `contactsclients` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `id_clients` int(11) DEFAULT '0',
  `phone` varchar(13) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `contactsclients`
--

INSERT INTO `contactsclients` (`id`, `name`, `id_clients`, `phone`, `email`) VALUES
(1, 'самуил', 1, '+380944444444', 'samuil@sam.com'),
(2, 'Вася Пупкин', 1, '093-999-999-0', NULL),
(4, 'Иванов', 6, '0939990999', ''),
(5, 'Петров Петр Петрович', 0, '0462044044', 'petya@gmail.com'),
(7, 'Павел', 0, '0933691459', ''),
(8, 'мужичок', 9, '09998877', '');

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `addCharacteristic` varchar(200) DEFAULT NULL,
  `measure` varchar(50) NOT NULL,
  `deliveryForm` decimal(10,2) DEFAULT '0.00',
  `priceForMeasure` decimal(10,2) DEFAULT '0.00',
  `id_suppliers` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `name`, `addCharacteristic`, `measure`, `deliveryForm`, `priceForMeasure`, `id_suppliers`) VALUES
(1, 'Труба 10х10х1,2-1,5 длина 6.05', 'режут газом по 2.86', 'м', '2.86', '11.00', 4),
(2, 'Труба 20х10х1,5 длина 6.05', 'режут газом 2.86', 'м', '2.86', '19.00', 4),
(3, 'пленка Oracal 451 для плотерной порезки', 'поставка в рулонах по 4м', 'м', '4.01', '23.00', 1),
(4, 'пленка светорассеивающая Oracal® 8500 Translucent Cal\r\n54 цвета, шолковисто-матовая\r\n', 'поставка рулон 4 м', 'м', '4.00', '34.70', 1),
(5, 'уголок 25*25*1.2 длина 6м', 'режут газом на длину 2.86', 'м', '2.86', '27.00', 4),
(7, 'лист оцинкованный  2.5 м* 1.5 м *1.2 мм', 'отпускаются только листами', 'шт', '1.00', '150.00', 3),
(14, 'лист оцинкованный 2.60 м* 1.8 м*1.2', 'отпускают только листами', 'шт', '1.00', '250.00', 3),
(15, 'пленка Oracal 452 для   оттенок 24447', 'для плотерной порезки в рулонах по 4 метра', 'м', '4.00', '25.00', 1),
(26, 'лист не оцинкованный 2.6м*1.80м*1.2мм', 'поставка только листами', 'лист', '1.00', '115.00', 3),
(33, 'брус деревянный 50мм*50мм*1.2м', 'отпускают поштучно', 'м', '1.20', '5.00', 2),
(34, 'брус деревянный 60мм*60мм*2.40м', 'отпуск поштучно 2.40', 'шт', '2.40', '0.00', 12),
(59, 'черное железо 2', 'поставка только в листах', 'шт', '1.00', '220.00', 3),
(60, 'материал 1', 'нет', 'vv', '1.00', '25.30', 9),
(61, 'пвх лист 1.22*3*5', 'поставка лист 1.22м*3м*5мм', 'шт', '1.00', '1440.00', 12),
(62, 'пвх лист 1.22*3*5', 'поставка лист 1.22м*3м*5мм', 'шт', '1.00', '1440.00', 16),
(63, 'акрил лист 1.22*3*5', 'поставка лист 1.22м*3м*5мм', 'шт', '1.00', '4170.00', 16),
(64, 'акрил ИСП лист 1.22*3*5', 'поставка лист 1.22м*3м*5мм', 'шт', '1.00', '4170.00', 12),
(65, 'краска 1л красная', 'банка 1 л', 'шт', '1.00', '300.00', 18),
(66, 'клей &quot;Космофен&quot; 100г', 'тюбик 100г', 'шт', '1.00', '90.00', 18),
(67, 'диод для освещения', 'шт', 'шт', '1.00', '13.50', 17),
(68, 'метизы', 'общее количество без разбору ( пишем цену после покупки )', 'шт', '1.00', '1.00', 18),
(69, 'блок питания 100Вт', 'блок питания для  диодов (лент диодных )', 'шт', '1.00', '640.00', 17),
(70, 'блок питания 60Вт', 'блок питания для  диодов (лент диодных ) 60 Вт', 'шт', '1.00', '420.00', 17),
(71, 'пленка 8500', 'пленка (надо доп характеристики изменить матовая или блестящая)', 'м погонный', '1.00', '186.00', 12),
(72, 'доп расходы', 'надо изменить доп характеристики', 'шт', '1.00', '1.00', 20),
(73, 'транспорт', 'перевозвка своей &quot;Волгой&quot;', 'шт', '1.00', '1.00', 20),
(74, 'работа', 'стоимость моей работы', 'шт', '1.00', '1.00', 20),
(76, 'гуано', 'хорошо лепится пока свежее', 'л', '1.00', '7.00', 21);

-- --------------------------------------------------------

--
-- Структура таблицы `materialstoorder`
--

CREATE TABLE `materialstoorder` (
  `id` int(11) NOT NULL,
  `idOrder` int(11) NOT NULL,
  `idMaterials` int(11) NOT NULL,
  `countNeed` decimal(10,2) NOT NULL DEFAULT '0.00',
  `priceCountNeed` decimal(10,2) DEFAULT NULL,
  `recomAddCount` decimal(10,2) DEFAULT NULL,
  `priceRecomNeed` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `materialstoorder`
--

INSERT INTO `materialstoorder` (`id`, `idOrder`, `idMaterials`, `countNeed`, `priceCountNeed`, `recomAddCount`, `priceRecomNeed`) VALUES
(1, 1, 1, '6.10', '67.10', '2.00', '62.92'),
(2, 1, 2, '2.00', '38.00', '1.00', '54.34'),
(17, 1, 4, '3.88', '134.64', '1.00', '138.80'),
(18, 1, 3, '1.00', '23.00', '1.00', '92.23'),
(19, 1, 1, '5.00', '55.00', '2.00', '62.92'),
(20, 1, 4, '2.00', '69.40', '1.00', '138.80'),
(53, 20, 3, '4.00', '92.00', '4.01', '92.23'),
(57, 20, 1, '2.50', '27.50', '2.86', '31.46'),
(58, 20, 2, '1.00', '19.00', '2.86', '54.34'),
(59, 20, 5, '4.50', '121.50', '5.72', '154.44'),
(81, 23, 1, '1.00', '11.00', '2.86', '31.46'),
(82, 23, 2, '1.00', '19.00', '2.86', '54.34'),
(83, 23, 33, '3.00', '15.00', '3.60', '18.00'),
(85, 23, 3, '4.00', '92.00', '4.01', '92.23'),
(86, 20, 59, '3.00', '660.00', '3.00', '660.00'),
(87, 31, 63, '1.00', '4170.00', '1.00', '4170.00'),
(88, 31, 61, '1.00', '1440.00', '1.00', '1440.00'),
(89, 31, 65, '1.00', '300.00', '1.00', '300.00'),
(90, 31, 66, '3.00', '270.00', '3.00', '270.00'),
(91, 31, 67, '180.00', '2430.00', '180.00', '2430.00'),
(92, 31, 68, '150.00', '150.00', '150.00', '150.00'),
(93, 31, 69, '2.00', '1280.00', '2.00', '1280.00'),
(94, 31, 70, '1.00', '420.00', '1.00', '420.00'),
(95, 31, 71, '5.00', '930.00', '5.00', '930.00'),
(97, 31, 73, '300.00', '300.00', '300.00', '300.00'),
(100, 33, 70, '1.00', NULL, NULL, NULL),
(104, 30, 70, '1.00', '420.00', '1.00', '420.00'),
(105, 32, 64, '1.00', '4170.00', '1.00', '4170.00');

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE `menu` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `parent_id` tinyint(4) NOT NULL DEFAULT '0',
  `i_module` int(11) DEFAULT NULL,
  `i_role` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `handler` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `parent_id`, `i_module`, `i_role`, `title`, `text`, `handler`, `image`) VALUES
(3, 0, NULL, 2, 'Contacts', 'Контакты', 'templates/viewAllContacts.php', 'icon-vcard'),
(4, 0, NULL, 2, 'Clients', 'Клиенты', 'templates/viewAllClients.php', 'fa-user'),
(5, 0, NULL, 2, 'Orders', 'Заказы', 'templates/viewAllOrders.php', 'fa-shopping-basket'),
(6, 0, NULL, 2, 'Suppliers', 'Поставщики', 'templates/viewAllSuppliers.php', 'icon-truck'),
(7, 0, NULL, 2, 'Materials', 'Материалы', 'templates/viewAllMaterials.php', 'icon-package'),
(8, 0, NULL, 2, 'Reports', 'Отчёты', 'templates/viewAllReports.php', 'fa-bar-chart'),
(9, 0, NULL, 1, 'Modules', 'Модули', 'templates/viewAllModyles.php', 'icon-box-add');

-- --------------------------------------------------------

--
-- Структура таблицы `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `unsql` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL COMMENT 'название желательно быть уникальным',
  `descriptionOrder` varchar(8000) NOT NULL DEFAULT '' COMMENT 'описание заказа',
  `source` int(11) NOT NULL DEFAULT '0' COMMENT 'источник сделки 0-не известен, 1-входящий звонок, 2-prom.ua, 3-olx, 4-сайт, 5 реклама в газете , 6 другое',
  `idClient` int(11) NOT NULL,
  `orderPrice` decimal(10,2) NOT NULL COMMENT 'стоимость заказа по договоренности с клиентом',
  `manufacturingPrice` decimal(10,2) NOT NULL COMMENT 'стоимость комплектующих',
  `isCompleted` int(11) NOT NULL DEFAULT '0' COMMENT 'заказ укомплектован материалами для производства 0-по умолчанию - нет, укомплектован-1-да',
  `isReady` int(11) NOT NULL DEFAULT '0' COMMENT 'степень готовности заказа 0-новый( надо еще  посчитать стоимость и связаться с заказчиком), 1-закрыт успешно, 2-закрыт неуспешно, 3-запущен',
  `isInstall` int(11) NOT NULL DEFAULT '0' COMMENT 'установлен у клиента 0-нет, 1-в процессе, 2-установлен',
  `dateOfOrdering` date DEFAULT NULL COMMENT 'дата начала производства-заключения сделки на производство ',
  `dateOfComplation` date DEFAULT NULL COMMENT 'дата полного закрытия заказа по идее должен совпадать с датой  полной оплаты',
  `isAllowCalculateCost` int(11) NOT NULL DEFAULT '1' COMMENT 'разрешение на добавление материалов к заказу и автоматическое изменение цены материалов  изменение цены комплектующих (если они изменялись )1-разрешить пересчет, 0-не разрешать пересчет',
  `isTrash` int(11) NOT NULL DEFAULT '0' COMMENT '0 - не удален( выводить на показ), 1- удален - не показвывать'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `name`, `descriptionOrder`, `source`, `idClient`, `orderPrice`, `manufacturingPrice`, `isCompleted`, `isReady`, `isInstall`, `dateOfOrdering`, `dateOfComplation`, `isAllowCalculateCost`, `isTrash`) VALUES
(1, 'вывеска  два в одном с подсветкой для магазина чп Пупкин В С Чернигов', 'нy очень большая можно и поболее размер 0.5м*0.5м на белом фоне красными буквами название магазин пупкина', 1, 1, '99.00', '387.00', 0, 3, 0, '2017-06-28', '2018-08-09', 1, 0),
(2, 'название ЛайтБокс для фирмы   Рога и Копыта Чернигов', 'Это должен быть лайт бокс такой красивусенький-прекрасивусенький', 1, 2, '120.00', '150.00', 0, 1, 0, '2018-05-20', '2018-06-23', 0, 0),
(20, 'скрепка стоппер', 'скрепка стоппер красного цвета с логотипом чп Пупкин and his wife', 0, 1, '4000.00', '7000.00', 0, 1, 1, '2018-08-16', '2018-08-14', 1, 0),
(21, '3 заказ Пупкину', 'без описания', 0, 1, '0.00', '0.00', 0, 0, 0, '2018-08-12', '2018-08-26', 0, 1),
(22, 'заказ 4 для Пупкина', 'без описания дополнительного', 0, 1, '10000.00', '15000.00', 0, 1, 0, '2018-08-12', '2018-08-26', 0, 1),
(23, 'вывеска для улицы', '', 0, 2, '0.00', '0.11', 0, 0, 0, '2018-08-22', '2018-09-05', 0, 0),
(24, 'название для проверкм', 'просто описание для проверкм', 6, 2, '0.01', '0.01', 1, 2, 0, '2018-08-31', '2018-09-14', 0, 0),
(25, 'заказ несуществующий для для проверки', 'доп описание для несуществующего заказа', 0, 2, '100.00', '200.00', 0, 1, 0, '2018-08-31', '2018-09-14', 0, 0),
(26, 'еще один заказ для проверки', 'просто без описания', 0, 2, '0.00', '0.00', 0, 0, 0, '2018-08-31', '2018-09-14', 0, 0),
(27, 'скрепка стоппер 2', 'no', 0, 2, '0.00', '0.00', 0, 0, 0, '2018-09-11', '2018-09-14', 0, 0),
(28, 'скрепка стоппер 1', 'no', 0, 2, '0.00', '0.00', 0, 0, 0, '2018-09-11', '2018-09-14', 0, 0),
(29, 'скрепка стоппер 11', 'no', 0, 2, '0.00', '0.00', 0, 0, 0, '2018-09-11', '2018-09-14', 0, 0),
(30, 'рекламный баннер', 'без подробностей', 0, 1, '5000.00', '6000.00', 0, 1, 0, '2018-09-12', '2018-09-15', 0, 0),
(31, 'надпись (со слов Вовы)', 'без описания', 0, 4, '8755.33', '11690.00', 1, 1, 0, '2018-09-15', '2017-10-10', 0, 0),
(32, 'новый заказ 18:50-04-12-2017', 'без описания нового заказа 18:50-04-12-2017', 0, 4, '9436.43', '15645.73', 0, 1, 0, '2017-12-04', '2017-12-18', 0, 0),
(33, 'зак от 23.02.18:18-00', 'зак от 23.02.18:18-00 для фирмы Рога и Копыта 2', 0, 2, '0.00', '0.00', 0, 0, 0, '2018-02-23', '2018-03-09', 0, 1),
(34, 'Форма просмотра данных', 'Для просмотра и редактирования ранее добавленных данных', 1, 6, '0.00', '0.00', 0, 0, 0, '2018-03-17', '2018-03-31', 0, 0),
(35, 'ппп', 'ппп', 2, 1, '0.01', '0.02', 0, 0, 0, '2018-06-16', '2018-06-30', 0, 1),
(36, 'заказ для мужичка лайтбокс', 'вывеска над балконом светящееся', 0, 9, '0.00', '0.00', 0, 0, 0, '2018-06-24', '2018-07-08', 0, 0),
(37, 'шаг', 'табличка', 0, 6, '100.00', '0.00', 0, 0, 0, '2018-09-15', '2018-09-29', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `idOrder` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  `date` date NOT NULL,
  `sumPayment` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `payments`
--

INSERT INTO `payments` (`id`, `idOrder`, `idClient`, `date`, `sumPayment`) VALUES
(2, 2, 2, '2018-06-23', '35.00'),
(13, 1, 1, '2018-03-13', '9.00'),
(27, 2, 2, '2017-09-01', '15345.24'),
(45, 26, 2, '2018-09-03', '1.00'),
(47, 21, 1, '2018-09-03', '1.00'),
(48, 1, 1, '2018-09-03', '1.00'),
(51, 1, 1, '2018-09-03', '2.00'),
(52, 23, 2, '2018-09-03', '0.01'),
(53, 23, 2, '2018-09-03', '3.00'),
(54, 23, 2, '2018-09-03', '3.33'),
(56, 23, 2, '2018-09-02', '2.22'),
(58, 20, 1, '2018-09-03', '0.01'),
(59, 20, 1, '2018-09-03', '1.10'),
(60, 23, 2, '2018-09-08', '4.44'),
(61, 21, 1, '2018-09-08', '9.99'),
(62, 23, 2, '2018-09-11', '100.00'),
(63, 31, 4, '2018-09-15', '2754.73'),
(64, 31, 4, '2018-09-15', '623.26'),
(65, 31, 4, '2018-09-15', '232.38'),
(66, 31, 4, '2018-09-15', '7236.92'),
(67, 32, 4, '2018-02-10', '99.00'),
(68, 32, 4, '2018-02-20', '1.00'),
(69, 32, 4, '2018-02-20', '1.00'),
(70, 32, 4, '2018-02-20', '1.00'),
(71, 32, 4, '2018-02-20', '1.00'),
(72, 32, 4, '2018-02-20', '1.00'),
(73, 32, 4, '2018-02-20', '1.00'),
(81, 33, 2, '2018-02-26', '0.02'),
(82, 33, 2, '2018-02-26', '2.00'),
(83, 36, 9, '2018-08-24', '10000.00'),
(84, 36, 9, '2018-08-24', '2000.00');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Администратор'),
(2, 'ФЛП');

-- --------------------------------------------------------

--
-- Структура таблицы `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `contactPerson` varchar(100) DEFAULT NULL,
  `addCharacteristic` varchar(300) DEFAULT NULL,
  `phone0` varchar(20) DEFAULT NULL,
  `email0` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `deliveryDay` int(11) DEFAULT NULL COMMENT '1-пнд: 5-птн 6 -все рабочие дни 7-всю неделю 8-не установлено',
  `site` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contactPerson`, `addCharacteristic`, `phone0`, `email0`, `address`, `deliveryDay`, `site`) VALUES
(1, 'plastics пластикс Украина', 'Петров Владимир Владимирович', 'пленки разные', '0 (44) 201 15 42', 'надо найти email и записать', 'вул. Межигірська, 82А, корп. Б Київ , Україна , 04080', 1, 'http://plastics.ua/viscom/ua/products/samokleika/plenka-plotter/'),
(2, 'Пиломатериалы Киев', 'Владимир', 'пиломатериалы', '+38067426-93-70', 'kaplia_vladimir@mail.ru', 'Украина Киев ул. Героев Днепра, рынок', 2, 'https://pilomaterialu.com.ua/g1956144-brus-derevyannyj-suhoj'),
(3, 'ООО \"МЕТКОНБУД\"', NULL, 'листовое железо', '+38 (066) 557 98 33', 'http://metkonbud.in.ua/', 'Украина, Киев, Пр. Леся Курбаса 2Б', 1, 'http://metkonbud.com.ua/'),
(4, 'торговый дом металл плюс', NULL, 'металлопрокат в ассортименте', '(044) 537-04-17', 'rulana@ukr.net', 'Киев, ул. М.Расковой, 23 оф.525', 1, 'http://www.metalplus.com.ua/'),
(5, 'поставщик для проверки', 'контакт для проверки', 'поставляет материалы для проверки', '1234567891012', NULL, 'адрес для проверки', 8, NULL),
(9, 'nameSupplier', 'cont person', 'add char', '0959999990', NULL, 'Чернигов', NULL, NULL),
(10, 'nameSupplier1', 'Vas Vas', 'add Char', '0992552550', 'vasvas@gmail.com', 'cher', 8, ''),
(11, 'разработчик', 'Михаил Рево', 'разработчик этой программы', '0937997990', 'marevo1972@gmail.com', '50 лет ВЛКСМ 16, 48', 6, ''),
(12, 'Промдизайн (со слов Вовы)', 'Наталия Перегняк', 'листы пвх акрил разных размеров', '050 30 113 05', 'nataly@promdesign.ua', 'пока нет', 6, 'https://www.promdesign.ua'),
(16, 'Аверс (со слов Вовы)', 'нет', 'листы пвх акрил разных размеров', '0444840323', 'info@avers.ua', '04050, м. Київ, вул. Пимоненка, 13ж', 6, 'http://avers.ua'),
(17, 'Elf', 'нет', 'светлодиоды для рекламы, лента светодиодная, блок питания', '0445071176', 'info@avers.ua', 'Киев,Викентия Хвойки, 21', 6, 'http://www.elf-led.com.ua/'),
(18, 'магазин Вена', 'нет', 'краска разная, крепеж', '', '', 'Чернигов, Героев Чернобыльцев', 6, ''),
(20, 'чп Шевченко В', 'Шевченко Вова', 'доп расходы', '0661750466', '', 'Чернигов', 6, ''),
(21, 'куку', 'кислый огурец', 'уксус', '0330330031', 'error@error.ru', 'киев, одесса', 2, 'https://getbootstrap.com/docs/4.0/components/buttons/');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL COMMENT 'название задачи',
  `content` varchar(500) NOT NULL COMMENT 'содержание задачи',
  `deadline` date NOT NULL COMMENT 'срок выполнения до',
  `idUser` int(11) NOT NULL COMMENT 'ответственный из users',
  `priority` int(11) NOT NULL DEFAULT '2' COMMENT 'приоритет 0-сверх срочно, -1 срочно, 2-обычно, ',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'статус выполнения 0-не готова(по умолчанию) 1- назначена, 2-не назначена, 3-готова',
  `dateAppointment` date NOT NULL COMMENT 'дата когда поставлена (озвучена) задача',
  `completionDate` date NOT NULL COMMENT 'когда выполнена'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `i_role` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `gmail` varchar(100) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `secretQuestion` varchar(100) DEFAULT NULL,
  `secretAnswer` varchar(100) DEFAULT NULL,
  `session` varchar(32) DEFAULT NULL,
  `updated` varchar(50) DEFAULT NULL,
  `rightUser` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `i_role`, `name`, `login`, `password`, `gmail`, `phone`, `secretQuestion`, `secretAnswer`, `session`, `updated`, `rightUser`) VALUES
(1, 2, 'Михаил Рево', 'adminMarevo', '$2y$10$Da0edjR1TuRVWDqtACSrw.XM3I1QjLfPcJh18X62Buq5/HisKo6I.', 'marevo1972@gmai.com', '', 'фамилия матери', 'Попова', '49d5tdrfndtll1cuiqh52m23c1', '1507840254', 'c r u d'),
(2, 1, 'Екатерина', 'user', '$2y$10$DgCREMkZ/gHo5XB1VIlY4O8ujrkDTHG19sqFaoPJ8Am.QSQjKrede', 'k.pristupa90@gmail.com', '+380633995553', '?', '!', '47l46o6lc08ok1ft4ojb50rpc2', '1537047364', NULL),
(3, 1, 'Павел', 'pahan', '$2y$10$bR29B51AwWKbO6X83BR3wujY6PQh81GL00/TCABDDRJe3B/.bqH3C', 'prispav@gmail.com', '0933691459', NULL, NULL, 'i12atuvr4te0vnqjntt7dtbfq5', '1537061248', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `calendar_table`
--
ALTER TABLE `calendar_table`
  ADD PRIMARY KEY (`dt`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `contactsclients`
--
ALTER TABLE `contactsclients`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nameMaterialFromOneSupplier_Unique` (`name`,`id_suppliers`),
  ADD KEY `materials_fk0` (`id_suppliers`);

--
-- Индексы таблицы `materialstoorder`
--
ALTER TABLE `materialstoorder`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idOrder` (`idOrder`),
  ADD KEY `idMaterials` (`idMaterials`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i_module` (`i_module`),
  ADD KEY `i_role` (`i_role`);

--
-- Индексы таблицы `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idClient` (`idClient`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idOrder` (`idOrder`),
  ADD KEY `payments_ibfk_2` (`idClient`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone0` (`phone0`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nameUser` (`name`),
  ADD UNIQUE KEY `loginUser` (`login`),
  ADD UNIQUE KEY `passwordUser` (`password`) USING BTREE,
  ADD UNIQUE KEY `gmailUser` (`gmail`),
  ADD KEY `i_role` (`i_role`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `contactsclients`
--
ALTER TABLE `contactsclients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT для таблицы `materialstoorder`
--
ALTER TABLE `materialstoorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT для таблицы `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_fk0` FOREIGN KEY (`id_suppliers`) REFERENCES `suppliers` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `materialstoorder`
--
ALTER TABLE `materialstoorder`
  ADD CONSTRAINT `materialstoorder_ibfk_1` FOREIGN KEY (`idOrder`) REFERENCES `orders` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `materialstoorder_ibfk_2` FOREIGN KEY (`idMaterials`) REFERENCES `materials` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`i_module`) REFERENCES `modules` (`id`),
  ADD CONSTRAINT `menu_ibfk_2` FOREIGN KEY (`i_role`) REFERENCES `roles` (`id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `clients` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`idOrder`) REFERENCES `orders` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`idClient`) REFERENCES `clients` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`i_role`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

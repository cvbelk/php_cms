-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Фев 10 2021 г., 12:43
-- Версия сервера: 10.4.16-MariaDB
-- Версия PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Bootstrap'),
(2, 'Javascript'),
(23, 'javaEE'),
(24, 'Ruby2'),
(25, 'C++'),
(26, 'C#.Net'),
(27, 'php'),
(28, 'react/redux'),
(29, 'Python');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(4, 7, 'sdsd', 'megathone@i.ua', 'sddsdsdsds', 'Approved', '2020-12-13'),
(6, 8, 'megathone', 'megathone@i.ua', '\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. ', 'Approved', '2020-12-13'),
(13, 17, 'troll', 'troll@cv.ua', 'number 1', 'Approved', '2021-01-04'),
(14, 2, 'Edwin', 'edwin@diaz.com', 'Inventore, perspiciatis adipisci accusamus laudantium odit', 'Approved', '2021-01-04'),
(19, 2, 'troll', 'troll@cv.ua', 'Inventore, perspiciatis adipisci', 'Approved', '2021-01-04');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_user` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_views_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`) VALUES
(2, 1, 'Javascript course post', 'Oleh', 'troll', '2021-01-04', 'image_5.jpg', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>', 'javascript2, course, class', 3, 'published', 10),
(7, 24, 'new post', 'Oleh', 'oleh', '2021-01-04', '128525113_1650282655151958_1763992035956108369_n.jpg', '<p>Sed ut <strong>perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab</strong>o. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolor</p>', 'css, html', 1, 'published', 5),
(8, 27, 'post by troll', 'troll', 'troll2', '2021-01-04', '9ce253b-foto-twaryny-12.jpg', '<p>lskdoskdskd dsdsds sdsd &nbsp;sdsd fff fff! ffdff</p>', 'php, sql', 0, 'published', 3),
(15, 24, 'post new 1', 'troll', 'troll', '2021-01-04', '119231721_3136486839733383_3157457124261150325_n.jpg', '<p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail</p>', 'tag, oleg', 0, 'published', 0),
(16, 23, 'new post new', 'oleh', 'oleh', '2021-01-04', '33280322-8741673-image-a-26_1600308448350.jpg', '<p>in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to</p>', 'php, sql', 0, 'draft', 4),
(17, 2, 'post next', 'belk', 'oleh', '2021-01-04', '127236477_3474004229351552_5017270958794615865_n.jpg', '<p>do what we like best, every pleasure is to be welcomed and every pain avoided.</p>', 'js, php, html', 0, 'published', 0),
(26, 1, 'test user-related 2', '', 'troll', '2021-01-04', '134596507_495866098054300_4754042988937728180_n.jpg', '<p>sdkj dsj d soooo</p>', 'css, html', 0, 'published', 0),
(27, 24, 'test user-related 3', '', 'troll2', '2021-01-04', '134150598_692142561500015_2705329856636245491_o.jpg', '<p>jdhjhjhj dkjkj kjj</p>', 'js, php, html', 0, 'draft', 1),
(28, 26, 'security check post', '', 'demo1', '2021-01-09', '135573560_696244394423165_512791250021666516_n.jpg', '<p>khhk 22 dkskk dkjkd dd</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>', 'php, sql', 0, 'published', 0),
(29, 25, 'new post in category C++', '', 'troll', '2021-01-28', '134952794_5402044956532734_4138628318692414409_n.jpg', '<p>dsodko sdsd dsd dsdsd sd</p>', 'ruby2', 0, 'draft', 0),
(33, 28, 'post wout image', '', 'troll', '2021-01-28', '', '<p>jhdsds ddf d. dsds dsf[pll. )))))</p>', 'html, img', 0, 'draft', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `randSalt` varchar(255) NOT NULL DEFAULT '$2y$10$iusesomecrazystrings22',
  `user_token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `randSalt`, `user_token`) VALUES
(17, 'troll', '$2y$10$t1.6b.66bkdWHIJbTsz6t.s6x5fUVnX2.2bi4Qr3X4GlSyFERsa7K', 'Oleh', 'Bilokrylyi', 'cvbelk@gmail.com', '1553581810123515401.jpg', 'admin', '$2y$10$iusesomecrazystrings22', '3c9128f230c21562775f2514f4c8c2ff2ed0df76435ef1e355ded5861f0913664273d2dcdb2c51975c28d35fd7e8b30504fc'),
(22, 'oleh', '$2y$10$W3O8/2LRWVcAq8HejmCfoOXnaIv.zKTO/jZoAuzy1volctm3ZPIpG', 'Oleh', 'Bilokrylyi', 'bel@k.ua', '117844294_1593397904167287_6319613890044826799_n.jpg', 'admin', '$2y$10$iusesomecrazystrings22', ''),
(23, 'demo1', '$2y$10$x9s045DqD20qYtKO/zv/PuOSWdA3PbTn8.lS9MDqdJVm/puiHZ8bG', 'de', 'mo1', 'demo1@demo.com', '', 'subscriber', '$2y$10$iusesomecrazystrings22', ''),
(24, 'demo2', '$2y$10$UU/DMYab2OB1zk6GMKlYIuSmj2hioJ5aXmOPrsXVYJUyLVNkU0fdq', 'de', 'mo2', 'demo2@demo.com', '', 'subscriber', '$2y$10$iusesomecrazystrings22', ''),
(25, 'troll3', '$2y$10$4nrRnJaFVD9lhkUeQSvRgOOtX95kTBqJ2neGV4GF.WPfoub4QpBLq', '', '', 'cvtroll@cvtroll.tr', '', 'subscriber', '$2y$10$iusesomecrazystrings22', ''),
(38, 'lupila', '$2y$10$NyLPNXhsG.9ravPVQ/CHaO51forxP8yQsplsxkRTImIiJa6rSgPX6', '', '', 'lup@ila.com', '', 'subscriber', '$2y$10$iusesomecrazystrings22', '');

-- --------------------------------------------------------

--
-- Структура таблицы `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(1, '8dt2c0sbq8q9kudp3qm5v59mqh', 1609418160),
(2, '1d7243btcpigrldddi6jpbir3i', 1609418154),
(3, '758t3041d6rm1vji5msjhfjqp8', 1609438646),
(4, '6ah2jk37rsnajgr3k35a6l99k5', 1609441560),
(5, 'k20f0k6lo2j340b0inotocfgfg', 1609441422),
(6, 'eic382njb0ob3j4nfshnlcsku6', 1609782722),
(7, 'jtc37ksm9d3fg2u6kg319hfugg', 1609785326),
(8, 'jira8qbj3fvtl2vm86knboqdrc', 1609933132),
(9, 'rom3svrvbj042fg2ebo5apprli', 1610213400),
(10, 'ct4otkl9mjmg1u1iuum7pfd6pc', 1610224792),
(11, 'b0vipmh7ni6or33d6hi1sn0ri2', 1610482128),
(12, 'hmkmufbqbq8vf60mdkgc1neksf', 1610991642),
(13, 'mtffrs1qqk30ilgh19el4oq14i', 1611667103),
(14, '3jb7v60s10vcn3954l1t08crfp', 1611852526);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Индексы таблицы `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

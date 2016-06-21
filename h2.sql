-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016-06-19 19:37:58
-- 服务器版本: 5.5.44-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `h2`
--

-- --------------------------------------------------------

--
-- 表的结构 `blog_comment`
--

CREATE TABLE IF NOT EXISTS `blog_comment` (
  `CID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) NOT NULL DEFAULT '0',
  `upCID` int(11) NOT NULL DEFAULT '0',
  `UID` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL,
  `IP` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `url` tinytext NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`CID`),
  UNIQUE KEY `CID` (`CID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `blog_comment`
--

INSERT INTO `blog_comment` (`CID`, `PID`, `upCID`, `UID`, `time`, `IP`, `name`, `email`, `url`, `content`) VALUES
(1, 4, 0, 0, 1466265595, '', '小志志', '123@qq.com', '', '都稀缺，因为信息本身稀缺，也因为信息是有方向维度的，不适合你的信息不是信息，同时，人人都知道怎么吸收一些浅度信息，但是很多人不知道怎么吸收深度的信息。所以，大多数人当他们喊着信息过剩的时候，他们的脑子里面只是垃圾过剩而已，我们应该做一个对真正的');

-- --------------------------------------------------------

--
-- 表的结构 `blog_meta`
--

CREATE TABLE IF NOT EXISTS `blog_meta` (
  `MID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  `slug` tinytext,
  `type` tinytext NOT NULL,
  `description` tinytext,
  `count` int(10) unsigned DEFAULT '0',
  `order` int(10) unsigned DEFAULT '0',
  `parent` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`MID`),
  UNIQUE KEY `MID` (`MID`),
  KEY `slug` (`slug`(191))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `blog_meta`
--

INSERT INTO `blog_meta` (`MID`, `name`, `slug`, `type`, `description`, `count`, `order`, `parent`) VALUES
(1, '默认分类', 'default', 'category', '22222222222222', 0, 0, 0),
(3, '点点滴滴', 'dddd', 'category', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `blog_nav`
--

CREATE TABLE IF NOT EXISTS `blog_nav` (
  `title` tinytext NOT NULL,
  `slug` tinytext NOT NULL,
  `url` tinytext NOT NULL,
  `order` int(10) unsigned zerofill NOT NULL,
  `other` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `blog_post`
--

CREATE TABLE IF NOT EXISTS `blog_post` (
  `PID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `UID` int(11) unsigned NOT NULL,
  `MID` int(10) unsigned NOT NULL,
  `time` int(11) NOT NULL,
  `slug` tinytext NOT NULL,
  `type` tinytext NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `title` tinytext NOT NULL,
  `content` text NOT NULL,
  `isPost` enum('0','1') NOT NULL,
  PRIMARY KEY (`PID`),
  UNIQUE KEY `pid` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `blog_post`
--

INSERT INTO `blog_post` (`PID`, `UID`, `MID`, `time`, `slug`, `type`, `order`, `title`, `content`, `isPost`) VALUES
(3, 1, 1, 1466260953, 'meizi', 'post', 0, '程序员教你如何追女生', '<p>好啦，今天这次IT内部培训，我们不讲编码技术，也不灌鸡汤要求大家加班。今天我们谈一个你们这群单身狗已经掌握却一直没怎么用的技能：“追求女生”。1.广泛涉猎恋爱技能，进行自学交给你一个项目，遇到不会的开发工具怎么办？学啊！我们程序员拥有超强的自学能力。星座，塔罗牌，看手相，大姨妈陪护，这些能引起女生共同话题的知识不要以为没有用，你就当学习一门新的编程语言嘛！一点都不难对不对？要充分利用知识管理，我们不会谈恋爱，但是我们可以收集资源自学啊！我们可以看书啊，我们可以听罗辑思维啊！知识就是力量！2、需求分析要先行，谁是老大、谁是涉众要分清很多男生遇见喜欢的女神，就羞于表达，也不清楚对方到底喜欢什么。我们程序员也会遇到这样的问题，但是我们有办法。程序员的需求分析技能是谈恋爱的必杀技。给你一个手机号码，你可以知道她的QQ，微信，微博，然后进行“大数据分析”，朋友圈里面喜欢发什么，微博喜欢转发什么？QQ空间里相册这几年下来都有什么。用户需求分析就是在这样的过程中逐步搞清楚的。这个过程中你需要搞清楚她身边两类角色：（1）老大的愿景，也就是能决定她到底会不会喜欢你，会不会和你在一起的人。你会说，我K，这不就是她本人么？！错，这个人很有可能是每天都跟她在一起的闺蜜，或者是她妈。（2）涉众的利益，涉众的意思，就是在你的追求计划中可能会产生作用的人，虽然没有起决定性作用，但是他们也会影响。就像一部演出一样，前排的涉众会你要特别照顾她们的感受，后排的观众最不重要。老大的愿景和涉众的利益都要考虑3、业务流程要熟练，活动安排要紧跟程序员做任何事情都会考虑流程和计划，所以在追求女生这件事情上，业务流程的安排直接影响你的约会质量。了解完女孩子的需求之后，你要制定你的业务流程了。    她喜欢在哪里吃饭？    喜欢看什么类型的电影？    喜欢其他什么业余生活？K歌，跑步，旅行？针对这些爱好去邀请她，你要制定好充分的计划以及backup。提前预案，一条龙安排好，她负责美，你负责其他就好了。4、迭代进行约会，永远不断check女孩的心在程序员的世界，需求一直是变的。女生的世界也是一样啊。你要是能懂她的一切，我就去吞粪。所以面对变化莫测的需求，我们应该怎么办？！迭代啊！快速的进行迭代，去小范围试错，看看姑娘喜欢什么。喜欢吃辣？川菜还是湘菜？水煮鱼还是干锅牛蛙？不要老想着一步到位，从见第一次面到结婚全部搞定。这种急功近利的态度我们程序员没有，我们都懂得开发模型，计划，进度和里程碑！用迭代来应对女生变化莫测的需求变更所以这个过程中你需要不断试错，让你做的一切更符合女生的心意。5、修复缺陷从一开始就进行，持续让对方看到更新程序员的臭毛病我们都有，这是我们的缺陷。(不要让我说有哪些！orz)咳咳~所以你一旦有了喜欢的对象并开始进行追求，你的缺陷跟踪体系就要建立起来了。当女生向你抱怨一件关于你的事情的时候，你就要小心了。缺陷记录，跟踪和及时修改反馈，让女生知道你在积极为她改变。单身狗为什么一直单身，是因为他们没有产品思维，一直觉得自己是最傲娇的，老子为什么要为TA改变？所以咯~对心爱的人做出的自我缺陷修复，怎么了！怎么了！怎么了！6、地面最强耐心，只要不换人，会一直运维下去好不容易建立起来的感情，程序员会一直呵护下去。我们是这个世界上最安全的人类种族，这已经得到公认了，要利用好这个优势。但是你也得要让对方知道你的这个优势：我们能守着电脑24小时不撤，女生需要我们的时候，一直守护在身边这种技能是一定要有的。恩，我们加班习惯了，谁先困谁是孙子。7、记不住没关系，要使用配置管理第一次牵手，第一次旅行，恋爱纪念日·····你还记得是哪一天么？很多关键性的活动我们总是记不住，但是我们程序员有一招叫“配置管理”，我们通过记录、保存文档来保证过程不丢失，哪怕过去一百年，我们所有的记录都是可以追溯的。所以利用网络云笔记，实时保存每一次约会的记录，让我们的约会变得有技术保障！江湖上那些印个回忆录相册什么的小伎俩，在我们这根本不是事儿，我们一键导出就可以了。记录下来，就不会忘记结语产品我们讲究女性化思维，谈恋爱更要考虑这一点。为什么很多人每一件事情都做对了还是会失败？当你准备去追求一个女生的时候，你的包装，你的质量，你的内容，甚至是你所在的应用情景，都是对方会考量的。作为程序员，我们在研发上已经充分证明了我们的实力。接下里，我希望大家做一次跨界，把这些技能应用到解决自己的单身问题上。好~今天就讲到这里，大家回去好好想想，有问题，会后直接给我留言，散会。另外今天晚上20点半，我们再回到这个会议室开一下周会。文／彭小六（简书签约作者）原文链接：<a href="http://www.jianshu.com/p/361276fdce9b" rel="nofollow">http://www.jianshu.com/p/361276fdce9b</a>著作权归作者所有，转载请联系作者获得授权，并标注“简书签约作者”。</p>', '0'),
(4, 1, 3, 1466261008, '576602ac71a73', 'post', 0, '哪里真有什么信息过剩，你过剩吸收的是垃圾', '<blockquote><p style="">现在大多数人最爱说的就是现代社会信息过剩。链<img alt="Image" height="19" width="44">接文字</p></blockquote><p>是啊，当年号称中国历代帝王里面最勤政之一的，雍正在位十三年共四千多天， 硃批汉文奏折35000余件，满文奏折7000余件，但是平均下来，一天也才批阅12-13个奏折。而我们现代人呢？一天花在微博多少时间？一天花在朋友圈多少时间。我有朋友给我看了一眼他一个同事的朋友圈，一个小时不到，转发了15篇长文。话唠程度<i>简直快跟我相当了。问题是你看了那么多东西，你上通天文，下知地理，然后呢？这些<code>知识帮你找到新工作了？帮你升职了？找你找到女朋友，男朋友了？你每天深夜睡前还努力刷上半个小时以后，才肯睡去。给你带来的唯一收获是什么？你学会了一句“然并卵”，看到所有帖子都想回复这句。你学会了一句“道理我都懂还是过不好这一生。”父母给你打电话，你爱答不理。跟恋人坐在出租车上，还没说上两句，你们就各自掏出了手机，唯一能看出你们亲密关系的是，他看到了一个好玩的笑话会转给你，你看到了一个好玩的笑话也会转给他。随时随地你都在刷，随时随地你都在转。你总觉得这世界太匆促，稍微不小心就错过了一句至理名言、爆笑的笑话。但是，你看到一篇稍微长的文章，就会说，这么长，谁有耐心看啊</code>。至于</i>看书，我就呵呵呵了，你这几年阅读量也算是日可过万，但是书长得什么样子，你都快忘了吧？对，在这个情况下，你当然会觉得信息过剩了，人生苦短，一睁眼一闭眼，人生就过了，唯一的遗憾是，朋友圈还没刷完。但是，错了，信息从来没有过剩，你只是沉迷在<b>噪音里面而已。首先，我们要说明白，什么是信息，什么是噪音。一切可以给你带来实际好处的都是信息，不能给你带来任何好处的就是噪音。1、很多好的信息是稀缺的。而且是有时间限制的，过了时以后可能就没有价值了。如果你有内幕信息（暂时不讨论内幕交易的法律问题），你可以轻松致富，这样的东西是信息。这个世界最有威力就是信息。如果你可以回到过去，最重要的不是改变过去，而是获得未来房价的信息，未来会狂涨的股票，未来的大奖彩票号码。然后你就可以悠闲地变成一个钱怎么都花不完的富翁了。但是如果你知道昨天的大奖彩票号码，有任何价值么？但是，这些信息都是稀缺的，是难以获得的。如果你想在股市上驰骋，你需要有大量的行业知识，或者深刻股票市场本身的规律，当然或者你运气很好</b>，遇上了10年不遇的大牛市跟着全国人民一起发家，可惜最后一种方式的很多成功者，在接下来的大熊市，不仅牺牲了全部的身价，还赔上了未来几年的全部家用。这样的信息不可能出现在你的微博和朋友圈里。为什么我一直倡导大家读书呢？因为大多数人不读书，所以，很多并不稀奇的道理，并不难懂的道理，就稀缺起来。你掌握了这样稀缺的信息，你就掌握了，别人没有的能力和价值了。07、08年的时候，我和霍炬在开咨询公司，客户询问我们能否帮他们提供一套搜索系统。我知道Lucene可以用来做搜索，于是买了两本书<code>《Java语言入门》</code>和《Lucene In Action》，当时国内可能有百万Java程序员，所以，《Java语言入门》并不是稀缺的信息。但是，Lucene当时在国内还不流行，知道的人还不多，《Lucene In Action》在国内的销量可能还没过万，在加上不是谁读了都能读懂。所以保守的估计，国内当时可以做好Lucene的人可能也就在百人左右。所以，看这两本书的结果是，我写了一套系统，当月上线，几天后，就卖了10多万，后来一直都有客户。我们还用这套系统开了另外一家公司，融了75万人民币的天使。信息的价值可见一斑。（利益相关：这公司后来，我们运营的不好，且遭遇美国次贷危机，没有融到A轮，无疾而终）如今国内可能有上百万iOS程序员。所以，iOS并不是什么多稀缺的知识。但是，09年，iOS刚有SDK的时候，我就开始学习了。那时候，全北京估计只有20-30人会写iOS程序。于是，当网易有道想迅速推出一个iOS版本的有道词典的时候，他们很难找到人，自己的程序员也一时不知道能不能学会。他们辗转问了很多人通过一个朋友找到了我，我帮助他们做了有道词典的iOS版的第一个版本。大概1-2年后，有道词典iOS版本就做到了上亿用户。这是我历史上写的最火的App。但是我从来都不是网易的员工。做到这件事情，正是因为我在合适的时间，掌握了稀缺的信息。2、你的蜜糖可能是他人的毒药。信息亦然，你的信息也许是别人的噪音，你的噪音也许是别人的信息。对大多数时候，街边的小广告是我们最反感的一种噪音。我在天津家里的楼道里面到处都是小广告，墙上是，楼梯上是，楼梯下方也被贴满了。大家铲了，他马上又给你贴上，墙刷了一遍又一遍，他们总是春风吹又生。但是，那年我刚好在北京的广安门附近要租房子的时候，让我迅速找到房子的正是房东贴的小广告。对每天路遇的上万个正好暂时不想换房的人们，那条小广告就是垃圾。而对那一个正好走过，也正好想换房的我，那条小广告就是信息。所以经常有人来问我，tiny叔，我是一个大学生，我该看什么书？tiny叔，我是iOS初学者我该看什么书？你就是你，你该看什么书别人怎么知道？自己需要什么书是根据自</p><p><br></p><blockquote><p>己的需求来的，自己在大量的阅读下体会出来的，找别人推荐就是找捷径，就是不走脑子，就是想被洗脑上瘾，不停地想找些垃圾来毒害自己。3、深度信息的价值。这些年，我不断的跟人说多看书的好处。第一是因为现在看书的人很少，你只要看书，就可以脱颖而出。第二是我认为对你最核心的是成长，而成长就是不断的用体系化的知识，倒逼自己大脑进化。你看几万条微博和微信朋友圈，不如找到一本薄薄的100页的好书带来的成长。大多数的微信公众号也是浅信息，但是我们tiny4voice不是，我们一直坚持用比写书要求还高的要求来要求自己。每一篇文章的立意是揭示大家的一些认识误区，起到当头棒喝的作用，力求有价值，力求可以帮助大家成长。什么是深度信息呢？一般来说经典书都是。但是，其实有时候，书没有好坏，关键是对你是否有价值。比如，《人月神话》这本书很薄，其实就是在讲一个非常简单的道理。就是说，建筑行业小工可以10个人一起砌一面墙，所以，10个人砌墙比1个人快10倍。而软件行业，因为代码的耦合性，管理方法的耦</p><p>息，从来都稀缺，因为信息本身稀缺，也因为信息是有方向维度的，不适合你的信息不是信息，同时，人人都知道怎么吸收一些浅度信息，但是很多人不知道怎么吸收深度的信息。所以，大多数人当他们喊着信息过剩的时候，他们的脑子里面只是垃圾过剩而已，我们应该做一个对真正的信息极度渴求的人，对垃圾主动抗拒的人。判断一切问题的维度很简单，就是我们一直说的，一切从自己出发，从自己的需求出发，从自己成长的角度去考虑。如是。<img alt="Image"></p></blockquote>', '0'),
(7, 1, 0, 1466323395, 'AliFarhadi', 'page', 0, 'Ali Farhadi', '<p>		</p><h1>HTML5 Sortable</h1><p> <i>HTML5 Sortable</i> is a jQuery plugin to create sortable lists and grids using native HTML5 drag and drop API.	</p><p>	</p><h1>DEPRECATION NOTICE</h1><p>This project is not mantained anymore. I recommend using <a href="https://github.com/RubaXa/Sortable">RubaXa''s Sortable</a> or <a href="https://github.com/voidberg/html5sortable">voidberg''s fork</a> instead.</p><p>	</p><h1>Why another sortable plugin?</h1><p>	</p><p>	Because it''s better.	</p><p>	Well, If you want to read the whole story read it <a href="http://farhadi.ir/posts/the-story-behind-html5-sortable">here</a>.</p><p>	</p><h1>Features</h1><p>	</p><ul><li>Less than 1KB (minified and gzipped).		</li><li>Built using native HTML5 drag and drop API.		</li><li>Supports both list and grid style layouts.		</li><li>Similar API and behaviour to jquery-ui sortable plugin.		</li><li>Works in IE 5.5+, Firefox 3.5+, Chrome 3+, Safari 3+, and Opera 12+.	</li></ul>', '0'),
(8, 1, 0, 1466323428, '576651d754336', 'page', 1, 'PHP常见的保留小数位方法', '<p>最近工作中，要用到保留小数为的方法，我第一个想到的就是round函数，简单无痛，但是最后结果竟然有问题。</p><p>总之，对于常见的小数用round函数就可以了，如果round遇到的一些不可预知的问题可以尝试一下其他方法。</p><p>在网上搜了很多种方法，最终我使用number_format完成了，下面记录一下我搜集的集中方法，以后用到的时候也方便翻阅。</p><h3>sprintf()</h3><p>sprintf() 函数把格式化的字符串写写入一个变量中</p><pre><code>echo sprintf("%.3f", 123456.123456); //123456.123\n</code></pre><h3>round()</h3><p>php集成的函数，如果精度一般，推荐用它</p><pre><code>echo round(123456.123456,3); //123456.123\n</code></pre><h3>number_format()</h3><p>利用千位分组来格式化数字的函数，如果精度较大，可以尝试使用它</p><pre><code>echo number_format(123456.123456, 3); //123,456.123\n</code></pre><blockquote><p>大体就是这样了，关于number_format()函数的扩展阅读可以参照： <a href="http://www.w3school.com.cn/php/func_string_number_format.asp" rel="nofollow">http://www.w3school.com.cn/php/func_string_number_format.asp</a></p></blockquote>', '0');

-- --------------------------------------------------------

--
-- 表的结构 `blog_setting`
--

CREATE TABLE IF NOT EXISTS `blog_setting` (
  `key` tinytext NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `blog_user`
--

CREATE TABLE IF NOT EXISTS `blog_user` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `url` tinytext NOT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `aid` (`UID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `blog_user`
--

INSERT INTO `blog_user` (`UID`, `name`, `password`, `email`, `url`) VALUES
(1, 'admin', '1a1dc91c907325c69271ddf0c944bc72', 'i@tristana.cn', 'http://tristana.cn');

-- --------------------------------------------------------

--
-- 表的结构 `t`
--

CREATE TABLE IF NOT EXISTS `t` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `author` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`tid`),
  UNIQUE KEY `tid` (`tid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `t`
--

INSERT INTO `t` (`tid`, `date`, `author`, `email`, `content`) VALUES
(2, 1465101137, '爱你', 'i@tristana.cn', '后台地址：http://tristana.cn/t/index.php/Admin'),
(3, 1465113962, '小志志', 'boy404@163.com', '心情墙 你所写下的心愿终将实现'),
(4, 1465452603, '吴', 'i@tristana.cn', '没有哪个傻逼会提前这么久来车站等车，所以这里的大多数人不是和我同一车次的QAQ');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

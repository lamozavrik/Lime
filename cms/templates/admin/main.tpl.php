<!doctype HTML>
<html>
    <head>
        <title><?=_('Панель управления')?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <?php foreach(\core\View::styles() as $style): ?>
        <link rel="stylesheet" type="text/css" href="/cms/templates/admin/css/<?=$style ?>" />
        <?php endforeach; ?>
        <?php foreach(\core\View::javascript() as $js): ?>
        <script type="text/javascript" src="/cms/templates/admin/js/<?=$js ?>"></script>
        <?php endforeach; ?>
    </head>
    <body>
        <section id="wrapper">
            <header>
                <div class="header-bg"></div>
                <nav id="header-nav">
                    <div class="container">
                        <ul>
                            <li class="parent-active"><a href="#">Администрирование</a></li>
                            <li><a href="#">Статистика</a></li>
                            <li><a href="#">Статистика</a></li>
                            <li><a href="#">Статистика</a></li>
                        </ul>
                        <div class="clear"></div>
                    </div>
                </nav>
            </header>
            <section id="content">
                <div class="container">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
            </section>
            <footer>
                <div class="container">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
            </footer>
        </section>
        <?php foreach(\core\View::javascript(true) as $js): ?>
        <script type="text/javascript" src="/cms/templates/admin/js/<?=$js ?>"></script>
        <?php endforeach; ?>
    </body>
</html>
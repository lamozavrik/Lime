<!doctype HTML>
<html>
    <head>
        <title><?=_('Панель управления')?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <?php foreach(\core\View::styles() as $style): ?>
        <link rel="stylesheet" type="text/css" href="<?=url('cms/templates/admin/css') . '/' . $style ?>" />
        <?php endforeach; ?>
        <script type="text/javascript" src="<?=url('cms/media/js/jquery-1.11.3.min.js')?>"></script>
        <?php foreach(\core\View::javascript() as $js): ?>
        <script type="text/javascript" src="<?=url('cms/templates/admin/js') . '/' . $js ?>"></script>
        <?php endforeach; ?>
        <script type="text/javascript">
            $(function(){

                $('#nav li').has('ul').addClass('parent');

                var windiwVidth = $(window).outerWidth();
                if(windiwVidth <= 800){
                    $('#toggleMenu').on('click', function(){
                        $('#nav li').removeClass('hover');
                        $('#nav').toggle();
                        return false;
                    })

                    $('#nav a').on('click', function(){
                        var el = $(this).parent('li');
                        $('#nav li').not(el).not(el.parents()).removeClass('hover');
                        el.toggleClass('hover');

                        if(el.hasClass('parent'))
                            return false;
                    });

                } else {

                    $('#nav a').on('click', function(){
                        if($(this).parent('li').hasClass('parent'))
                            return false;
                    });

                    $('#nav li').hover(function(){
                        $(this).addClass('hover');
                    }, function(){
                        $(this).removeClass('hover');
                    });
                }
            });
        </script>
    </head>
    <body>
        <section id="wrapper">
            <header>
                <div class="header-bg"></div>
                <nav id="header-nav">
                    <div class="container">
                        <a href="#" id="toggleMenu">
                            <div class="toggleMenuItem"></div>
                        </a>
                        <ul id="nav">
                            <li>
                                <a href="#">Администрирование</a>
                                <ul>
                                    <li><a href="#">подпункт 1</a></li>
                                    <li><a href="#">подпункт 2</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Пункт 2</a></li>
                            <li>
                                <a href="#">Пункт 3</a>
                                <ul>
                                    <li><a href="#">подпункт 1</a></li>
                                    <li>
                                        <a href="#">подпункт 2</a>
                                        <ul>
                                            <li><a href="#">aaa</a></li>
                                            <li>
                                                <a href="#">bbb</a>
                                                <ul>
                                                    <li class="hover"><a href="#">под подпункт 1 подпункт 1</a></li>
                                                    <li><a href="#">под подпункт 2</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
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
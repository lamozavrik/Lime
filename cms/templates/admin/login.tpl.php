<!DOCTYPE html>
<html>
    <head>
        <title><?=_('Вход')?></title>
        <meta name="robots"  content="noindex, nofollow" />
        <style type="text/css">
        *{margin: 0; padding: 0;}

        body, html{
            background: #f7f7f7;
        }

        .admin-login-wr{

        }

        .admin-login-inner{
            max-width: 500px;
            width: 20%;
            border:1px solid #ccc;
            border-radius: 10px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            -o-border-radius: 10px;
            padding: 2%;
            background: #fff;
            height: 25%;
            position: absolute;
            top: 50%;
            margin: -12.5% 0 0 -10%;
            left: 50%;

            box-shadow: 0 0 10px -2px;
            -webkit-box-shadow: 0 0 10px -2px;
            -moz-box-shadow: 0 0 10px -2px;
            -o-box-shadow: 0 0 10px -2px;
        }

        .admin-login-inner input{
            width: 100%;
            padding: 2%;
            margin-left: -2%;
            border:1px solid #ccc;
            border-radius: 5px;
        }

        .login-field{
            margin-top: 3%;
        }

        .password-field{
            margin-top: 3%;
        }

        .title{
            font-size: 2em;
            text-align: center;
            color: #666;
        }

        .submit{
            width: 104%;
            padding: 3% 2%;
            margin-top: 3%;
            margin-left: -2%;
            background: #6EF927;
            background: linear-gradient(#6EF927, #50B51D);
            background: -webkit-linear-gradient(#6EF927, #50B51D);
            background: -moz-linear-gradient(#6EF927, #50B51D);
            background: -o-linear-gradient(#6EF927, #50B51D);
            background: gradient(linear, #6EF927, #50B51D);
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -o-border-radius: 5px;
            border: 1px solid #50B51D;

            font-size: 1em;
            color:#30730D;
        }

        .submit:hover{
            background: #6EF927;
            cursor: pointer;
        }

        .submit:active{
            border: 1px solid #429A15;
            background: #50B51D;
        }

        .logo{
            position: absolute;
            top:-40%;
            text-align: center;
            left:0;
        }

        .logo img{
            width: 30%;
            height: auto;
        } 
        </style>
    </head>
    <body>
        <div class="admin-login-wr">
            <div class="admin-login-inner">
                <div class="logo"><img src="/cms/templates/admin/images/logo.png"></div>
                <div class="title"><?=_('Панель администратора');?></div>
                <form method="post" action="<?=$this->post_url?>">
                        <div class="login-field"><input type="text" name="email" /></div>
                        <div class="password-field"><input type="password" name="password" /></div>
                        <button class="submit"><?=_('Войти')?></button>
                </form>
            </div>
        </div>
    </body>
</html>
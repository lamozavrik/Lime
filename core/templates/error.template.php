<!doctype HTML>
<html>
<head>
    <title>ОШИБКА!</title>
</head>
<body>
    <div><h1>ОШИБКА!</h1></div>
    <?php if($debug): ?>
    <div>Ошибка #: <?=$errno; ?> - <?=$errstr; ?></div>
    <div>Файл: <?=$errfile; ?></div>
    <div>Строка: <?=$errline; ?></div>
    <div>
        <p>Стэк вызовов:</p>
        <pre>
        <?php print_r($errcontext); ?>
        </pre>
    </div>
    <?php endif; ?>
</body>
</html>
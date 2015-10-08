<!doctype HTML>
<html>
<head>
    <title>ОШИБКА!</title>
</head>
<body>
    <div><h1>ОШИБКА!</h1></div>
    <?php if($debug): ?>
    <div>Ошибка: <?=$e->getMessage(); ?></div>
    <div>Файл: <?=$e->getFile(); ?></div>
    <div>Строка: <?=$e->getLine(); ?></div>
    <div>
        <p>Стэк вызовов:</p>
        <pre>
        <?php print_r(array_reverse($e->getTrace())); ?>
        </pre>
    </div>
    <?php endif; ?>
</body>
</html>
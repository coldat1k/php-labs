<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/classes/Article.php';
require_once __DIR__ . '/classes/FeaturedArticle.php';
require_once __DIR__ . '/classes/Blog.php';
require_once __DIR__ . '/lib/functions.php';

$blog = new Blog();

$blog->addArticle(new Article(
    'Вступ до системного програмування на C/C++',
    'Розгляд базових викликів Linux API, управління пам’яттю та ресурсами системними методами.',
    'Олександр',
    '2026-10-15'
));

$blog->addArticle(new FeaturedArticle(
    'Архітектура вебзастосунків на PHP та PostgreSQL',
    'Детальний аналіз проектування баз даних, паттернів MVC та зв’язки сервісного шару.',
    'Максим',
    '2026-10-22',
    'php_postgres_banner.png',
    1
));

$blog->addArticle(new Article(
    'Налаштування мережевих маршрутів у Cisco Packet Tracer',
    'Конфігурування протоколів OSPF, BGP, та маршрутизації між VLAN в навчальній мережі.',
    'Дмитро',
    '2026-10-18'
));

$blog->addArticle(new FeaturedArticle(
    'Оптимізація викликів WinAPI в Assembly',
    'Приклади використання низькорівневих регістрів, MASM64 та створення системних вікон.',
    'Юлія',
    '2026-10-25',
    'winapi_asm_banner.png',
    2
));

$recentArticles = $blog->listRecent();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Практична №3 — ООП у PHP (Варіант 3)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Управління статтями блогу (ООП)</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Тип</th>
                <th>Інформація (getInfo)</th>
                <th>Короткий зміст</th>
                <th>Slug (URL)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentArticles as $index => $article): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td>
                        <?php if ($article instanceof FeaturedArticle): ?>
                            <span class="badge badge-featured">Закріплена</span>
                        <?php else: ?>
                            <span class="badge badge-standard">Звичайна</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($article->getInfo()); ?></td>
                    <td>
                        <div class="custom-tooltip" data-tooltip="<?php echo htmlspecialchars($article->getContent()); ?>">
                            <?php echo htmlspecialchars(truncateText($article->getContent(), 45)); ?>
                        </div>
                    </td>
                    <td><span class="slug-code"><?php echo htmlspecialchars(makeSlug($article->getTitle())); ?></span></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
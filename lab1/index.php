<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$articles = [
    [
        'title'       => 'Вступ до системного програмування на C/C++',
        'author'      => 'Олександр',
        'publishedAt' => '2026-10-15',
        'views'       => 145
    ],
    [
        'title'       => 'Налаштування мережевих маршрутів у Cisco Packet Tracer',
        'author'      => 'Дмитро',
        'publishedAt' => '2026-10-18',
        'views'       => 82
    ],
    [
        'title'       => 'Архітектура вебзастосунків на PHP та PostgreSQL',
        'author'      => 'Максим',
        'publishedAt' => '2026-10-22',
        'views'       => 310
    ],
    [
        'title'       => 'Оптимізація викликів WinAPI в Assembly',
        'author'      => 'Юлія',
        'publishedAt' => '2026-10-25',
        'views'       => 45
    ],
    [
        'title'       => 'Контейнеризація застосунків за допомогою Docker',
        'author'      => 'Олександр',
        'publishedAt' => '2026-10-28',
        'views'       => 215
    ]
];

function formatArticle(array $article): string {
    return "«{$article['title']}» (Автор: {$article['author']}, Дата: {$article['publishedAt']})";
}

function getArticleStatus(int $views): string {
    if ($views > 100) {
        return 'Популярна';
    } else {
        return 'Звичайна';
    }
}

$totalViews = array_sum(array_column($articles, 'views'));
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Практична робота №1 — Блог / CMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Каталог статей блогу</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Опис статті</th>
                <th>Перегляди</th>
                <th>Статус</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $index => $article): ?>
                <?php 
                    $status = getArticleStatus($article['views']); 
                    $badgeClass = ($article['views'] > 100) ? 'badge-popular' : 'badge-regular';
                ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars(formatArticle($article)); ?></td>
                    <td><?php echo $article['views']; ?></td>
                    <td>
                        <span class="badge <?php echo $badgeClass; ?>">
                            <?php echo $status; ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="stats-card">
        <h3>Підсумкова статистика</h3>
        <p>Загальна кількість переглядів усіх статей: <strong><?php echo $totalViews; ?></strong></p>
    </div>
</div>

</body>
</html>
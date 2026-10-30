<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errors = [];
$successMessage = '';

$title = '';
$content = '';
$tags = '';

// Надійна функція підрахунку символів UTF-8 без mbstring
function getUtf8Length(string $string): int {
    if (function_exists('mb_strlen')) {
        return mb_strlen($string, 'UTF-8');
    }
    if (function_exists('grapheme_strlen')) {
        return grapheme_strlen($string);
    }
    return preg_match_all('/./u', $string, $matches);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $tags = trim($_POST['tags'] ?? '');

    $titleLength = getUtf8Length($title);
    $contentLength = getUtf8Length($content);

    if ($titleLength < 5 || $titleLength > 100) {
        $errors['title'] = 'Заголовок має бути від 5 до 100 символів.';
    }

    if ($contentLength < 20) {
        $errors['content'] = 'Текст має містити щонайменше 20 символів.';
    }

    if (empty($errors)) {
        $successMessage = 'Статтю успішно збережено!';
        $title = '';
        $content = '';
        $tags = '';
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Практична №2 — Додавання статті</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Додати нову статтю</h1>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <strong>Помилка валідації:</strong> Виправте вказані поля.
        </div>
    <?php endif; ?>

    <form id="articleForm" method="post" action="index.php" novalidate>
        <div class="form-group">
            <label for="title">Заголовок статті *</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                value="<?php echo htmlspecialchars($title); ?>" 
                required 
                minlength="5" 
                maxlength="100"
                class="<?php echo isset($errors['title']) ? 'input-error' : ''; ?>"
            >
            <span class="error-text" id="titleError">
                <?php echo $errors['title'] ?? ''; ?>
            </span>
        </div>

        <div class="form-group">
            <label for="content">Текст статті *</label>
            <textarea 
                id="content" 
                name="content" 
                rows="6" 
                required 
                minlength="20"
                class="<?php echo isset($errors['content']) ? 'input-error' : ''; ?>"
            ><?php echo htmlspecialchars($content); ?></textarea>
            <span class="error-text" id="contentError">
                <?php echo $errors['content'] ?? ''; ?>
            </span>
        </div>

        <div class="form-group">
            <label for="tags">Теги (через кому)</label>
            <input 
                type="text" 
                id="tags" 
                name="tags" 
                value="<?php echo htmlspecialchars($tags); ?>"
            >
        </div>

        <button type="submit" class="btn">Опублікувати статтю</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('articleForm');
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const tagsInput = document.getElementById('tags');

    const titleError = document.getElementById('titleError');
    const contentError = document.getElementById('contentError');

    const isSuccess = <?php echo json_encode(!empty($successMessage)); ?>;

    if (isSuccess) {
        localStorage.removeItem('draft_article');
    } else {
        const savedDraft = localStorage.getItem('draft_article');
        if (savedDraft) {
            try {
                const draft = JSON.parse(savedDraft);
                if (!titleInput.value && draft.title) titleInput.value = draft.title;
                if (!contentInput.value && draft.content) contentInput.value = draft.content;
                if (!tagsInput.value && draft.tags) tagsInput.value = draft.tags;
            } catch (e) {
                console.error('Помилка зчитування з localStorage:', e);
            }
        }
    }

    function saveToLocalStorage() {
        const draft = {
            title: titleInput.value,
            content: contentInput.value,
            tags: tagsInput.value
        };
        localStorage.setItem('draft_article', JSON.stringify(draft));
    }

    titleInput.addEventListener('input', saveToLocalStorage);
    contentInput.addEventListener('input', saveToLocalStorage);
    tagsInput.addEventListener('input', saveToLocalStorage);

    form.addEventListener('submit', (e) => {
        let hasError = false;

        titleError.textContent = '';
        contentError.textContent = '';
        titleInput.classList.remove('input-error');
        contentInput.classList.remove('input-error');

        const titleVal = titleInput.value.trim();
        if (titleVal.length < 5 || titleVal.length > 100) {
            titleError.textContent = 'Клієнтська валідація: заголовок має бути від 5 до 100 символів.';
            titleInput.classList.add('input-error');
            hasError = true;
        }

        const contentVal = contentInput.value.trim();
        if (contentVal.length < 20) {
            contentError.textContent = 'Клієнтська валідація: текст має містити щонайменше 20 символів.';
            contentInput.classList.add('input-error');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
        }
    });
});
</script>

</body>
</html>
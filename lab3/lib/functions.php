<?php

function makeSlug(string $title): string {
    $string = trim($title);
    
    $cyr = ['а','б','в','г','ґ','д','е','є','ж','з','и','і','ї','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ь','ю','я','А','Б','В','Г','Ґ','Д','Е','Є','Ж','З','И','І','Ї','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ь','Ю','Я',' '];
    $lat = ['a','b','v','h','g','d','e','ye','zh','z','y','i','yi','y','k','l','m','n','o','p','r','s','t','u','f','kh','ts','ch','sh','shch','','yu','ya','a','b','v','h','g','d','e','ye','zh','z','y','i','yi','y','k','l','m','n','o','p','r','s','t','u','f','kh','ts','ch','sh','shch','','yu','ya','-'];
    
    $slug = str_replace($cyr, $lat, $string);
    $slug = strtolower($slug);
    $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
    return preg_replace('/-+/', '-', $slug);
}

function truncateText(string $text, int $limit = 100): string {
    $cleanText = trim($text);
    
    // Безпечний підрахунок та обрізання UTF-8 без mbstring
    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($cleanText, 'UTF-8') <= $limit) {
            return $cleanText;
        }
        return mb_substr($cleanText, 0, $limit, 'UTF-8') . '...';
    }

    preg_match_all('/./u', $cleanText, $matches);
    $totalChars = count($matches[0]);

    if ($totalChars <= $limit) {
        return $cleanText;
    }

    return implode('', array_slice($matches[0], 0, $limit)) . '...';
}
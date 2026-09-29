<?php
function cookbook_validate_recipe_media(?array $upload): array
{
    if (!$upload || !isset($upload['name']) || !is_array($upload['name'])) {
        return [];
    }
    

    $files = [];
    foreach ($upload['name'] as $index => $name) {
        $error = $upload['error'][$index] ?? UPLOAD_ERR_NO_FILE;
        if ($error === UPLOAD_ERR_NO_FILE) {
            continue;
        }
        if ($error !== UPLOAD_ERR_OK) {
            throw new RuntimeException('One of the selected media files could not be uploaded.');
        }
        if (count($files) >= 10) {
            throw new RuntimeException('You can add up to 10 additional media files per recipe.');
        }

        $temporaryPath = $upload['tmp_name'][$index] ?? '';
        $size = (int) ($upload['size'][$index] ?? 0);
        if ($size <= 0 || $size > 20 * 1024 * 1024) {
            throw new RuntimeException('Each additional media file must be smaller than 20MB.');
        }

        $mimeType = (new finfo(FILEINFO_MIME_TYPE))->file($temporaryPath);
        $allowedTypes = [
            'image/jpeg' => ['jpg', 'image'],
            'image/png' => ['png', 'image'],
            'image/webp' => ['webp', 'image'],
            'video/mp4' => ['mp4', 'video'],
            'video/webm' => ['webm', 'video'],
            'video/quicktime' => ['mov', 'video'],
        ];
        if (!isset($allowedTypes[$mimeType])) {
            throw new RuntimeException('Use JPG, PNG, WebP, MP4, WebM, or MOV files.');
        }

        $files[] = [
            'temporary_path' => $temporaryPath,
            'extension' => $allowedTypes[$mimeType][0],
            'media_type' => $allowedTypes[$mimeType][1],
            'mime_type' => $mimeType,
        ];
    }

    return $files;
}

function cookbook_store_recipe_media(PDO $pdo, int $recipeId, array $files): void
{
    $directory = __DIR__ . '/../images/recipes/';
    if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
        throw new RuntimeException('Could not create the recipe media directory.');
    }

    $statement = $pdo->prepare(
        'INSERT INTO recipe_media (recipe_id, media_path, media_type, mime_type) VALUES (?, ?, ?, ?)'
    );
    foreach ($files as $file) {
        $fileName = bin2hex(random_bytes(16)) . '.' . $file['extension'];
        if (!move_uploaded_file($file['temporary_path'], $directory . $fileName)) {
            throw new RuntimeException('Could not save one of the recipe media files.');
        }

        $statement->execute([
            $recipeId,
            'recipes/' . $fileName,
            $file['media_type'],
            $file['mime_type'],
        ]);
    }
}
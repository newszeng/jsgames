<?php
header('Content-Type: application/json');

$type = $_GET['type'] ?? '';
$themes = [];

if ($type) {
    $theme_dir = "tpl/{$type}";
    if (is_dir($theme_dir)) {
        $dirs = scandir($theme_dir);
        foreach ($dirs as $dir) {
            if ($dir != '.' && $dir != '..' && is_dir($theme_dir . '/' . $dir)) {
                $readme_file = $theme_dir . '/' . $dir . '/readme.md';
                $description = 'No description available';
                if (file_exists($readme_file)) {
                    $description = file_get_contents($readme_file);
                    $description = str_replace("\n","<br>",$description);
                }
                $themes[] = [
                    'name' => $dir,
                    'description' => $description
                ];
            }
        }
    }
}

echo json_encode($themes);
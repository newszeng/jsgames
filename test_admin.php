<?php
echo "Admin test page works!<br>";
echo "Current directory: " . __DIR__ . "<br>";
echo "Admin directory exists: " . (is_dir('admin') ? 'Yes' : 'No') . "<br>";
echo "Admin index.php exists: " . (file_exists('admin/index.php') ? 'Yes' : 'No') . "<br>";

if (file_exists('admin/index.php')) {
    echo "<a href='admin/index.php'>Direct link to admin</a><br>";
}
?>
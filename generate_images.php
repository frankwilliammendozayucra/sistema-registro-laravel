<?php

$dir = 'E:/computacion/proyecto/tests_data';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

// Check if GD extension is loaded, or write binary PNG directly
if (!extension_loaded('gd')) {
    // Generate valid BMP / dummy PNG with valid PNG signature
    // Minimal valid 1x1 PNG:
    $pngHead = base64_decode("iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==");
    file_put_contents($dir . '/test_valid.png', $pngHead);
    
    // Create > 1MB file with valid PNG header
    $fp = fopen($dir . '/test_oversize.png', 'wb');
    fwrite($fp, $pngHead);
    // Pad with random data to 1.3 MB (1,363,148 bytes)
    $padding = str_repeat("A", 1363148);
    fwrite($fp, $padding);
    fclose($fp);
} else {
    $img = imagecreatetruecolor(200, 200);
    $bg = imagecolorallocate($img, 13, 110, 253);
    imagefill($img, 0, 0, $bg);
    imagepng($img, $dir . '/test_valid.png');
    imagedestroy($img);
    
    $big = imagecreatetruecolor(1500, 1500);
    imagepng($big, $dir . '/test_oversize.png', 0);
    imagedestroy($big);
}

echo "Valid image size: " . filesize($dir . '/test_valid.png') . " bytes\n";
echo "Oversize image size: " . filesize($dir . '/test_oversize.png') . " bytes\n";

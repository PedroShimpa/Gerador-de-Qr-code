<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QRGdImageJPEG;
use chillerlan\QRCode\Output\QRGdImagePNG;

$defaultUrl = 'https://www.google.com.br/';
$url = isset($_REQUEST['url']) && !empty(trim($_REQUEST['url'])) ? trim($_REQUEST['url']) : $defaultUrl;
$download = isset($_REQUEST['download']) && $_REQUEST['download'] === '1';
$format = isset($_REQUEST['format']) && strtolower($_REQUEST['format']) === 'png' ? 'png' : 'jpg';

// Parâmetros do QR Code
$eccLevel = EccLevel::H; // Alta tolerância a falhas para suportar logo sobreposto (30%)
$scale = 12;

$optionsArray = [
    'outputBase64'  => false,
    'scale'         => $scale,
    'quietzoneSize' => 2,
    'eccLevel'      => $eccLevel,
];

if ($format === 'png') {
    $optionsArray['outputInterface'] = QRGdImagePNG::class;
    $contentType = 'image/png';
    $extension = 'png';
} else {
    $optionsArray['outputInterface'] = QRGdImageJPEG::class;
    $optionsArray['quality'] = 95;
    $contentType = 'image/jpeg';
    $extension = 'jpg';
}

$options = new QROptions($optionsArray);
$qrcode = new QRCode($options);
$qrRawData = $qrcode->render($url);

// Carregar QR Code na GD
$qrImg = imagecreatefromstring($qrRawData);

// Processar logotipo enviado (se houver)
$logoFile = null;
if (isset($_FILES['logo']) && is_uploaded_file($_FILES['logo']['tmp_name'])) {
    $logoFile = $_FILES['logo']['tmp_name'];
} elseif (isset($_POST['logo_base64']) && !empty($_POST['logo_base64'])) {
    $base64 = $_POST['logo_base64'];
    if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
        $data = substr($base64, strpos($base64, ',') + 1);
        $decoded = base64_decode($data);
        if ($decoded !== false) {
            $tmpPath = tempnam(sys_get_temp_dir(), 'qr_logo_');
            file_put_contents($tmpPath, $decoded);
            $logoFile = $tmpPath;
        }
    }
}

if ($logoFile && file_exists($logoFile)) {
    $logoRaw = file_get_contents($logoFile);
    $logoImg = @imagecreatefromstring($logoRaw);

    if ($logoImg !== false) {
        $qrWidth = imagesx($qrImg);
        $qrHeight = imagesy($qrImg);
        $logoWidth = imagesx($logoImg);
        $logoHeight = imagesy($logoImg);

        // Logo ocupa aproximadamente 22% do tamanho do QR Code para manter leitura perfeita
        $targetLogoWidth = (int)($qrWidth * 0.22);
        $targetLogoHeight = (int)($logoHeight * ($targetLogoWidth / $logoWidth));

        $destX = (int)(($qrWidth - $targetLogoWidth) / 2);
        $destY = (int)(($qrHeight - $targetLogoHeight) / 2);

        // Desenhar fundo branco com borda suave atrás do logo para legibilidade dos módulos do QR
        $pad = 6;
        $white = imagecolorallocate($qrImg, 255, 255, 255);
        imagefilledrectangle(
            $qrImg,
            $destX - $pad,
            $destY - $pad,
            $destX + $targetLogoWidth + $pad,
            $destY + $targetLogoHeight + $pad,
            $white
        );

        // Mesclar o logo com transparência
        imagecopyresampled(
            $qrImg,
            $logoImg,
            $destX,
            $destY,
            0,
            0,
            $targetLogoWidth,
            $targetLogoHeight,
            $logoWidth,
            $logoHeight
        );

        imagedestroy($logoImg);
    }

    if (isset($tmpPath) && file_exists($tmpPath)) {
        @unlink($tmpPath);
    }
}

// Gerar saída em buffer
ob_start();
if ($format === 'png') {
    imagepng($qrImg);
} else {
    imagejpeg($qrImg, null, 95);
}
$finalData = ob_get_clean();
imagedestroy($qrImg);

// Headers HTTP
header('Content-Type: ' . $contentType);
if ($download) {
    header('Content-Disposition: attachment; filename="qrcode.' . $extension . '"');
} else {
    header('Content-Disposition: inline; filename="qrcode.' . $extension . '"');
}
header('Content-Length: ' . strlen($finalData));
header('Cache-Control: no-cache, no-store, must-revalidate');

echo $finalData;
exit;

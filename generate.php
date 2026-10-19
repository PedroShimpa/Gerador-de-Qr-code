<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QRMarkupSVG;
use chillerlan\QRCode\Output\QRGdImageJPEG;
use chillerlan\QRCode\Output\QRGdImagePNG;

$defaultUrl = 'https://www.google.com.br/';
$url = isset($_REQUEST['url']) && !empty(trim($_REQUEST['url'])) ? trim($_REQUEST['url']) : $defaultUrl;
$download = isset($_REQUEST['download']) && $_REQUEST['download'] === '1';
$format = isset($_REQUEST['format']) ? strtolower($_REQUEST['format']) : 'jpg';

$hasGD = extension_loaded('gd') && function_exists('imagecreatefromstring');

// Se o ambiente tem GD (como no XAMPP), gera JPG ou PNG rasterizado nativo
if ($hasGD) {
    $eccLevel = EccLevel::H;
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

            $targetLogoWidth = (int)($qrWidth * 0.22);
            $targetLogoHeight = (int)($logoHeight * ($targetLogoWidth / $logoWidth));

            $destX = (int)(($qrWidth - $targetLogoWidth) / 2);
            $destY = (int)(($qrHeight - $targetLogoHeight) / 2);

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

    ob_start();
    if ($format === 'png') {
        imagepng($qrImg);
    } else {
        imagejpeg($qrImg, null, 95);
    }
    $finalData = ob_get_clean();
    imagedestroy($qrImg);

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
}

// =========================================================================
// AMBIENTE SERVERLESS SEM EXT-GD (EX: VERCEL-PHP)
// Gera SVG puro nativo em PHP puro (100% autônomo, sem precisar de extensões C)
// =========================================================================
$options = new QROptions([
    'outputInterface' => QRMarkupSVG::class,
    'outputBase64'    => false,
    'quietzoneSize'   => 2,
    'eccLevel'        => EccLevel::H,
    'svgUseFillAttributes' => true,
]);

$qrcode = new QRCode($options);
$svgData = $qrcode->render($url);

// Se houver logo base64, embute no centro do SVG via <image> com fundo <rect>
$logoBase64 = null;
if (isset($_POST['logo_base64']) && !empty($_POST['logo_base64'])) {
    $logoBase64 = $_POST['logo_base64'];
} elseif (isset($_FILES['logo']) && is_uploaded_file($_FILES['logo']['tmp_name'])) {
    $mime = mime_content_type($_FILES['logo']['tmp_name']) ?: 'image/png';
    $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($_FILES['logo']['tmp_name']));
}

if ($logoBase64 && preg_match('/viewBox="0 0 (\d+) (\d+)"/', $svgData, $matches)) {
    $boxW = (float)$matches[1];
    $boxH = (float)$matches[2];
    $logoSize = $boxW * 0.24;
    $logoPos = ($boxW - $logoSize) / 2;
    $pad = $boxW * 0.02;

    $overlay = sprintf(
        '<rect x="%f" y="%f" width="%f" height="%f" fill="#ffffff" rx="%f"/>' .
        '<image href="%s" x="%f" y="%f" width="%f" height="%f" preserveAspectRatio="xMidYMid meet"/>',
        $logoPos - $pad, $logoPos - $pad, $logoSize + ($pad * 2), $logoSize + ($pad * 2), $pad,
        htmlspecialchars($logoBase64, ENT_QUOTES),
        $logoPos, $logoPos, $logoSize, $logoSize
    );

    $svgData = str_replace('</svg>', $overlay . '</svg>', $svgData);
}

// Headers HTTP para SVG
header('Content-Type: image/svg+xml');
if ($download) {
    header('Content-Disposition: attachment; filename="qrcode.svg"');
} else {
    header('Content-Disposition: inline; filename="qrcode.svg"');
}
header('Content-Length: ' . strlen($svgData));
header('Cache-Control: no-cache, no-store, must-revalidate');

echo $svgData;
exit;

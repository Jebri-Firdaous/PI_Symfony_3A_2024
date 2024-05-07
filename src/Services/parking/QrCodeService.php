<?php
namespace App\Services\parking;

use App\Entity\Place;
use App\Entity\Article;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Builder\BuilderInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class QrCodeService
{
    protected $builder;
    private $kernel;

    public function __construct(BuilderInterface $builder,KernelInterface $kernel)
    {
        $this->builder = $builder;
        $this->kernel = $kernel;
    }

    public function qrcode(Place $place)
    {
        // Chemin relatif depuis le répertoire public
        $path = 'parking/img/qrcode/';
        $destinationDir = $this->kernel->getProjectDir() . '/public/' . $path;

        // Vérifier si le répertoire de destination existe, sinon le créer
        if (!file_exists($destinationDir)) {
            mkdir($destinationDir, 0777, true); // Crée le répertoire avec les permissions 0777
        }

        // Build QR code
        $qrCode = $this->builder
            ->writer(new PngWriter())
            ->data($this->generateQrCodeData($place))
            // ->logoPath($path.'/logo1.png')
            // ->logoResizeToWidth('100')
            // ->logoResizeToHeight('100')
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->build();

        // Generate unique filename
        $namePng = uniqid($place->getRefPlace() . '_', '') . '.png';

        // Chemin complet du fichier de destination
        $filePath = $destinationDir . $namePng;
        // Enregistrer l'image QR code
        $qrCode->saveToFile($filePath);
        // Save QR code image

        $qrCode->saveToFile($path . $namePng);
        
        

        return $path . $namePng;
    }

    private function generateQrCodeData(Place $place)
    {
        // Customize QR code content based on article information
        $data = "Id place: {$place->getRefPlace()}\n";
        $data .= "num : {$place->getNumPlace()} DT\n";
        $data .= "Type: {$place->getTypePlace()}\n";
        $data .= "etat: {$place->getEtat()}\n";
        
        // Add more information as needed

        return $data;
    }
}
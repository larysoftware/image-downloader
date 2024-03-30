<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Dto;

use Lssoftware\ImageDownloader\Exception\ContentFileIsNotImage;
use Lssoftware\ImageDownloader\Exception\MimeTypeIsNotSupportedImage;
use Lssoftware\ImageDownloader\ValueObject\ImageContent;
use Lssoftware\ImageDownloader\ValueObject\ImageDimensions;
use Lssoftware\ImageDownloader\ValueObject\ImageExtension;
use Lssoftware\ImageDownloader\ValueObject\ImageSize;
use Psr\Http\Message\ResponseInterface;

use function getimagesizefromstring;

readonly class ImageResponse
{
    private const CONTENT_TYPE_HEADER = 'content-type';
    private const CONTENT_LENGTH_HEADER = 'content-length';

    private const MAP = [
        'image/aces' => 'exr',
        'image/apng' => 'apng',
        'image/astc' => 'astc',
        'image/avci' => 'avci',
        'image/avcs' => 'avcs',
        'image/avif' => 'avif',
        'image/avif-sequence' => 'avif',
        'image/bmp' => 'bmp',
        'image/cdr' => 'cdr',
        'image/cgm' => 'cgm',
        'image/dicom-rle' => 'drle',
        'image/emf' => 'emf',
        'image/fax-g3' => 'g3',
        'image/fits' => 'fits',
        'image/g3fax' => 'g3',
        'image/gif' => 'gif',
        'image/heic' => 'heic',
        'image/heic-sequence' => 'heics',
        'image/heif' => 'heif',
        'image/heif-sequence' => 'heifs',
        'image/hej2k' => 'hej2',
        'image/hsj2' => 'hsj2',
        'image/ico' => 'ico',
        'image/icon' => 'ico',
        'image/ief' => 'ief',
        'image/jls' => 'jls',
        'image/jp2' => 'jp2',
        'image/jpeg' => 'jpg',
        'image/jpeg2000' => 'jp2',
        'image/jpeg2000-image' => 'jp2',
        'image/jph' => 'jph',
        'image/jphc' => 'jhc',
        'image/jpm' => 'jpm',
        'image/jpx' => 'jpx',
        'image/jxl' => 'jxl',
        'image/jxr' => 'jxr',
        'image/jxra' => 'jxra',
        'image/jxrs' => 'jxrs',
        'image/jxs' => 'jxs',
        'image/jxsc' => 'jxsc',
        'image/jxsi' => 'jxsi',
        'image/jxss' => 'jxss',
        'image/ktx' => 'ktx',
        'image/ktx2' => 'ktx2',
        'image/openraster' => 'ora',
        'image/pdf' => 'pdf',
        'image/photoshop' => 'psd',
        'image/pjpeg' => 'jpg',
        'image/png' => 'png',
        'image/prs.btif' => 'btif',
        'image/prs.pti' => 'pti',
        'image/psd' => 'psd',
        'image/qoi' => 'qoi',
        'image/rle' => 'rle',
        'image/sgi' => 'sgi',
        'image/svg' => 'svg',
        'image/svg+xml' => 'svg',
        'image/svg+xml-compressed' => 'svgz',
        'image/t38' => 't38',
        'image/targa' => 'tga',
        'image/tga' => 'tga',
        'image/tiff' => 'tif',
        'image/tiff-fx' => 'tfx',
        'image/vnd.adobe.photoshop' => 'psd',
        'image/vnd.airzip.accelerator.azv' => 'azv',
        'image/vnd.dece.graphic' => 'uvi',
        'image/vnd.djvu' => 'djvu',
        'image/vnd.djvu+multipage' => 'djvu',
        'image/vnd.dvb.subtitle' => 'sub',
        'image/vnd.dwg' => 'dwg',
        'image/vnd.dxf' => 'dxf',
        'image/vnd.fastbidsheet' => 'fbs',
        'image/vnd.fpx' => 'fpx',
        'image/vnd.fst' => 'fst',
        'image/vnd.fujixerox.edmics-mmr' => 'mmr',
        'image/vnd.fujixerox.edmics-rlc' => 'rlc',
        'image/vnd.microsoft.icon' => 'ico',
        'image/vnd.mozilla.apng' => 'apng',
        'image/vnd.ms-dds' => 'dds',
        'image/vnd.ms-modi' => 'mdi',
        'image/vnd.ms-photo' => 'wdp',
        'image/vnd.net-fpx' => 'npx',
        'image/vnd.pco.b16' => 'b16',
        'image/vnd.rn-realpix' => 'rp',
        'image/vnd.tencent.tap' => 'tap',
        'image/vnd.valve.source.texture' => 'vtf',
        'image/vnd.wap.wbmp' => 'wbmp',
        'image/vnd.xiff' => 'xif',
        'image/vnd.zbrush.pcx' => 'pcx',
        'image/webp' => 'webp',
        'image/wmf' => 'wmf',
        'image/x-3ds' => '3ds',
        'image/x-adobe-dng' => 'dng',
        'image/x-applix-graphics' => 'ag',
        'image/x-bmp' => 'bmp',
        'image/x-bzeps' => 'eps.bz2',
        'image/x-canon-cr2' => 'cr2',
        'image/x-canon-cr3' => 'cr3',
        'image/x-canon-crw' => 'crw',
        'image/x-cdr' => 'cdr',
        'image/x-cmu-raster' => 'ras',
        'image/x-cmx' => 'cmx',
        'image/x-compressed-xcf' => 'xcf.gz',
        'image/x-dds' => 'dds',
        'image/x-djvu' => 'djvu',
        'image/x-emf' => 'emf',
        'image/x-eps' => 'eps',
        'image/x-exr' => 'exr',
        'image/x-fits' => 'fits',
        'image/x-freehand' => 'fh',
        'image/x-fuji-raf' => 'raf',
        'image/x-gimp-gbr' => 'gbr',
        'image/x-gimp-gih' => 'gih',
        'image/x-gimp-pat' => 'pat',
        'image/x-gzeps' => 'eps.gz',
        'image/x-icb' => 'tga',
        'image/x-icns' => 'icns',
        'image/x-ico' => 'ico',
        'image/x-icon' => 'ico',
        'image/x-iff' => 'iff',
        'image/x-ilbm' => 'iff',
        'image/x-jng' => 'jng',
        'image/x-jp2-codestream' => 'j2c',
        'image/x-jpeg2000-image' => 'jp2',
        'image/x-kodak-dcr' => 'dcr',
        'image/x-kodak-k25' => 'k25',
        'image/x-kodak-kdc' => 'kdc',
        'image/x-lwo' => 'lwo',
        'image/x-lws' => 'lws',
        'image/x-macpaint' => 'pntg',
        'image/x-minolta-mrw' => 'mrw',
        'image/x-mrsid-image' => 'sid',
        'image/x-ms-bmp' => 'bmp',
        'image/x-msod' => 'msod',
        'image/x-nikon-nef' => 'nef',
        'image/x-nikon-nrw' => 'nrw',
        'image/x-olympus-orf' => 'orf',
        'image/x-panasonic-raw' => 'raw',
        'image/x-panasonic-raw2' => 'rw2',
        'image/x-panasonic-rw' => 'raw',
        'image/x-panasonic-rw2' => 'rw2',
        'image/x-pcx' => 'pcx',
        'image/x-pentax-pef' => 'pef',
        'image/x-photo-cd' => 'pcd',
        'image/x-photoshop' => 'psd',
        'image/x-pict' => 'pic',
        'image/x-portable-anymap' => 'pnm',
        'image/x-portable-bitmap' => 'pbm',
        'image/x-portable-graymap' => 'pgm',
        'image/x-portable-pixmap' => 'ppm',
        'image/x-psd' => 'psd',
        'image/x-quicktime' => 'qtif',
        'image/x-rgb' => 'rgb',
        'image/x-sgi' => 'sgi',
        'image/x-sigma-x3f' => 'x3f',
        'image/x-skencil' => 'sk',
        'image/x-sony-arw' => 'arw',
        'image/x-sony-sr2' => 'sr2',
        'image/x-sony-srf' => 'srf',
        'image/x-sun-raster' => 'sun',
        'image/x-targa' => 'tga',
        'image/x-tga' => 'tga',
        'image/x-win-bitmap' => 'cur',
        'image/x-win-metafile' => 'wmf',
        'image/x-wmf' => 'wmf',
        'image/x-xbitmap' => 'xbm',
        'image/x-xcf' => 'xcf',
        'image/x-xfig' => 'fig',
        'image/x-xpixmap' => 'xpm',
        'image/x-xpm' => 'xpm',
        'image/x-xwindowdump' => 'xwd',
        'image/x.djvu' => 'djvu',
    ];

    public function __construct(private ResponseInterface $response)
    {
    }


    public function getImageContent(): ImageContent
    {
        return new ImageContent($this->response->getBody()->getContents());
    }

    public function getImageDimensions(): ImageDimensions
    {
        $imageData = getimagesizefromstring($this->getImageContent()->value);
        if ($imageData === false) {
            throw new ContentFileIsNotImage();
        }
        return new ImageDimensions((int)$imageData[0], (int)$imageData[1]);
    }

    public function getFilesize(): ImageSize
    {
        return new ImageSize((int)$this->response->getHeaders()[self::CONTENT_LENGTH_HEADER][0] ?? 0);
    }

    public function getContentType(): string
    {
        return $this->response->getHeaders()[self::CONTENT_TYPE_HEADER][0] ?? '';
    }

    /**
     * @throws MimeTypeIsNotSupportedImage
     */
    public function getExtension(): ImageExtension
    {
        return new ImageExtension(self::MAP[$this->getContentType()] ?? throw new MimeTypeIsNotSupportedImage());
    }
}
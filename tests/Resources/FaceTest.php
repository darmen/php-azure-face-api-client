<?php

namespace Darmen\AzureFace\Tests\Resources;

use BlastCloud\Guzzler\UsesGuzzler;
use Darmen\AzureFace\Resources\Face;

class FaceTest extends BaseTestCase
{
    use UsesGuzzler;

    /**
     * @var Face
     */
    private $sut;

    public function setUp(): void
    {
        $this->sut = new Face($this->guzzler->getClient());
    }

    public function testDetectWithStreamWithDefaultParameters(): void
    {
        $fp = fopen('php://memory', 'r+');

        $this->guzzler
            ->expects($this->once())
            ->post('detect')
            ->withHeader('Content-Type', 'application/octet-stream')
            ->withQuery([
                'detectionModel' => 'detection_01',
                'faceIdTimeToLive' => 86400,
                'recognitionModel' => 'recognition_01',
                'returnFaceAttributes' => '',
                'returnFaceId' => true,
                'returnFaceLandmarks' => false,
                'returnRecognitionModel' => false
            ], true)
            ->withBody(stream_get_contents($fp), true)
            ->willRespond($this->emptyJsonResponse());

        $this->sut->detectWithStream($fp);
    }

    public function testDetectWithStreamWithNonDefaultParameters(): void
    {
        $fp = fopen('php://memory', 'r+');

        $this->guzzler
            ->expects($this->once())
            ->post('detect')
            ->withHeader('Content-Type', 'application/octet-stream')
            ->withQuery([
                'detectionModel' => 'any_detection_model',
                'faceIdTimeToLive' => 1,
                'recognitionModel' => 'any_recognition_model',
                'returnFaceAttributes' => 'any_attribute',
                'returnFaceId' => false,
                'returnFaceLandmarks' => true,
                'returnRecognitionModel' => true
            ], true)
            ->withBody(stream_get_contents($fp), true)
            ->willRespond($this->emptyJsonResponse());

        $this->sut->detectWithStream($fp, 'any_detection_model', 1, 'any_recognition_model', 'any_attribute', false, true, true);
    }

    public function testDetectWithUrlWithDefaultParameters(): void
    {
        $this->guzzler
            ->expects($this->once())
            ->post('detect')
            ->withHeader('Content-Type', 'application/json')
            ->withQuery([
                'detectionModel' => 'detection_01',
                'faceIdTimeToLive' => 86400,
                'recognitionModel' => 'recognition_01',
                'returnFaceAttributes' => '',
                'returnFaceId' => true,
                'returnFaceLandmarks' => false,
                'returnRecognitionModel' => false
            ], true)
            ->withJson([
                'url' => 'any_url'
            ])
            ->willRespond($this->emptyJsonResponse());

        $this->sut->detectWithUrl('any_url');
    }

    public function testDetectWithUrlWithNonDefaultParameters(): void
    {
        $this->guzzler
            ->expects($this->once())
            ->post('detect')
            ->withHeader('Content-Type', 'application/json')
            ->withQuery([
                'detectionModel' => 'any_detection_model',
                'faceIdTimeToLive' => 1,
                'recognitionModel' => 'any_recognition_model',
                'returnFaceAttributes' => 'any_attribute',
                'returnFaceId' => false,
                'returnFaceLandmarks' => true,
                'returnRecognitionModel' => true
            ], true)
            ->withJson([
                'url' => 'any_url'
            ])
            ->willRespond($this->emptyJsonResponse());

        $this->sut->detectWithUrl('any_url', 'any_detection_model', 1, 'any_recognition_model', 'any_attribute', false, true, true);
    }
}

<?php

namespace Darmen\AzureFace\Tests\Resources;

use BlastCloud\Guzzler\UsesGuzzler;
use Darmen\AzureFace\Resources\FaceList;
use GuzzleHttp\Exception\GuzzleException;

class FaceListTest extends BaseTestCase
{
    use UsesGuzzler;

    private const FACE_LIST_ID = 'any_face_list_id';
    private const PERSISTED_FACE_ID = 'any_persisted_face_id';
    private const URI = 'facelists';

    /** @var FaceList */
    private $sut;

    public function dataProviderForAll(): array
    {
        return [
            'start is null' => [
                'start' => null,
                'top' => 1000,
                'returnRecognitionModel' => true,
                'expectedQuery' => [
                    'returnRecognitionModel' => true,
                    'top' => 1000,
                ]
            ],

            'start is provided' => [
                'start' => 'any_face_id',
                'top' => 1000,
                'returnRecognitionModel' => true,
                'expectedQuery' => [
                    'start' => 'any_face_id',
                    'returnRecognitionModel' => true,
                    'top' => 1000,
                ]
            ],

            'recognitionModel is false' => [
                'start' => 'any_face_id',
                'top' => 1000,
                'returnRecognitionModel' => false,
                'expectedQuery' => [
                    'start' => 'any_face_id',
                    'returnRecognitionModel' => false,
                    'top' => 1000,
                ]
            ],
        ];
    }

    public function dataProviderForAddFaceFromStream()
    {
        return [
            'userData is null' => [
                'userData' => null,
                'targetFace' => 'any_target_face',
                'detectionModel' => 'any_detection_model',
                'expectedQuery' => [
                    'targetFace' => 'any_target_face',
                    'detectionModel' => 'any_detection_model',
                ]
            ],

            'targetFace is null' => [
                'userData' => 'any_user_data',
                'targetFace' => null,
                'detectionModel' => 'any_detection_model',
                'expectedQuery' => [
                    'userData' => 'any_user_data',
                    'detectionModel' => 'any_detection_model',
                ]
            ],

            'detectionModel is null' => [
                'userData' => 'any_user_data',
                'targetFace' => 'any_target_face',
                'detectionModel' => null,
                'expectedQuery' => [
                    'userData' => 'any_user_data',
                    'targetFace' => 'any_target_face',
                ]
            ],
        ];
    }

    public function dataProviderForAddFaceFromUrl()
    {
        return [
            'userData is null' => [
                'userData' => null,
                'targetFace' => 'any_target_face',
                'detectionModel' => 'any_detection_model',
                'expectedQuery' => [
                    'targetFace' => 'any_target_face',
                    'detectionModel' => 'any_detection_model',
                ]
            ],

            'targetFace is null' => [
                'userData' => 'any_user_data',
                'targetFace' => null,
                'detectionModel' => 'any_detection_model',
                'expectedQuery' => [
                    'userData' => 'any_user_data',
                    'detectionModel' => 'any_detection_model',
                ]
            ],

            'detectionModel is null' => [
                'userData' => 'any_user_data',
                'targetFace' => 'any_target_face',
                'detectionModel' => null,
                'expectedQuery' => [
                    'userData' => 'any_user_data',
                    'targetFace' => 'any_target_face',
                ]
            ],
        ];
    }

    public function setUp(): void
    {
        $this->sut = new FaceList($this->guzzler->getClient());
    }

    /**
     * @dataProvider dataProviderForAddFaceFromUrl
     * @throws GuzzleException
     */
    public function testAddFaceFromUrl(string $userData = null, string $targetFace = null, string $detectionModel = null, array $expectedQuery)
    {
        $this->guzzler
            ->expects($this->once())
            ->post(self::URI . '/' . self::FACE_LIST_ID . '/persistedfaces')
            ->withQuery($expectedQuery, true)
            ->withJson(['url' => 'https://example.org/image.jpg'])
            ->willRespond($this->emptyResponse());

        $this->sut->addFaceFromUrl(self::FACE_LIST_ID, 'https://example.org/image.jpg', $userData, $targetFace, $detectionModel);
    }

    /**
     * @dataProvider dataProviderForAll
     * @throws GuzzleException
     */
    public function testAll($start, int $top, bool $returnRecognitionModel, array $expectedQuery)
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::URI)
            ->withQuery($expectedQuery, true)
            ->willRespond(
                $this->emptyJsonResponse()
            );

        $this->sut->all($start, $top, $returnRecognitionModel);
    }

    /**
     * @dataProvider dataProviderForGet
     * @throws GuzzleException
     */
    public function testGet(bool $returnRecognitionModel, array $expectedQuery)
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::URI . '/' . self::FACE_LIST_ID)
            ->withQuery($expectedQuery, true)
            ->willRespond($this->emptyJsonResponse());

        $this->sut->get(self::FACE_LIST_ID, $returnRecognitionModel);
    }

    /**
     * @dataProvider dataProviderForUpdate
     * @throws GuzzleException
     */
    public function testUpdate(string $name, string $userData = null, $expectedJson)
    {
        $this->guzzler
            ->expects($this->once())
            ->patch(self::URI . '/' . self::FACE_LIST_ID)
            ->willRespond($this->emptyResponse());

        $this->sut->update(self::FACE_LIST_ID, $name, $userData);
    }

    public function testDeleteFace()
    {
        $this->guzzler
            ->expects($this->once())
            ->delete(self::URI . '/' . self::FACE_LIST_ID . '/persistedfaces/' . self::PERSISTED_FACE_ID)
            ->willRespond($this->emptyResponse());

        $this->sut->deleteFace(self::FACE_LIST_ID, self::PERSISTED_FACE_ID);
    }

    public function testDelete()
    {
        $this->guzzler
            ->expects($this->once())
            ->delete(self::URI . '/' . self::FACE_LIST_ID)
            ->willRespond($this->emptyResponse());

        $this->sut->delete(self::FACE_LIST_ID);
    }

    /**
     * @dataProvider dataProviderForAddFaceFromStream
     */
    public function testAddFaceFromStream(string $userData = null, string $targetFace = null, string $detectionModel = null, array $expectedQuery)
    {
        $resource = $this->emptyResource();

        $this->guzzler
            ->expects($this->once())
            ->post(self::URI . '/' . self::FACE_LIST_ID . '/persistedfaces')
            ->withHeader('Content-Type', 'application/octet-stream')
            ->withQuery($expectedQuery, true)
            ->withBody(stream_get_contents($resource), true)
            ->willRespond($this->emptyResponse());

        $this->sut->addFaceFromStream(self::FACE_LIST_ID, $resource, $userData, $targetFace, $detectionModel);

        fclose($resource);
    }


    /**
     * @dataProvider dataProviderForCreate
     * @throws GuzzleException
     */
    public function testCreate(string $name, string $recognitionModel = null, string $userData = null, $expectedJson)
    {
        $this->guzzler
            ->expects($this->once())
            ->put(self::URI . '/' . self::FACE_LIST_ID)
            ->withJson($expectedJson)
            ->willRespond($this->emptyResponse());

        $this->sut->create(self::FACE_LIST_ID, $name, $recognitionModel, $userData);
    }

    public function dataProviderForCreate(): array
    {
        return [
            'all parameters are provided' => [
                'name' => 'any_name',
                'recognitionModel' => 'any_recognition_model',
                'userData' => 'any_user_data',
                'expectedJson' => [
                    'name' => 'any_name',
                    'userData' => 'any_user_data',
                    'recognitionModel' => 'any_recognition_model',
                ],
            ],

            'recognitionModel is set to null' => [
                'name' => 'any_name',
                'recognitionModel' => null,
                'userData' => 'any_user_data',
                'expectedJson' => [
                    'name' => 'any_name',
                    'userData' => 'any_user_data',
                ],
            ],

            'userData is set to null' => [
                'name' => 'any_name',
                'recognitionModel' => 'any_recognition_model',
                'userData' => null,
                'expectedJson' => [
                    'name' => 'any_name',
                    'recognitionModel' => 'any_recognition_model',
                ],
            ],

            'all optional parameters are set to null' => [
                'name' => 'any_name',
                'recognitionModel' => null,
                'userData' => null,
                'expectedJson' => [
                    'name' => 'any_name',
                ],
            ]
        ];
    }

    public function dataProviderForUpdate(): array
    {
        return [
            'all parameters are provided' => [
                'name' => 'any_name',
                'userData' => 'any_user_data',
                'expectedJson' => [
                    'name' => 'any_name',
                    'userData' => 'any_user_data',
                ],
            ],

            'userData is set to null' => [
                'name' => 'any_name',
                'userData' => null,
                'expectedJson' => [
                    'name' => 'any_name',
                ],
            ],
        ];
    }

    public function dataProviderForGet(): array
    {
        return [
            'returnRecognitionModel is set to true' => [
                'returnRecognitionModel' => true,
                'expectedQuery' => [
                    'returnRecognitionModel' => true,
                ],
            ],

            'returnRecognitionModel is set to false' => [
                'returnRecognitionModel' => false,
                'expectedQuery' => [
                    'returnRecognitionModel' => false,
                ],
            ],
        ];
    }
}

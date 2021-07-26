<?php

namespace Darmen\AzureFace\Tests\Resources;

use BlastCloud\Guzzler\UsesGuzzler;
use Darmen\AzureFace\Resources\LargeFaceList;

class LargeFaceListTest extends BaseTestCase
{
    use UsesGuzzler;

    private const FACE_LIST_ID = 'any_face_list_id';
    private const PERSISTED_FACE_ID = 'any_persisted_face_id';
    private const URI = 'largefacelists';

    /** @var LargeFaceList */
    private $sut;

    public function setUp(): void
    {
        $this->sut = new LargeFaceList($this->guzzler->getClient());
    }

    public function testUpdateFace()
    {
        $this->guzzler
            ->expects($this->once())
            ->patch(self::URI . '/' . self::FACE_LIST_ID . '/persistedfaces/' . self::PERSISTED_FACE_ID)
            ->withJson(['userData' => 'any_user_data'], true)
            ->willRespond($this->emptyResponse());

        $this->sut->updateFace(self::FACE_LIST_ID, self::PERSISTED_FACE_ID, 'any_user_data');
    }

    public function testGetFace()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::URI . '/' . self::FACE_LIST_ID . '/persistedfaces/' . self::PERSISTED_FACE_ID)
            ->willRespond($this->emptyJsonResponse());

        $this->sut->getFace(self::FACE_LIST_ID, self::PERSISTED_FACE_ID);
    }

    public function testTrain()
    {
        $this->guzzler
            ->expects($this->once())
            ->post(self::URI . '/' . self::FACE_LIST_ID . '/train')
            ->willRespond($this->emptyResponse());

        $this->sut->train(self::FACE_LIST_ID);
    }

    /**
     * @dataProvider dataProviderForListFaces
     */
    public function testListFaces(string $start = null, int $top, array $expectedQuery)
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::URI . '/' . self::FACE_LIST_ID . '/persistedfaces')
            ->withQuery($expectedQuery, true)
            ->willRespond($this->emptyJsonResponse());

        $this->sut->listFaces(self::FACE_LIST_ID, $start, $top);
    }

    public function dataProviderForListFaces(): array
    {
        return [
            'start is null' => [
                'start' => null,
                'top' => 1000,
                'expectedQuery' => [
                    'top' => 1000,
                ]
            ],

            'start is provided' => [
                'start' => 'any_face_id',
                'top' => 1000,
                'expectedQuery' => [
                    'start' => 'any_face_id',
                    'top' => 1000,
                ]
            ],
        ];
    }

    public function testGetTrainingStatus()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::URI . '/' . self::FACE_LIST_ID . '/training')
            ->willRespond($this->emptyJsonResponse());

        $this->sut->getTrainingStatus(self::FACE_LIST_ID);
    }
}

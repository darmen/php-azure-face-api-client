<?php

namespace Darmen\AzureFace\Resources;

use Darmen\AzureFace\Exceptions\ApiErrorException;
use GuzzleHttp\Exception\GuzzleException;

/**
 * FaceList resource.
 *
 * @see https://docs.microsoft.com/en-us/rest/api/faceapi/face-list
 */
class FaceList extends Resource
{
    protected const URI = 'facelists';

    /**
     * Add a face from stream to a specified face list.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/face-list/add-face-from-stream
     * @param string $faceListId Id referencing a particular face list
     * @param resource $image A resource containing the image
     * @param string|null $userData User-specified data about the face for any purpose
     * @param string|null $targetFace A face rectangle to specify the target face to be added to a person in the format of "targetFace=left,top,width,height"
     * @param string|null $detectionModel Name of detection model
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function addFaceFromStream(string $faceListId, $image, string $userData = null, string $targetFace = null, string $detectionModel = null): void
    {
        $parameters = [];

        if ($userData !== null) {
            $parameters['userData'] = $userData;
        }

        if ($targetFace !== null) {
            $parameters['targetFace'] = $targetFace;
        }

        if ($detectionModel !== null) {
            $parameters['detectionModel'] = $detectionModel;
        }

        $this->httpClient->post($this->getUri() . "/$faceListId/persistedfaces?" . http_build_query($parameters), [
            'headers' => [
                'Content-Type' => 'application/octet-stream'
            ],

            'body' => stream_get_contents($image),
        ]);
    }

    protected function getUri(): string
    {
        return self::URI;
    }

    /**
     * Add a face from URL to a specified face list.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/face-list/add-face-from-url
     * @param string $faceListId Id referencing a particular face list
     * @param string $url URL to an image
     * @param string|null $userData User-specified data about the face for any purpose
     * @param string|null $targetFace A face rectangle to specify the target face to be added to a person in the format of "targetFace=left,top,width,height"
     * @param string|null $detectionModel Name of detection model
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function addFaceFromUrl(string $faceListId, string $url, string $userData = null, string $targetFace = null, string $detectionModel = null): void
    {
        $parameters = [];

        if ($userData !== null) {
            $parameters['userData'] = $userData;
        }

        if ($targetFace !== null) {
            $parameters['targetFace'] = $targetFace;
        }

        if ($detectionModel !== null) {
            $parameters['detectionModel'] = $detectionModel;
        }

        $this->httpClient->post($this->getUri() . "/$faceListId/persistedfaces?" . http_build_query($parameters), [
            'json' => [
                'url' => $url
            ]
        ]);
    }

    /**
     * Create an empty face list.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/face-list/create
     * @param string $faceListId Id referencing a particular face list
     * @param string $name User defined name
     * @param string|null $recognitionModel Name of recognition model
     * @param string|null $userData User specified data
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function create(string $faceListId, string $name, string $recognitionModel = null, string $userData = null): void
    {
        $body = [
            'name' => $name,
        ];

        if ($recognitionModel !== null) {
            $body['recognitionModel'] = $recognitionModel;
        }

        if ($userData !== null) {
            $body['userData'] = $userData;
        }

        $this->httpClient->put($this->getUri() . "/$faceListId", [
            'json' => $body
        ]);
    }

    /**
     * Delete a specified face list.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/face-list/delete
     * @param string $faceListId Id referencing a particular face list
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function delete(string $faceListId): void
    {
        $this->httpClient->delete($this->getUri() . "/$faceListId");
    }

    /**
     * Delete a face from a face list by specified faceListId and persistedFaceId.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/face-list/delete-face
     * @param string $faceListId Id referencing a particular face list
     * @param string $persistedFaceId Id referencing a particular persistedFaceId of an existing face
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function deleteFace(string $faceListId, string $persistedFaceId): void
    {
        $this->httpClient->delete($this->getUri() . "/$faceListId/persistedfaces/$persistedFaceId");
    }

    /**
     * Retrieve a face list’s faceListId, name, userData and recognitionModel.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/face-list/get
     * @param string $faceListId Id referencing a particular face list
     * @param bool $returnRecognitionModel Return 'recognitionModel' or not. Default is false.
     * @return array
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function get(string $faceListId, bool $returnRecognitionModel = false): array
    {
        return $this->decodeJsonResponse(
            $this->httpClient->get($this->getUri() . "/$faceListId?returnRecognitionModel=$returnRecognitionModel")
        );
    }

    /**
     * List face lists’ information of faceListId, name, userData and recognitionModel.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/face-list/list
     * @param string|null $start List face lists from the least faceListId greater than the "start". Default is null
     * @param int|null $top The number of face lists to list, ranging in [1, 1000]. Default is 1000.
     * @param bool|null $returnRecognitionModel Return 'recognitionModel' or not. Default is false.
     * @return array
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function all(string $start = null, int $top = 1000, bool $returnRecognitionModel = false): array
    {
        $parameters = [
            'top' => $top,
            'returnRecognitionModel' => $returnRecognitionModel
        ];

        if ($start !== null) {
            $parameters['start'] = $start;
        }

        return $this->decodeJsonResponse(
            $this->httpClient->get($this->getUri() . "?" . http_build_query($parameters))
        );
    }

    /**
     * Update information of a face list.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/face-list/update
     * @param string $faceListId Id referencing a particular face list
     * @param string $name User defined name
     * @param string|null $userData User specified data
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function update(string $faceListId, string $name, string $userData = null): void
    {
        $body = [
            'name' => $name,
        ];

        if ($userData !== null) {
            $body['userData'] = $userData;
        }

        $this->httpClient->patch($this->getUri() . "/$faceListId", [
            'json' => $body
        ]);
    }
}

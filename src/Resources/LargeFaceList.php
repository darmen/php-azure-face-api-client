<?php

namespace Darmen\AzureFace\Resources;

use Darmen\AzureFace\Exceptions\ApiErrorException;
use GuzzleHttp\Exception\GuzzleException;

/**
 * LargeFaceList resource.
 *
 * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list
 */
class LargeFaceList extends Resource
{
    protected const URI = 'largefacelists';

    /**
     * Create an empty large face list.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/create
     * @param string $largeFaceListId Id referencing a particular large face list
     * @param string $name User defined name
     * @param string|null $recognitionModel Name of recognition model
     * @param string|null $userData User specified data
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function create(string $largeFaceListId, string $name, string $recognitionModel = null, string $userData = null): void
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

        $this->httpClient->put($this->getUri() . "/$largeFaceListId", [
            'json' => $body
        ]);
    }

    protected function getUri(): string
    {
        return self::URI;
    }

    /**
     * Update information of a large face list.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/update
     * @param string $largeFaceListId Id referencing a particular large face list
     * @param string $name User defined name
     * @param string|null $userData User specified data
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function update(string $largeFaceListId, string $name, string $userData = null): void
    {
        $body = [
            'name' => $name,
        ];

        if ($userData !== null) {
            $body['userData'] = $userData;
        }

        $this->httpClient->patch($this->getUri() . "/$largeFaceListId", [
            'json' => $body
        ]);
    }

    /**
     * Update a persisted face's userData field.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/update
     * @param string $largeFaceListId Id referencing a particular large face list
     * @param string $persistedFaceId Id referencing a particular persistedFaceId of an existing face
     * @param string $userData User-provided data attached to the face
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function updateFace(string $largeFaceListId, string $persistedFaceId, string $userData): void
    {;
        $this->httpClient->patch($this->getUri() . "/$largeFaceListId/persistedfaces/$persistedFaceId", [
            'json' => [
                'userData' => $userData,
            ]
        ]);
    }

    /**
     * Retrieve information about a persisted face (specified by persistedFaceId and its belonging largeFaceListId).
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/update
     * @param string $largeFaceListId Id referencing a particular large face list
     * @param string $persistedFaceId Id referencing a particular persistedFaceId of an existing face
     * @return array
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function getFace(string $largeFaceListId, string $persistedFaceId): array
    {;
        return $this->decodeJsonResponse(
            $this->httpClient->get($this->getUri() . "/$largeFaceListId/persistedfaces/$persistedFaceId")
        );
    }

    /**
     * List large face lists’ information of largeFaceListId, name, userData and recognitionModel.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/list
     * @param int|null $start List large face lists from the least largeFaceListId greater than the "start". Default is null
     * @param int|null $top The number of large face lists to list, ranging in [1, 1000]. Default is 1000.
     * @param bool|null $returnRecognitionModel Return 'recognitionModel' or not. Default is false.
     * @return array
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function all(int $start = null, int $top = 1000, bool $returnRecognitionModel = false): array
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
     * List all faces in a large face list, and retrieve face information (including userData and persistedFaceIds of registered faces of the face).
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/list-faces
     *
     * @param string $largeFaceListId Id referencing a particular large face list
     * @param int|null $start Starting face id to return (used to list a range of faces
     * @param int|null $top Number of faces to return starting with the face id indicated by the 'start' parameter
     * @return array
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function listFaces(string $largeFaceListId, int $start = null, int $top = 1000): array
    {
        $parameters = [
            'top' => $top,
        ];

        if ($start !== null) {
            $parameters['start'] = $start;
        }

        return $this->decodeJsonResponse(
            $this->httpClient->get($this->getUri() . "/$largeFaceListId/persistedfaces?" . http_build_query($parameters))
        );
    }


    /**
     * Delete a specified large face list.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/delete
     * @param string $largeFaceListId Id referencing a particular large face list
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function delete(string $largeFaceListId): void
    {
        $this->httpClient->delete($this->getUri() . "/$largeFaceListId");
    }

    /**
     * Delete a face from a large face list by specified largeFaceListId and persistedFaceId.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/delete-face
     * @param string $largeFaceListId Id referencing a particular large face list
     * @param string $persistedFaceId Id referencing a particular persistedFaceId of an existing face
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function deleteFace(string $largeFaceListId, string $persistedFaceId): void
    {
        $this->httpClient->delete($this->getUri() . "/$largeFaceListId/persistedfaces/$persistedFaceId");
    }


    /**
     * Delete a specified large face list.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/train
     * @param string $largeFaceListId Id referencing a particular large face list
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function train(string $largeFaceListId): void
    {
        $this->httpClient->post($this->getUri() . "/$largeFaceListId/train");
    }

    /**
     * Retrieve the training status of a large face list (completed or ongoing).
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/get-training-status
     * @param string $largeFaceListId Id referencing a particular large face list
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function getTrainingStatus(string $largeFaceListId): array
    {
        return $this->decodeJsonResponse(
            $this->httpClient->get($this->getUri() . "/$largeFaceListId/training")
        );
    }

    /**
     * Retrieve a large face list’s largeFaceListId, name, userData and recognitionModel.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/get
     * @param string $largeFaceListId Id referencing a particular large face list
     * @param bool $returnRecognitionModel Return 'recognitionModel' or not. Default is false.
     * @return array
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function get(string $largeFaceListId, bool $returnRecognitionModel = false): array
    {
        return $this->decodeJsonResponse(
            $this->httpClient->get($this->getUri() . "/$largeFaceListId?returnRecognitionModel=$returnRecognitionModel")
        );
    }

}

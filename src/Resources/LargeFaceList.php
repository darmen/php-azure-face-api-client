<?php

namespace Darmen\AzureFace\Resources;

use Darmen\AzureFace\Exceptions\ApiErrorException;
use GuzzleHttp\Exception\GuzzleException;

/**
 * LargeFaceList resource.
 *
 * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list
 */
class LargeFaceList extends FaceList
{
    protected const URI = 'largefacelists';

    protected function getUri(): string
    {
        return self::URI;
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
    {
        $this->httpClient->patch($this->getUri() . "/$largeFaceListId/persistedfaces/$persistedFaceId", [
            'json' => [
                'userData' => $userData,
            ]
        ]);
    }

    /**
     * Retrieve information about a persisted face (specified by persistedFaceId and its belonging largeFaceListId).
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/get-face
     * @param string $largeFaceListId Id referencing a particular large face list
     * @param string $persistedFaceId Id referencing a particular persistedFaceId of an existing face
     * @return array
     *
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function getFace(string $largeFaceListId, string $persistedFaceId): array
    {
        return $this->decodeJsonResponse(
            $this->httpClient->get($this->getUri() . "/$largeFaceListId/persistedfaces/$persistedFaceId")
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
}

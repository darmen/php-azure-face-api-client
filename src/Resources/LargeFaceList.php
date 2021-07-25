<?php

namespace Darmen\AzureFace\Resources;

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
     * @throws GuzzleException
     */
    public function create(string $largeFaceListId, string $name, string $recognitionModel = null, string $userData = null)
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
     * List large face lists’ information of largeFaceListId, name, userData and recognitionModel.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/list
     * @param int|null $start List large face lists from the least largeFaceListId greater than the "start". Default is null
     * @param int|null $top The number of large face lists to list, ranging in [1, 1000]. Default is 1000.
     * @param bool|null $returnRecognitionModel Return 'recognitionModel' or not. Default is false.
     * @return array
     *
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

        return json_decode($this->httpClient->get("largeFaceLists?" . http_build_query($parameters))->getBody()->getContents(), true);
    }

    /**
     * Delete a specified large face list.
     *
     * @see https://docs.microsoft.com/en-us/rest/api/faceapi/large-face-list/delete
     * @param string $largeFaceListId
     *
     * @throws GuzzleException
     */
    public function delete(string $largeFaceListId)
    {
        $this->httpClient->delete("largeFaceLists/$largeFaceListId");
    }
}

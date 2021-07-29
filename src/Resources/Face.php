<?php

namespace Darmen\AzureFace\Resources;

class Face extends Resource
{
    public function getUri(): string
    {
        return '';
    }

    /**
     * Detect human faces in an image, return face rectangles, and optionally with faceIds, landmarks, and attributes.
     *
     * @link https://docs.microsoft.com/en-us/rest/api/faceapi/face/detect-with-stream
     * @param resource $image A resource containing the image
     * @param string $detectionModel Name of detection model
     * @param int $faceIdTimeToLive The number of seconds for the faceId being cached
     * @param string $recognitionModel Name of recognition model
     * @param string $returnFaceAttributes Analyze and return the one or more specified face attributes in the comma-separated string
     * @param bool $returnFaceId A value indicating whether the operation should return faceIds of detected faces
     * @param bool $returnFaceLandmarks A value indicating whether the operation should return landmarks of the detected faces
     * @param bool $returnRecognitionModel A value indicating whether the operation should return 'recognitionModel' in respons
     * #return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function detectWithStream(
        $image,
        string $detectionModel = 'detection_01',
        int $faceIdTimeToLive = 86400,
        string $recognitionModel = 'recognition_01',
        string $returnFaceAttributes = '',
        bool $returnFaceId = true,
        bool $returnFaceLandmarks = false,
        bool $returnRecognitionModel = false
    ): array
    {
        $parameters = [
            'detectionModel' => $detectionModel,
            'faceIdTimeToLive' => $faceIdTimeToLive,
            'recognitionModel' => $recognitionModel,
            'returnFaceAttributes' => $returnFaceAttributes,
            'returnFaceId' => $returnFaceId,
            'returnFaceLandmarks' => $returnFaceLandmarks,
            'returnRecognitionModel' => $returnRecognitionModel,
        ];

        return $this->decodeJsonResponse(
            $this->httpClient->post('detect?' . http_build_query($parameters), [
                'headers' => [
                    'Content-Type' => 'application/octet-stream'
                ],
                'body' => stream_get_contents($image)
            ])
        );
    }

    /**
     * Detect human faces in an image, return face rectangles, and optionally with faceIds, landmarks, and attributes.
     *
     * @link https://docs.microsoft.com/en-us/rest/api/faceapi/face/detect-with-stream
     * @param string $url An URL of the image file
     * @param string $detectionModel Name of detection model
     * @param int $faceIdTimeToLive The number of seconds for the faceId being cached
     * @param string $recognitionModel Name of recognition model
     * @param string $returnFaceAttributes Analyze and return the one or more specified face attributes in the comma-separated string
     * @param bool $returnFaceId A value indicating whether the operation should return faceIds of detected faces
     * @param bool $returnFaceLandmarks A value indicating whether the operation should return landmarks of the detected faces
     * @param bool $returnRecognitionModel A value indicating whether the operation should return 'recognitionModel' in respons
     * #return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function detectWithUrl(
        string $url,
        string $detectionModel = 'detection_01',
        int $faceIdTimeToLive = 86400,
        string $recognitionModel = 'recognition_01',
        string $returnFaceAttributes = '',
        bool $returnFaceId = true,
        bool $returnFaceLandmarks = false,
        bool $returnRecognitionModel = false
    ): array
    {
        $parameters = [
            'detectionModel' => $detectionModel,
            'faceIdTimeToLive' => $faceIdTimeToLive,
            'recognitionModel' => $recognitionModel,
            'returnFaceAttributes' => $returnFaceAttributes,
            'returnFaceId' => $returnFaceId,
            'returnFaceLandmarks' => $returnFaceLandmarks,
            'returnRecognitionModel' => $returnRecognitionModel,
        ];

        return $this->decodeJsonResponse(
            $this->httpClient->post('detect?' . http_build_query($parameters), [
                'json' => [
                    'url' => $url
                ]
            ])
        );
    }

    /**
     * Given query face's faceId, search the similar-looking faces from a face list.
     *
     * @link https://docs.microsoft.com/en-us/rest/api/faceapi/face/find-similar
     * @param string $faceId
     * @param string $faceListId
     * @param int $maxNumOfCandidatesReturned
     * @param string $mode
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findSimilarInFaceList(string $faceId, string $faceListId, int $maxNumOfCandidatesReturned = 20, string $mode = 'matchPerson'): array
    {
        return $this->decodeJsonResponse(
            $this->httpClient->post('findsimilars', [
                'json' => [
                    'faceId' => $faceId,
                    'faceListId' => $faceListId,
                    'maxNumOfCandidatesReturned' => $maxNumOfCandidatesReturned,
                    'mode' => $mode
                ]
            ])
        );
    }

    /**
     * Given query face's faceId, search the similar-looking faces from a large face list.
     *
     * @link https://docs.microsoft.com/en-us/rest/api/faceapi/face/find-similar
     * @param string $faceId
     * @param string $largeFaceListId
     * @param int $maxNumOfCandidatesReturned
     * @param string $mode
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findSimilarInLargeFaceList(string $faceId, string $largeFaceListId, int $maxNumOfCandidatesReturned = 20, string $mode = 'matchPerson'): array
    {
        return $this->decodeJsonResponse(
            $this->httpClient->post('findsimilars', [
                'json' => [
                    'faceId' => $faceId,
                    'largeFaceListId' => $largeFaceListId,
                    'maxNumOfCandidatesReturned' => $maxNumOfCandidatesReturned,
                    'mode' => $mode
                ]
            ])
        );
    }

    /**
     * Given query face's faceId, search the similar-looking faces from a faceId array.
     *
     * @link https://docs.microsoft.com/en-us/rest/api/faceapi/face/find-similar
     * @param string $faceId
     * @param array $faceIds
     * @param int $maxNumOfCandidatesReturned
     * @param string $mode
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findSimilarInFaceIdsArray(string $faceId, array $faceIds, int $maxNumOfCandidatesReturned = 20, string $mode = 'matchPerson'): array
    {
        return $this->decodeJsonResponse(
            $this->httpClient->post('findsimilars', [
                'json' => [
                    'faceId' => $faceId,
                    'faceIds' => $faceIds,
                    'maxNumOfCandidatesReturned' => $maxNumOfCandidatesReturned,
                    'mode' => $mode
                ]
            ])
        );
    }

    /**
     * Divide candidate faces into groups based on face similarity.
     *
     * @link https://docs.microsoft.com/en-us/rest/api/faceapi/face/group
     * @param array $faceIds Array of candidate faceId created by Face - Detect
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function group(array $faceIds): array
    {
        return $this->decodeJsonResponse(
            $this->httpClient->post('group', [
                'json' => [
                    'faceIds' => $faceIds
                ]
            ])
        );
    }
}

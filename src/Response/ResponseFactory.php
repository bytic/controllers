<?php

namespace Nip\Controllers\Response;

use Nip\Http\Response\JsonResponse;
use Nip\Http\Response\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class ResponseFactory
 * @package Nip\Controllers\Response
 */
class ResponseFactory
{
    use ResponseFactory\HasViewResponseTrait;

    /**
     * Create a new response instance.
     *
     * @param string $content
     * @param int $status
     * @param array $headers
     * @return Response
     */
    public function make($content = '', $status = 200, array $headers = [])
    {
        return new Response($content, $status, $headers);
    }

    /**
     * Create a new "no content" response.
     *
     * @param  int  $status
     * @param  array  $headers
     * @return Response
     */
    public function noContent($status = Response::HTTP_NO_CONTENT, array $headers = [])
    {
        return $this->make('', $status, $headers);
    }

    /**
     * Create a new JSON response instance.
     *
     * @param mixed $data
     * @param int $status
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
        return new JsonResponse($data, $status, $headers, $options);
    }

    /**
     * Create a new streamed response instance.
     *
     * @param \Closure $callback
     * @param int $status
     * @param array $headers
     * @return StreamedResponse
     */
    public function stream($callback, $status = 200, array $headers = [])
    {
        return new StreamedResponse($callback, $status, $headers);
    }

    /**
     * Returns a BinaryFileResponse object with original or customized file name and disposition header.
     *
     * @param \SplFileInfo|string $file File object or path to file to be sent as response
     * @param string|null $fileName
     * @param string $disposition
     * @return BinaryFileResponse
     */
    protected function file(
        $file,
        string $fileName = null,
        string $disposition = ResponseHeaderBag::DISPOSITION_ATTACHMENT
    ): BinaryFileResponse {
        $response = new BinaryFileResponse($file);
        $response->setContentDisposition($disposition,
            null === $fileName ? $response->getFile()->getFilename() : $fileName);

        return $response;
    }

    /**
     * Convert the string to ASCII characters that are equivalent to the given name.
     *
     * @param string $name
     * @return string
     */
    protected function fallbackName($name)
    {
        return str_replace('%', '', Str::ascii($name));
    }
}

<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Common\Response;

use Damianopetrungaro\CleanArchitecture\UseCase\Error\ErrorTypeInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationError;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorType;
use Ramsey\Uuid\Uuid;
use Slim\Http\Response;

final class SlimResponseBuilder implements ResponseBuilderInterface
{
    /**
     * @var int $status
     */
    private $status = 200;

    /**
     * Override default success status code
     *
     * @param int $status
     */
    public function setDefaultSuccessStatusCode(int $status): void
    {
        $this->status = $status;
    }

    /**
     * {@inheritdoc}
     * @return Response
     */
    public function build(ResponseInterface $response): Response
    {
        if ($response->isSuccessful()) {
            if ($response->hasData()) {

                $data = array_map(function ($arr) {
                    return $arr[0];
                }, $response->getData());

                return (new Response($this->status))->withJson(['data' => $data]);
            }
            return new Response($this->status);
        }

        if ($response->hasErrors()) {
            return $this->buildErrorResponse($response);
        }

        return new Response(500);
    }

    /**
     * Return a Response with listed errors
     *
     * @param ResponseInterface $response
     *
     * @return Response
     */
    private function buildErrorResponse(ResponseInterface $response): Response
    {
        $status = null;
        $errorList = $response->getErrors();
        $jsonApiErrors = [];

        foreach ($errorList as $key => $errors) {
            /** @var ApplicationError $error */
            foreach ($errors as $error) {
                // Create the error response
                $jsonApiError = [
                    'id' => Uuid::uuid1(),
                    'code' => $error->code(),
                    'status' => $this->statusCodeFromErrorType($error->type())
                ];

                // Add source and meta if is an ApplicationError and are set
                if ($error instanceof ApplicationError) {
                    !$error->pointer() ?: $jsonApiError['source'] = ['pointer' => $error->pointer()];
                    !$error->meta() ?: $jsonApiError['meta'] = $error->meta();
                }

                // Create an array with a specific key if is not set
                isset($jsonApiErrors[$key]) ?: $jsonApiErrors[$key] = [];
                $jsonApiErrors[$key][] = $jsonApiError;

                // If the status code is different from the previous one, the HTTP status will be 500
                // TODO Use first status char for check error
                // Es: if errors are 401 and 422, use 400 as main status
                if ($status != null && $status !== $this->statusCodeFromErrorType($error->type())) {
                    $status = 500;
                    continue;
                }
                // Else set this as current status code
                $status = $this->statusCodeFromErrorType($error->type());
            }
        }

        return (new Response($status))->withJson(['errors' => $jsonApiErrors]);
    }

    /**
     * Return the http status code
     *
     * @param $type
     *
     * @return int
     */
    private function statusCodeFromErrorType(ErrorTypeInterface $type): int
    {
        if (in_array($type->getValue(), [ApplicationErrorType::VALIDATION_ERROR, ApplicationErrorType::USER_PASSWORD_MISMATCH])) {
            return 422;
        }

        if ($type->getValue() == ApplicationErrorType::USER_PASSWORD_MISMATCH) {
            return 422;
        }

        if ($type->getValue() == ApplicationErrorType::NOT_FOUND_ENTITY) {
            return 404;
        }

        if ($type->getValue() == ApplicationErrorType::PERSISTENCE_ERROR) {
            return 500;
        }

        return 500;
    }
}
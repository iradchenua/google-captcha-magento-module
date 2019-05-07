<?php


namespace Ivan\GoogleCaptcha\Service;


class UserTokenChecker
{
    private $dataProvider;
    private $jsonHelper;

    public function __construct(
        \Magento\Framework\Serialize\Serializer\Json $jsonHelper,
        \Ivan\GoogleCaptcha\Model\DataProvider $dataProvider
    )
    {
        $this->jsonHelper = $jsonHelper;
        $this->dataProvider = $dataProvider;
    }

    private function getRequestToGoogleService($userResponseToken)
    {
        $httpHeaders = new \Zend\Http\Headers();
        $httpHeaders->addHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $request = new \Zend\Http\Request();
        $request->setHeaders($httpHeaders);
        $request->setUri('https://www.google.com/recaptcha/api/siteverify');
        $request->setMethod(\Zend\Http\Request::METHOD_POST);

        $params = new \Zend\Stdlib\Parameters([
            'secret' => $this->dataProvider->getPrivateSiteKey(),
            'response' => $userResponseToken
        ]);
        $request->setQuery($params);
        return $request;
    }

    private function getResponseFromGoogleService($request)
    {
        $client = new \Zend\Http\Client();
        $options = [
            'adapter'   => 'Zend\Http\Client\Adapter\Curl',
            'curloptions' => [CURLOPT_FOLLOWLOCATION => true],
            'maxredirects' => 0,
            'timeout' => 100
        ];
        $client->setOptions($options);

        $response = $client->send($request);
        return $response->getBody();
    }

    public function isUserTokenValid($userResponseToken)
    {
        $request = $this->getRequestToGoogleService($userResponseToken);
        $response = $this->getResponseFromGoogleService($request);
        $arrayResponse = $this->jsonHelper->unserialize($response);
        return $arrayResponse['success'] == true;
    }
}
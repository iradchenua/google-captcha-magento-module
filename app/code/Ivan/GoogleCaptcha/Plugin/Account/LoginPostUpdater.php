<?php


namespace Ivan\GoogleCaptcha\Controller\Account;


class LoginPostUpdater
{
    private $messageManager;
    private $resultRedirectFactory;
    private $dataProvider;
    private $jsonHelper;

    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Controller\ResultFactory $resultRedirectFactory,
        \Magento\Framework\Serialize\Serializer\Json $jsonHelper,
        \Ivan\GoogleCaptcha\Model\DataProvider $dataProvider
    )
    {
        $this->messageManager = $messageManager;
        $this->resultRedirectFactory = $resultRedirectFactory;
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
            'timeout' => 30
        ];
        $client->setOptions($options);

        $response = $client->send($request);
        return $response->getBody();
    }
    public function aroundExecute(\Magento\Customer\Controller\Account\LoginPost $subject, callable $proceed)
    {
        if(!$this->dataProvider->getIsEnabled()) {
            return $proceed;
        }
        $postValues = $subject->getRequest()->getPostValue();
        $userResponseToken = $postValues['g-recaptcha-response'];
        $isValidCaptcha = true;
        if (!empty($userResponseToken)) {
            $request = $this->getRequestToGoogleService($userResponseToken);
            $response = $this->getResponseFromGoogleService($request);
            $arrayResponse = $this->jsonHelper->unserialize($response);
            if (!$arrayResponse['success']) {
                $this->messageManager->addError(__('A captcha test is failed. You are robot!!!!'));
                $isValidCaptcha = false;
            }
        } else {
            $this->messageManager->addError(__('A captcha is required.'));
            $isValidCaptcha = false;
        }
        if (!$isValidCaptcha) {
            $resultRedirect = $this->resultRedirectFactory->create(
                \Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT
            );
            $resultRedirect->setPath('customer/account/login/');

            return $resultRedirect;
        }
        return $proceed();
    }
}

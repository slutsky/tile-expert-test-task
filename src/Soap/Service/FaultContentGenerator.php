<?php

declare(strict_types=1);

namespace App\Soap\Service;

class FaultContentGenerator
{
    public function generate(\SoapFault $fault): string
    {
        $xml = new \SimpleXMLElement(<<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <env:Envelope xmlns:env="http://www.w3.org/2003/05/soap-envelope">
            <env:Body>
                <env:Fault/>
            </env:Body>
        </env:Envelope>
        XML);

        /** @var \SimpleXMLElement[] $faultElements */
        $faultElements = $xml->xpath('//env:Fault');
        [$faultElement] = $faultElements;

        if (null !== $fault->faultcode) {
            $faultElement
                ->addChild('env:Code')
                ->addChild('faultcode', 'env:'.$fault->faultcode);
        }

        $faultElement
            ->addChild('env:Reason')
            ->addChild('env:Text', $fault->faultstring);

        if (null !== $fault->detail) {
            if ($fault->detail instanceof \Stringable) {
                $details = (string) $fault->detail;
            } else {
                $details = var_export($fault->detail, true);
            }

            $faultElement
                ->addChild('env:Detail')
                ->addChild('env:Text', $details);
        }

        if (null !== $fault->faultactor) {
            $faultElement->addChild('faultactor', $fault->faultactor);
        }

        if (null !== $fault->headerfault) {
            $faultElement->addChild('headerfault', $fault->headerfault);
        }

        if (null !== $fault->faultcodens) {
            $faultElement->addChild('faultcodens', $fault->faultcodens);
        }

        /** @var string $content */
        $content = $xml->asXML();

        return $content;
    }
}

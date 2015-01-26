<?php
/**
 * FedEx package status tracking
 */

namespace Phpie\Courier\Fedex;


class Track extends Fedex
{
    public function track($trackingNumber)
    {

        if(!isset($trackingNumber)){
            return false;
        }

        //The WSDL is not included with the sample code.
        //Please include and reference in $path_to_wsdl variable.
        $path_to_wsdl = __DIR__.DIRECTORY_SEPARATOR.'TrackService_v9.wsdl';

        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new \SoapClient($path_to_wsdl,
            array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

        $request['WebAuthenticationDetail'] = array(
            'UserCredential' => array(
                'Key' => $this->authKey,
                'Password' => $this->authPassword
            )
        );
        $request['ClientDetail'] = array(
            'AccountNumber' => $this->authAccountNumber,
            'MeterNumber' => $this->authMeterNumber
        );
        $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Track Request using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'trck',
            'Major' => '9',
            'Intermediate' => '1',
            'Minor' => '0'
        );
        $request['SelectionDetails'] = array(
            'PackageIdentifier' => array(
                'Type' => 'TRACKING_NUMBER_OR_DOORTAG',
                'Value' => $trackingNumber // Replace 'XXX' with a valid tracking identifier
            )
        );


        try {
            if ($this->setEndpoint('changeEndpoint')) {
                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }

            $response = $client->track($request);

            if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR') {
                if ($response->HighestSeverity != 'SUCCESS') {
                    echo '<table border="1">';
                    echo '<tr><th>Track Reply</th><th>&nbsp;</th></tr>';
                    $this->trackDetails($response->Notifications, '');
                    echo '</table>';
                } else {
                    if ($response->CompletedTrackDetails->HighestSeverity != 'SUCCESS') {
                        echo '<table border="1">';
                        echo '<tr><th>Shipment Level Tracking Details</th><th>&nbsp;</th></tr>';
                        $this->trackDetails($response->CompletedTrackDetails, '');
                        echo '</table>';
                    } else {
                        echo '<table border="1">';
                        echo '<tr><th>Package Level Tracking Details</th><th>&nbsp;</th></tr>';
                        $this->trackDetails($response->CompletedTrackDetails->TrackDetails, '');
                        echo '</table>';
                    }
                }
                $this->printSuccess($client, $response);
            } else {
                $this->printError($client, $response);
            }

            $this->writeToLog($client);    // Write to log file
        } catch (SoapFault $exception) {
            $this->printFault($exception, $client);
        }
    }
}
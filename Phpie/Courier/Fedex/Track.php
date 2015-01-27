<?php
/**
 * FedEx package status tracking
 */

namespace Phpie\Courier\Fedex;


class Track extends Fedex
{

    public $lastStatusTime;
    public $statusDescription;
    public $currentStreet;
    public $currentCity;
    public $currentState;
    public $currentCountry;
    public $currentTrackingNumber;
    public $currentDimensions;
    public $currentService;
    public $currentMasterTrackingNumber;
    public $currentWeight;
    public $currentTotalPieces;
    public $currentPackaging;

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

            $this->responseToArray($response);

            return $response;
        } catch (SoapFault $exception) {
            $this->printFault($exception, $client);
        }
    }

    public function responseToArray($response)
    {
        if(!is_object($response)){
            return false;
        }

        try{
            $this->lastStatusTime   = $response->CompletedTrackDetails->TrackDetails->StatusDetail->CreationTime;
            $this->statusDescription    = $response->CompletedTrackDetails->TrackDetails->StatusDetail->Description;
            $this->currentStreet = $response->CompletedTrackDetails->TrackDetails->StatusDetail->Location->StreetLines;
            $this->currentCity   = $response->CompletedTrackDetails->TrackDetails->StatusDetail->Location->City;
            $this->currentState  = $response->CompletedTrackDetails->TrackDetails->StatusDetail->Location->StateOrProvinceCode;
            $this->currentCountry    = $response->CompletedTrackDetails->TrackDetails->StatusDetail->Location->CountryName;
            $this->currentTrackingNumber = $response->CompletedTrackDetails->TrackDetails->TrackingNumber;
            $this->currentDimensions   = $response->CompletedTrackDetails->TrackDetails->PackageWeight->Value . 'X' . $response->CompletedTrackDetails->TrackDetails->PackageDimensions->Width . 'X' . $response->CompletedTrackDetails->TrackDetails->PackageDimensions->Height . ' ' . $response->CompletedTrackDetails->TrackDetails->PackageDimensions->Units;
            $this->currentService  = $response->CompletedTrackDetails->TrackDetails->OperatingCompanyOrCarrierDescription;
            $this->currentMasterTrackingNumber = $response->CompletedTrackDetails->TrackDetails->TrackingNumber;
            $this->currentWeight   = $response->CompletedTrackDetails->TrackDetails->PackageWeight->Value . ' ' . $response->CompletedTrackDetails->TrackDetails->PackageWeight->Units;
            $this->currentTotalPieces  = $response->CompletedTrackDetails->TrackDetails->PackageCount;
            $this->currentPackaging    = $response->CompletedTrackDetails->TrackDetails->Packaging;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
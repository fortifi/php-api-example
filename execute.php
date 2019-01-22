<?php
namespace Example;

use Fortifi\Api\Core\Connections\RequestsConnection;
use Fortifi\Api\Core\OAuth\Grants\ServiceAccountGrant;
use Fortifi\Api\V1\Endpoints\FortifiApi;

require_once 'vendor/autoload.php';

// These details are available within the service accounts page:
// https://[orgname].fortifi.cloud/settings/organisation/service-accounts
// By clicking the [view] button on your desired service account

//TODO: Replace the following details with your own account details
const ORG_FID = 'ORG:XY:1234:abcde'; //Organisation FID
const API_USER = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
const API_KEY = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';

$connection = new RequestsConnection();
$connection->setOrganisationFid(ORG_FID);

$api = new FortifiApi();
$api->setConnection($connection)->setAccessGrant(new ServiceAccountGrant(API_USER, API_KEY));

try
{
  $result = $api->brands();

  echo $result->wasSuccessful() ? "SUCCESS" : "FAILED";
  echo ' | Status Code: ' . $result->getRawResult()->getStatusCode() . PHP_EOL;
  print_r($result->getDecodedResponse());
}
catch(\Exception $e)
{
  echo $e->getMessage() . PHP_EOL;
}

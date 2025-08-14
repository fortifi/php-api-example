<?php
namespace Example;

use Fortifi\Api\Core\Connections\Requests2Connection;
use Fortifi\Api\Core\OAuth\Grants\ServiceAccountGrant;
use Fortifi\Api\V1\Definitions\FortifiApiDefinition;
use Fortifi\Api\V1\Endpoints\FortifiApi;

require_once 'vendor/autoload.php';

// These details are available within the service accounts page:
// https://[orgname].fortifi.cloud/settings/organisation/service-accounts
// By clicking the [view] button on your desired service account

//TODO: Replace the following details with your own account details
const ORG_FID = 'ORG:XY:1234:abcde'; //Organisation FID
const API_USER = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
const API_KEY = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';

$connection = new Requests2Connection();
$connection->setOrganisationFid(ORG_FID);

$api = new FortifiApi();
$def = $api->getApiDefinition();
if($def instanceof FortifiApiDefinition)
{
  $def->setHost('api.fortifi.me');
}
$api->setConnection($connection)->setAccessGrant(new ServiceAccountGrant(API_USER, API_KEY));

try
{
  $result = $api->brands()->all();
  var_dump([
    $result->wasSuccessful() ? "SUCCESS" : "FAILED",
    $result->getRawResult()->getStatusCode(),
    $result->getDecodedResponse(),
  ]);
}
catch(\Exception $e)
{
  var_dump([$e->getCode(), $e->getMessage()]);
}

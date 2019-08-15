<?php
declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

use Ubnt\UcrmPluginSdk\Service\UcrmSecurity;
use \GuzzleHttp\Exception\GuzzleException;

/* *********************************************************************************************************************
 * public.php?script=<script.php>[&...arguments]
 * ---------------------------------------------------------------------------------------------------------------------
 * This section is specific to deviated execution of scripts from the client-side.
 */

// If a valid web request is incoming...
if(isset($_SERVER) && isset($_SERVER["REQUEST_URI"]))
{
    // ...THEN parse the URL and get the necessary information.
    $params = [];
    parse_str(parse_url($_SERVER["REQUEST_URI"])["query"] ?? "", $params);

    /*
    Given URL:
        "public.php?script=refresco.php&_=1565718969180"

    $params => [
        "script" => "refresco.php,
        "_" => "1565718969180"
    ]
    */

    // IF there is a "script" included in the query string...
    if(array_key_exists("script", $params))
    {
        $script = $params["script"];

        // ...THEN, we can check for a supported script...
        switch($script)
        {
            case "refresco.php":

                // Include the script.
                require_once __DIR__."/server/refresco.php";

                // IF there is also a "_" included in the query string...
                if(array_key_exists("_", $params))
                {
                    // ...THEN execute the desired function, passing the desired arguments.
                    generateImage($params["_"]);

                    // Be certain to exit here, as you will NOT want the remainder of the script output with the image!
                    exit;
                }

                //
                // If there are any other things you want this particular script to handle, this is a good place...
                //

                break;

            //
            // Handle any other scripts you need here...
            //

            default:
                http_response_code(501);
                echo "Functionality for the script '$script' is not currently implemented!";
                exit;
        }
    }
}

/* *********************************************************************************************************************
 * public.php
 * ---------------------------------------------------------------------------------------------------------------------
 * This section handles the normal execution of this script.
 */

try
{
    // Initialize the security suite and then get the current user.
    $security = UcrmSecurity::create();
    $user = $security->getUser();

    // Get any necessary Client information, here I just grab the current Client ID.
    $clientId = $user->clientId;

    //
    // NOTE: This would be the perfect spot to handle any normal public.php type stuff!
    //

    // Finally, display the index.html page!
    include __DIR__ . "/index.html";
}
catch(Exception $e)
{
    http_response_code(500);
    echo "Something went wrong when attempting to initialize the Security SDK!";
    exit;
}
catch(GuzzleException $e)
{
    http_response_code(500);
    echo "Something went wrong when attempting to get the current user!";
    exit;
}



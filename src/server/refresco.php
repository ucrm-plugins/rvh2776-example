<?php

/**
 * Generate an image based on a given ID.
 * @param string $id
 */
function generateImage(string $id): void
{
    // NOTE: This is where you would validate the client information...

    // IF the ID is invalid...
    if($id === "")
    {
        // ...THEN we need to return an HTTP 404 suggesting the image was not found!
        http_response_code(404);
        echo "The image for '$id' was not found!";
        exit;
    }

    // OTHERWISE, everything should be fine...

    // NOTE: Here you would generate the image however you desire, I am simply grabbing a placeholder image.
    $image = file_get_contents("https://placekitten.com/640/360");

    // Set the MIME type and return the actual image data!
    // NOTE: In your case, this should already be known, so no crazy code needed!
    header("Content-Type: image/jpeg");

    // And then finally, echo the image data!
    echo $image;
}

//
// NOTE: You can add additional functions here that can be called from public.php as desired!
//

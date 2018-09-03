# CacheBuster

Use this library, preferrably with your templating engine of choice, to easily append a 
cache busting token string to your hyperlinked resource, such as a stylesheet or a javascript file.

## Usage

    $fileService = new FileService('/var/mysite/public/');
    $tokenType = new ResourceSizeHashToken();
    
    $queryStringBuster = new QueryStringBuster($tokenType, $fileService);
    
    $queryStringBuster->modifyResourcePath('css/stylesheet.min.css');
 
Will output: `css/stylesheet.min.css?token=...` with a token generated based on file size hash, which will then
change every time the file itself gets updated.
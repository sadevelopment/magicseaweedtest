# magicseaweedtest

The Magic Seaweed Test is implemented as a client/server suite using PHP and ReactPHP.

## Install latest composer

Run the following to get the latest (as of time of writing) composer.

```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

## Configuration

The following shows the default config.json file found in the root. There is one implemented search engine (gpnp), for Google Places Nearby. Other engines can be added by implementing the three classes Rewriter, BaseRequestHandler and ListPresenter and specifying the implementation classes (namespaced) in argument_rewriter, handler and display_class respectively.

```
{
    "version": "1.0",
    "default_search_engine":"gpnb",
    "param_delim": "|",
    "search_engines": [
        {
            "name":"gpnb",
            "description": "Google Places Nearby Search",
            "api_key": "ADD_YOUR_KEY_HERE",
            "handler": "App\\RequestHandler\\GooglePlacesNearByHandler",
            "display_class": "App\\Lists\\GPNearByMe",
            "argument_rewriter": "App\\Helper\\GPArgumentRewriter",
            "defaults": {
                "search_term": "surf",
                "radius": 1000,
                "type":"lodging"
            }
        }
    ],
    "logging": {
        "active":true
    },
    "error_email_address":[]
}
```



## Running the program

To run the application make sure the mswtest is executable.

Type: ./mswtest <engine>

Where: <engine> - an optional places search engine abbreviation as defined in the config.json file. If this is blank then the default (default_search_engine) will be used.

Type quit and any point to exit the program.

Usage is displayed based on the search engine selected. For gpnp, this is:

```

Usage:
        <lat,lng>|<radius>|<search term>|<type>
    Or
        <place name>|<radius>|<search term>|<type>

Required:

<lat,lng> or <place name> - one of these are required.

Optional Params:

<radius> - if radius is not a numeric will use the default in config.json for this engine
<search term> - if not provided will use the default in config.json for this engine
<type> - if type is not specified will use the default in config.json for this engine

```

(Type usage at any point to redisplay the current search engine's usage message.)



## Testing

Please install all dependencies using composer. Once this has been done then the tests can be run using the following from the root of the git checkout:

```
./vendor/bin/phpunit tests
```

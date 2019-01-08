# About

This repository are intended for learning purpose only. A simple collaborative
editor over WebSocket using Ratchet PHP library. It features very simple editor
and preview window for previewing HTML content.

![Demo Collaborative Editor WebSocket PHP](https://s3.amazonaws.com/rioastamal-assets/collaborative-editor-websocket-php/collaborative-editor-websocket.mov.gif)

# Installation

Clone this project repository.

```
$ git clone https://github.com/rioastamal-examples/collaborative-editor-websocket-php
```

Next is to install all dependencies required by chat server using Composer.

```
$ cd collaborative-editor-websocket-php
$ composer install -vvv
```

# Running the App

We need to start two server first is the web socket server and second is normal
web server. To start web socket server you can execute a script on
./bin directory.

```
$ php ./bin/editor-server.php
Websocket Editor server running on 0.0.0.0:9191.
--
```

Now open another terminal and start web server using PHP built-in web server.
The document root should be `public/` directory.

```
$ php -S 0.0.0.0:9190 -t public/
PHP 7.1.25 Development Server started at Wed Jan  9 06:10:13 2019
Listening on http://0.0.0.0:9190
Document root is /path/to/collaborative-editor-websocket-php/public
Press Ctrl-C to quit.
```

On example above by default the web server is running on port 9190 and web socket server on port 9191. Here's step to test.

1. Open your browser and navigate to [http://localhost:9190/](http://localhost:9190/). 
2. Open another tab or browser window and navigate to the same address.
3. Start typing on Editor box, the code should be appear on another window.

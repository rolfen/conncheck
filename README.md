![](https://raw.githubusercontent.com/rolfen/conncheck/js/gif.gif)

# Conncheck

A web page for checking connectivity status from inside your browser.

It includes a live HTTP ping graph.

## Requirements

PHP is used for displaying the client IP, timestamp and for writing no-cache headers. 

If you don't have PHP, simply remove the PHP code at the beginning of index.php and change the file extension from `php` to `html`.

Node.js is required for Javascript dependencies (please see below).

## Installing

Upload it to the www folder, then run the following to install javascript dependencies:

```
npm install
```

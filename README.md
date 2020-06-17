# Conncheck

A web page for checking your connectivity in the browser.

## Requirements

PHP is required, only for displaying your IP and timestamp, you could easily remove that from the source and rename the file to `.html` if you want to serve the page without PHP.

Node.js is required for Javascript dependencies (see below).

## Installing

Upload it to your www folder on your server, then run the following to install javascript dependencies:

```
npm install
```

## Sample Output

This is a rough idea of what you get. The real output will have some formatting and styling added. `Toggle Ping` would be a button to start / stop pinging. The ASCII graph would indicate latency in milliseconds and would be updated every second.

```
Hi

Your IP is 118.112.86.81
Page loaded at 1592321180 

Toggle Ping

  141.00 ┤             ╭╮ ╭╮  
  133.57 ┤             ││ ││  
  126.14 ┤             ││ ││  
  118.71 ┤  ╭╮         ││ ││  
  111.29 ┤  ││        ╭╯│ │╰╮ 
  103.86 ┤╭─╯│    ╭╮╭─╯ │ │ │ 
   96.43 ┼╯  │ ╭──╯││   ╰─╯ ╰ 
   89.00 ┤   ╰─╯   ╰╯         

```

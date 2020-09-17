# Conncheck

A web page for checking connectivity status from inside your browser.

It includes a live HTTP ping.

## Requirements

PHP is required for displaying the client IP, timestamp and for writing no-cache headers. You could remove this functionality from the source code and change the file extension to `html` to serve the page without PHP.

Node.js is required for Javascript dependencies (please see below).

## Installing

Upload it to the www folder, then run the following to install javascript dependencies:

```
npm install
```

## Sample Output

This is an approximative idea of what you get. `Toggle Ping` would be a button to start / stop pinging. The ASCII graph would indicate latency in milliseconds and would be updated every second.

```
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

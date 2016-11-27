# Advanced Database Technologies #

## General course assignment ##

Build a map-based application, which lets the user see geo-based data on a map and filter/search through it in a meaningfull way. Specify the details and build it in your language of choice. The application should have 3 components:

1. Custom-styled background map, ideally built with [mapbox](http://mapbox.com). Hard-core mode: you can also serve the map tiles yourself using [mapnik](http://mapnik.org/) or similar tool.
1. Local server with [PostGIS](http://postgis.net/) and an API layer that exposes data in a [geojson format](http://geojson.org/).
1. The user-facing application (web, android, ios, your choice..) which calls the API and lets the user see and navigate in the map and shows the geodata. You can (and should) use existing components, such as the Mapbox SDK, or Leaflet.

## Data sources ##

* [Open Street Maps](https://www.openstreetmap.org/)

## My project - GPS positions of cell towers in Slovakia ##

**Application description:** The web application displays the position of mobile towers in Slovakia.

**Data source:** [OpenCellId](http://opencellid.org/)

**Technologies used:** 

* *front-end*: HTML (template Boilerplate), Mapbox API, Javascript, jQuery

* *back-end*: PHP

* front-end & back-end communication: ajax

### Scenarios ###

* *identify current location*

* *choose coordinates from maps*

* *filter operators, view range*

* **search**

    * show towers within a radius of a selected point

    * show the nearest *n* channels from the selected point
    
    * show coverage on selected point

    * find the tower by its *id*

    * show closest towers with coverage on the road

* view simple statistics

* set a minimum number of samples and the smallest range of tower

 
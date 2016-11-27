# Advanced Database Technologies #

## General course assignment ##

Build a map-based application, which lets the user see geo-based data on a map and filter/search through it in a meaningfull way. Specify the details and build it in your language of choice. The application should have 3 components:

1. Custom-styled background map, ideally built with [mapbox](http://mapbox.com). Hard-core mode: you can also serve the map tiles yourself using [mapnik](http://mapnik.org/) or similar tool.
1. Local server with [PostGIS](http://postgis.net/) and an API layer that exposes data in a [geojson format](http://geojson.org/).
1. The user-facing application (web, android, ios, your choice..) which calls the API and lets the user see and navigate in the map and shows the geodata. You can (and should) use existing components, such as the Mapbox SDK, or Leaflet.

## Data sources ##

* [Open Street Maps](https://www.openstreetmap.org/)

## My project - GPS positions of cell towers in Slovakia ##

*Katarína Szakszová*

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

### API ###

http://localhost/PDT/API/getStations.php?lat=48.1686&lon=17.7176&radius=1000&nets[1]=1&minrange=0&minsamples=0

![2.PNG](https://bitbucket.org/repo/Rdo79d/images/3881956315-2.PNG)


### Screen ###

* show towers within a radius of a selected point

![1.PNG](https://bitbucket.org/repo/Rdo79d/images/4255751641-1.PNG)

* show tower description

![3.PNG](https://bitbucket.org/repo/Rdo79d/images/2220296185-3.PNG)

### Imported data to DB ###


```
#!sql

CREATE TABLE public.towers
(
  gid integer NOT NULL DEFAULT nextval('towers_gid_seq'::regclass),
  radio character(5) NOT NULL,
  mcc smallint NOT NULL,
  net smallint NOT NULL,
  area integer NOT NULL,
  cell integer NOT NULL,
  unit integer,
  the_geom geometry,
  lon double precision NOT NULL,
  lat double precision NOT NULL,
  range integer NOT NULL,
  samples integer NOT NULL DEFAULT 0,
  changeable boolean NOT NULL,
  created integer NOT NULL,
  updated integer NOT NULL,
  averagesignal integer,
  CONSTRAINT towers_pkey PRIMARY KEY (gid),
  CONSTRAINT enforce_dims_the_geom CHECK (st_ndims(the_geom) = 2),
  CONSTRAINT enforce_geotype_geom CHECK (geometrytype(the_geom) = 'POINT'::text OR the_geom IS NULL),
  CONSTRAINT enforce_srid_the_geom CHECK (st_srid(the_geom) = 4326)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.towers
  OWNER TO postgres;

-- Index: public.towers_the_geom_gist
CREATE INDEX towers_geom_index ON towers USING GIST (the_geom);

--
COPY towers(radio,mcc,net,area,cell,unit,lon,lat,range,samples,changeable,created,updated,averageSignal) FROM 'C:\\pom\\cell_towes_sk_231.csv' DELIMITERS ',' CSV HEADER;

--
UPDATE towers SET the_geom = ST_GeomFromText('POINT(' || lon || ' ' || lat || ')',4326);


```

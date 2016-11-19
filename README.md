**General course assignment**

Build a map-based application, which lets the user see geo-based data on a map and filter/search through it in a meaningfull way. Specify the details and build it in your language of choice. The application should have 3 components:

Custom-styled background map, ideally built with mapbox. Hard-core mode: you can also serve the map tiles yourself using mapnik or similar tool.
Local server with PostGIS and an API layer that exposes data in a geojson format.
The user-facing application (web, android, ios, your choice..) which calls the API and lets the user see and navigate in the map and shows the geodata. You can (and should) use existing components, such as the Mapbox SDK, or Leaflet.
Example projects

Showing nearby landmarks as colored circles, each type of landmark has different circle color and the more interesting the landmark is, the bigger the circle. Landmarks are sorted in a sidebar by distance to the user. It is possible to filter only certain landmark types (e.g., castles).

Showing bicykle roads on a map. The roads are color-coded based on the road difficulty. The user can see various lists which help her choose an appropriate road, e.g. roads that cross a river, roads that are nearby lakes, roads that pass through multiple countries, etc.

**Data sources**

Open Street Maps

**My project**

Fork this repository and fill in (either in English, or in Slovak):

Application description: 

Data source: OpenStreetMap, OpenCellId

Technologies used: 
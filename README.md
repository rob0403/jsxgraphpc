# JSXGraph
Page Component Plugin for ILIAS 5.1.x

### Page Component that allows interactive geometry, plotting and visualization  ###

This Plugin will add a Page Component, that allows:
* Euclidean Geometry:
* Points, lines, circle, intersections, perpendicular lines, angles
* Curve plotting: Graphs, parametric curves, polar curves, data plots, Bezier curves
* Differential equations
* Turtle graphics
* Lindenmayer systems
* Interaction via sliders
* Animations
* Polynomial interpolation, spline interpolation
* Tangents, normals
* Basic support for charts
* Vectors
* ...

See [**JSXGraph-Homepage**](http://jsxgraph.uni-bayreuth.de)

###Installation

Start at your ILIAS root directory  
```bash
mkdir -p Customizing/global/plugins/Services/COPage/PageComponent  
cd Customizing/global/plugins/Services/COPage/PageComponent
git clone --recursive https://github.com/TIK-NFL/jsxgraphpc.git JSXGraph
```  
and activate it in the ILIAS-Admin-GUI. 

### Credits ###
* Developed for ILIAS 5.1 by Per Pascal Grube, University Stuttgart, 2016

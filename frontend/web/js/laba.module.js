var labModule = (function() {

      getSights = function() {
      	$.post('?r=site/get-sights', {
      		'foo': 'foo'
      	},
      	//callback function
	      	function(resp) {
	      		console.log(resp[0].SightX);	
	      	}
      	);
      },
      getMapLayers = function() {

      },

      adjustPopover = function(iframe) {
        iframe.style.height='auto';   
        iframe.style.height = '55vh';

      },

      makehtmlcontent = function(sightj, contact, adress) {
          
        $.ajax({ 
             url: 'contentmaker.php',
             data: {sightj: sightj, contact:contact, adress: adress} 
        });
      },     	

      getSights = function() {
             return $.post('?r=site/get-sights', {
                'foo': 'foo'
              }
              );
            },

      getTypes = function() {
           return $.post('?r=site/get-types', {
                'foo': 'foo'
              } 
              );
            },

      getCheckboxes = function(types) {
        return $.post('?r=site/get-checkboxes', {
                'foo': 'foo',
                 types: types
              } 
              );
      },

      initMap = function() {
            var map = new ol.Map({
              layers: [new ol.layer.Tile({
             
            source: new ol.source.MapQuest({layer: 'osm'})
            })
              ],
              target: document.getElementById('map'),
              view: new ol.View({
                center: ol.proj.fromLonLat([50.1974,53.2215]),
                zoom: 11         
              })
            });
            return map;

      },

      initMarks = function(sightlist, map, checkflag) {

              if (checkflag.is(":checked")){
                      
                  var vectorSource = new ol.source.Vector({});       

                  for (var i = sightlist.length - 1; i >= 0; i--) {
                      if (sightlist[i].SightTypeId ==  checkflag.attr('id')) {

                            var iconFeature = new ol.Feature({
                              geometry: new ol.geom.Point(ol.proj.fromLonLat([parseFloat(sightlist[i].SightX), parseFloat(sightlist[i].SightY)])),
                              sightjson: JSON.stringify(sightlist[i]),

                              posX: parseFloat(sightlist[i].SightX),
                              posY: parseFloat(sightlist[i].SightY)
                            });

                            var iconStyle = new ol.style.Style({
                              image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                                anchor: [0.5, 46],
                                anchorXUnits: 'fraction',
                                anchorYUnits: 'pixels',
                                src: 'data/type' + sightlist[i].SightTypeId + '.png'
                              }))
                            });


                            iconFeature.setStyle(iconStyle);

                             //eval('var L'+$(this).attr('id')+' =' + new ol.source.Vector({}));
                            vectorSource.addFeature(iconFeature);
                      };
                  };

                  var vectorLayer = new ol.layer.Vector({
                    source: vectorSource,
                    title: 'L' + checkflag.attr('id')
                  });

                  map.addLayer(vectorLayer);

              }
              else {    
                var layersMy = map.getLayers();
                var layerName = 'L' + checkflag.attr('id');
                
                layersMy.forEach(function(lay,i,layersMy)
                {
                      if (lay.get('title')==layerName)
                         map.removeLayer(lay);
                });
                
                  checkflag.popover('destroy');
                
              }

      },

      initPopup = function(element,map) {
        
        var popup = new ol.Overlay({
          element: element,
          positioning: 'bottom-center',
          stopEvent: false
        });
        map.addOverlay(popup);

        return popup;

      },

      getClickfeature = function(evt, map) {
        var feature = map.forEachFeatureAtPixel(evt.pixel,
          function(feature) {
            return feature;
          }
        )
        return feature;
      },

      getAdress = function(id)
      {
          return $.post('?r=site/get-adress', {
                'foo': 'foo',
                 id: id
              } /*,
              //callback function
                function(resp) {
                  console.log(resp);  
                }*/
              );
      },

      getContact = function(id)
      {
          return $.post('?r=site/get-contact', {
                'foo': 'foo',
                 id: id
              }/* ,
              //callback function
                function(resp) {
                  console.log(resp);  
                }*/
              );
      },


      popupCreate = function(feature, element, map, evt, popup)
      {
                if (feature) {
            
            map.setView(new ol.View({center: ol.proj.fromLonLat([feature.get('posX'),feature.get('posY') ]), zoom: parseInt(map.getView().getZoom()) }));
            sightj = JSON.parse(feature.get('sightjson'));
            var STId = sightj["SightId"];
            var contactj;
            getAdress(STId).done(function(adress){
                  if (adress){
                             //var contact = contactParser(STId);


                                getContact(STId).done(function(contact){
                                if (contact == ""){
                                    makehtmlcontent(sightj, '', adress);
                                    element.popover({
                                    'placement': 'left',
                                    'html': true,
                                    'content': function() {
                                          return '<iframe src="/content.php" style="border:none" width="100%" onload="adjustPopover(this)">'+'</iframe>'; 
                                        }
                                   });
                                    popup.setPosition(evt.coordinate);

                                   var str = feature.get('name');
                                  element.popover('show');
                                }
                                else if (contact)
                                {
                                  makehtmlcontent(sightj, contact, adress);
                                  element.popover({
                                    'placement': 'left',
                                    'html': true,
                                    'content': function() {
                                          return '<iframe src="/content.php" style="border:none" width="100%" onload="adjustPopover(this)">'+'</iframe>'; 
                                        }
                                   });
                                    popup.setPosition(evt.coordinate);

                                   var str = feature.get('name');
                                  element.popover('show');
                                }
                            }).fail(function() {
                          // An error occurred
                          return null;
                            }); 

                                 
                                


                          }
                  else {}
          }).fail(function() {
                  // An error occurred
            }); 





           }
          else {
          element.popover('destroy');
        }

      },



      initModule = function() {

          var map = initMap();

          getTypes().done(function(result) {
              // Code depending on result
            if(result){            
              joo = JSON.stringify(result);
              getCheckboxes(joo).done(function(res){
                  if (res){
                    var SummDok = document.getElementById('checkboxes');
                    SummDok.innerHTML = res;}
                  else {}
              }).fail(function(){});
            }
            else{ }
          }).fail(function() {
                  // An error occurred
            });     

            getSights().done(function(sights)
            {
              if(sights){              
                var boxes = document.getElementById('checkboxes');
                $(boxes).on('click',function(){
                  $('input[type=checkbox]').on('change', function () {            
                    initMarks(sights, map, $(this));
                  });
                });
                var element = document.getElementById('popup');
                var popup = initPopup(element,map);
                map.on('click', function(evt) {
                  var feature =  getClickfeature(evt,map);
                  popupCreate(feature, $(element), map, evt, popup);
                });

                map.on('pointermove', function(e) {
                if (e.dragging) {
                $(element).popover('destroy');
                return;
                  }
                  var pixel = map.getEventPixel(e.originalEvent);
                  var hit = map.hasFeatureAtPixel(pixel);
                  map.getTarget().style.cursor = hit ? 'pointer' : '';
                });
              }
              else {}
            }).fail(function() {
                  // An error occurred
            });    

        };

      	return {
      		initModule: initModule,
      		getSights: getSights,
          getCheckboxes: getCheckboxes,
          initMarks: initMarks,
      	};
}());




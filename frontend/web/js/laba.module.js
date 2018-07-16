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
      getAdmin = function() {
        return $.post('?r=site/is-admin', {
          'foo': 'foo'
        },
        //callback function
          function(resp) {
            console.log(resp);  
          }
        );
      },

      adjustPopover = function(iframe) {
        iframe.style.height='auto';   
        iframe.style.height = '55vh';

      }, 

      makehtmlcontent = function(sightj, contact, adress) {
          
        var popupObject = new Object();
        popupObject.title = sightj.Sightname;
        popupObject.description = sightj.descriptions;
        popupObject.adress = adress.Street +", " + adress.Number +" " + adress.Litera;
        popupObject.contact = contact;
        popupObject.phone = contact.phone;
        popupObject.site = "<a href=\""+contact.site+"\" target=\"_blank\">"+contact.site+"</a>";
        popupObject.WorkTime = contact.WorkTime;
        popupObject.photo = "http://frontend.dev/data/sight" + sightj.SightId + ".jpg";
        var content = new EJS({url: 'templates/popup_template.ejs'}).render(popupObject);
        return content;
        /*return $.post('?r=site/get-content', {
                'foo': 'foo',
                 sightj: sightj,
                 contact: contact,
                 adress: adress
              } 
              );*/
      },     	

      getSights = function() {
             return $.post('?r=site/get-sights', {
                'foo': 'foo'
              }
              );
            },

                 getType = function(id) {
             return $.post('?r=site/get-type', {
                'foo': 'foo',
                id:id
              }
              );
            },

      getTypes = function() {
           return $.post('?r=site/get-types', {
                'foo': 'foo'
              } 
              );
            },

      makeSightAddEditForm = function(name, description, type, street, litera, number, phone, site, worktime, add, edit)
      {
        var formObject = new Object();
        formObject.SightName = name;
        formObject.Description = description;
        formObject.SightType = type;
        formObject.SightStreet = street;
        formObject.SightLitera = litera;
        formObject.SightNumber = number;
        formObject.SightPhone = phone;
        formObject.SightSite = site;
        formObject.SightWorkTime = worktime; 
        formObject.add = add;
        formObject.edit = edit;         

        var content = new EJS({url: 'templates/addedit_template.ejs'}).render(formObject);
        return content;
      },

      createButtons = function()
      {
        var mapdiv = document.getElementById('mapdiv');  
        //var checkboxi = document.createElement('button');
        var buttdiv = document.createElement('div');
        buttdiv.id = "buttdiv";
        var addbutton = document.createElement('input');
        addbutton.type = "checkbox";
        addbutton.id = "addObj";
        addbutton.className = "adminbuttons";
        var addlabel = document.createElement('label');
        addlabel.innerHTML="Добавить объект"

        buttdiv.appendChild(addbutton);
        buttdiv.appendChild(addlabel);
        //delButton
        var delbutton = document.createElement('button')
        delbutton.id = "delbutton";
        delbutton.className = "adminbuttons";
        delbutton.innerHTML = "Удалить объект";
        delbutton.style.visibility = "hidden";
        //delbutton.onclick = deletefeature;
        buttdiv.appendChild(delbutton);
        //editbutton
        var editbutton = document.createElement('button')
        editbutton.id = "editbutton";
        editbutton.className = "adminbuttons";
        editbutton.innerHTML = "Редактировать объект";
        editbutton.style.visibility = "hidden";
        //editbutton.onclick = editfeature;
        buttdiv.appendChild(editbutton);
        //End
        mapdiv.appendChild(buttdiv);   
      },

      deletefeature = function (feature)
      {        
        sightj = JSON.parse(feature.get('sightjson'));
        var SightId = sightj["SightId"];
        deleteSight(SightId);
         location.reload();

      },

        editPic = function(id) {
          var file_data = $('#sortpicture').prop('files')[0];   
          var form_data = new FormData();                  
          form_data.append('file', file_data);
          form_data.append('id',id);                        
          $.ajax({
                url: '?r=site/pic-edit', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                        
                type: 'post',
               // success: function(php_script_response){
                    //alert(php_script_response); // display response from the PHP script, if any 
                //}
            });
        },


        addPic = function() {
          var file_data = $('#sortpicture').prop('files')[0];   
          var form_data = new FormData();                  
          form_data.append('file', file_data);                       
          $.ajax({
                url: '?r=site/pic-add', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                        
                type: 'post',
                success: function(php_script_response){
                    alert(php_script_response); // display response from the PHP script, if any
                }
            });
        },


      pictureformcreate = function ()
      {        

      var objectform = document.getElementById("object-form");
      var inputpic = document.createElement("input");
      inputpic.name = "sortpic";
      inputpic.type="file";
      inputpic.id="sortpicture"
      objectform.appendChild(inputpic);

      },

      deleteSight = function (SightId)
      {
        return $.post('?r=site/delete-sight', {
          SightId : SightId,
          'foo': 'foo'          
        }
        );
      },

      editfeature = function (feature)
      {
        sightj = JSON.parse(feature.get('sightjson'));
        var SightId = sightj["SightId"];
        var editForm = document.createElement('div');
        editForm.id ="editformid"
        var mapdiv = document.getElementById('mapdiv');   

getAdress(SightId).done(function(adress){
                  if (adress){
                             //var contact = contactParser(STId);

                                getContact(SightId).done(function(contact){
                                    getType(SightId).done(function(sighttype){
                                editForm.innerHTML = makeSightAddEditForm(sightj["Sightname"], sightj["descriptions"], sighttype["TypeName"], adress.Street, adress.Litera, adress.Number, contact.phone, contact.site, contact.WorkTime, null, 1);
                                mapdiv.appendChild(editForm);
            
        
        
        var EditButton = document.getElementById('edit-button');       
        var newSight = new Object();; 
        newSight.id = SightId;
        pictureformcreate();
        EditButton.onclick = function()
        {            
            newSight.SightName = document.getElementById('inputSightName').value;
            newSight.SightDescription = document.getElementById('inputDescription').value;
            newSight.SightType =  document.getElementById('inputSightType').value;
            newSight.SightStreet = document.getElementById('inputSightStreet').value;
            newSight.SightNumber = document.getElementById('inputSightNumber').value;
            newSight.SightLitera = document.getElementById('inputSightLitera').value;
            newSight.SightPhone = document.getElementById('inputSightPhone').value;
            newSight.SightSite = document.getElementById('inputSightSite').value;
            newSight.SightWorkTime = document.getElementById('inputSightWorkTime').value; 

            editPic(SightId);
            editSight(newSight).done(function(result){
            }).fail(function() {                         
                
              
              return null;
            }); 
            mapdiv.removeChild(editForm);
        }
              }).fail(function() {
                          // An error occurred
                          return null;
                            }); 


                            }).fail(function() {
                          // An error occurred

                            }); 

                                 
                                


                          }
                  
          }).fail(function() {
            }); 
          
      },

      editSight = function(sight)
      {
          nsight = JSON.stringify(sight);
          return $.post('?r=site/edit-sight', {
                'foo': 'foo',
                 nsight: nsight
              } /*,
              //callback function
                function(resp) {
                  console.log(resp);  
                }*/
              );
      },


      addfeature = function (lonlat)
      {
        var mapdiv = document.getElementById('mapdiv');
        var addForm = document.createElement('div');       
        addForm.id ="addformid";
        addForm.innerHTML = makeSightAddEditForm(null, null, null, null, null, null, null, null, null, 1, null);
        mapdiv.appendChild(addForm);

        var newSight = new Object();
        newSight.x = lonlat[0];
        newSight.y = lonlat[1];
        pictureformcreate();
        var AddButton = document.getElementById('add-button');
        AddButton.onclick = function()
        {            
            newSight.SightName = document.getElementById('inputSightName').value;
            newSight.SightDescription = document.getElementById('inputDescription').value;
            newSight.SightType =  document.getElementById('inputSightType').value;
            newSight.SightStreet = document.getElementById('inputSightStreet').value;
            newSight.SightNumber = document.getElementById('inputSightNumber').value;
            newSight.SightLitera = document.getElementById('inputSightLitera').value;
            newSight.SightPhone = document.getElementById('inputSightPhone').value;
            newSight.SightSite = document.getElementById('inputSightSite').value;
            newSight.SightWorkTime = document.getElementById('inputSightWorkTime').value; 
            addPic();
            addSight(newSight).done(function(result){
              location.reload();
            }).fail(function() {                         
            }); 
            mapdiv.removeChild(addForm);
            
            

        }



      },

      addSight = function(sight)
      {
          nsight = JSON.stringify(sight);
          return $.post('?r=site/add-sight', {
                'foo': 'foo',
                 nsight: nsight
              } /*,
              //callback function
                function(resp) {
                  console.log(resp);  
                }*/
              );
      },
      

      initMap = function() {
            var map = new ol.Map({
              layers: [new ol.layer.Tile({
             
            source: new ol.source.OSM()  // ol.source.MapQuest({key: 'pMI8BBoMS5EjAZvjPVyusRwAdkYgza1Y', layer: 'osm'})
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
         // stopEvent: false,
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

      initWrap = function(content){
        var wrap = document.createElement('iframe');

        //wrap.setAttribute("id", "wrap");
        
        wrap.src = "data:text/html;charset=utf-8," + content;
        wrap.style.border = 'none'; 
        wrap.style.width = '31vw';
        wrap.style.height ='31vw';

        return wrap;
      },
      



      popupCreate = function(feature, element, map, evt, popup)
      {         
                if (feature) {
                // admin
                getAdmin().done(function(adm)
                {
                  if (adm=="1")
                  {
                    var delbutton = document.getElementById("delbutton");
                    delbutton.style.visibility = "visible";
                    delbutton.onclick = function()
                    { 
                      deletefeature(feature);
                    };
                    var editbutton = document.getElementById("editbutton");
                    editbutton.style.visibility = "visible";
                    editbutton.onclick = function()
                    { 
                      editfeature(feature);
                    };
                  }

                }).fail(function() 
                  {
                  // An error occurred
                  });


            element.popover('destroy');
            map.setView(new ol.View({center: ol.proj.fromLonLat([feature.get('posX'),feature.get('posY') ]), zoom: parseInt(map.getView().getZoom()) }));
            sightj = JSON.parse(feature.get('sightjson'));
            var STId = sightj["SightId"];
            var contactj;
            getAdress(STId).done(function(adress){
                  if (adress){
                             //var contact = contactParser(STId);


                                getContact(STId).done(function(contact){
                                if (contact == ""){   
                                   var content = makehtmlcontent(sightj, contact, adress);
                                                                               
                                    element.popover({
                                      'placement': 'left',
                                      'html': true,
                                      'content': content
                                      
                                    });                                    
                                    popup.setPosition(evt.coordinate);

                                    element.popover('show');
                                 
                                }
                                else if (contact)
                                {                 
                                var content = makehtmlcontent(sightj, contact, adress);
                                  element.popover({
                                    'placement': 'left',
                                    'html': true,
                                    'content': content

                                    /*function() {
                                          return '<iframe src="./views/site/content.php" style="border:none" width="32vw" onload="adjustPopover(this)">'+'</iframe>'; 
                                        }*/
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
         var delbutton = document.getElementById("delbutton");
         if (delbutton!=null)
         {
         delbutton.style.visibility = "hidden";
         var editbutton = document.getElementById("editbutton");
         editbutton.style.visibility = "hidden";
       }
        }

      },



      initModule = function() {

          var map = initMap();
          
          getTypes().done(function(result) {
              // Code depending on result
            if(result){    
                var SummDok = document.getElementById('checkboxes');      
                for (var i = 0; i < result.length; i++) {
                    var checkboxi = document.createElement('input');
                    SummDok.appendChild(checkboxi);
                    checkboxi.type = 'checkbox';
                    checkboxi.id = result[i].SightTypeId;
                    var labeli = document.createElement('label');
                    SummDok.appendChild(labeli);
                    labeli.innerHTML = result[i].TypeName + "&nbsp";
                  };  
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


             
                getAdmin().done(function(adm)
                {
                  if (adm=="1")
                  {
                    createButtons();

                    
                  }

                  map.on('click', function(evt) {
                  //var element = popup.getElement();


                    
                    var feature =  getClickfeature(evt,map);
                    popupCreate(feature, $(element), map, evt, popup);
                    if (adm=="1")
                    {
                      var mapdiv = document.getElementById('mapdiv');
                    var addForm = document.getElementById('addformid');
                    if (addForm!=null)
                    mapdiv.removeChild(addForm);
                    var editForm = document.getElementById('editformid');
                    if (editForm!=null)
                    mapdiv.removeChild(editForm);

                      var addObj = document.getElementById("addObj");
                      if ((addObj.checked)&&(!(feature)))
                      {
                        //var lonlat = evt.coordinate;
                        //var mapdiv = document.getElementById('mapdiv');
                        var editForm = document.getElementById('editformid');
                        if (editForm!=null)
                        mapdiv.removeChild(editForm);
                        var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
                        addfeature(lonlat);
                      }

                      
                      addObj.checked = false;
                    }


                  });

                map.on('pointermove', function(e) {
                if (e.dragging) {
                  $(element).popover('destroy');
                  if (adm=="1")
                    {
                  var delbutton = document.getElementById("delbutton");
                  delbutton.style.visibility = "hidden";
                  var editbutton = document.getElementById("editbutton");
                  editbutton.style.visibility = "hidden";
                  var mapdiv = document.getElementById('mapdiv');
                  var editForm = document.getElementById('editformid');
                  if (editForm!=null)
                  mapdiv.removeChild(editForm);
                  }
                  return;
                }
                  var pixel = map.getEventPixel(e.originalEvent);
                  var hit = map.hasFeatureAtPixel(pixel);
                  map.getTarget().style.cursor = hit ? 'pointer' : '';
                });

                }).fail(function() 
                  {
                  // An error occurred
                  });

                
               




              }
              
            }).fail(function() {
                  // An error occurred
            });    

        };

      	return {
      		initModule: initModule,
      	};
}());




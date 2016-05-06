<?php
use app\models\Users;
use app\models\Sight;
use app\models\Adress;
use app\models\Contact;
use app\models\SightType;
use yii\helpers\Json;
use app\views\site\functions;

/* @var $this yii\web\View */

$this->title = 'Туристическая карта Самары';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row" >
          <?php
              $id = $_POST["id"];
        $Sight = Sight::find()->where(['SightId'=>$id])->one();
        if (($Sight->ContactId)!=(Null))
        {
        $contactid = $Sight->ContactId;
        $contact = Contact::find()->where(['ContactId'=>$contactid])->one();
        }
        else $contact = null;

        $juyui = json_encode($contact)
          ?>
          <script>
          var forose = JSON.parse('<?php echo $juyui?>')
          </script>

                <h2>Туристическая карта Самары</h2>
                <div id="map" class="map" style="width:100%; max-height:500px">
                <div id="popup"></div>
                </div>
                <div id="checkboxes"><input type="checkbox" id="9"> </div>
        
        


    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
   <script type="text/javascript">
 //  var stringik = laba.module.getSights();
/*
<?php
$model = Sight::find()->asArray()->all(); 
$jop = json_encode($model, JSON_UNESCAPED_UNICODE);
//$jop = SiteController::actionGetSights(); люкс, но почему это не работает?
?>


var sightlist = JSON.parse('<?php echo $jop?>', function(key,value){
  if ((key=='SightX') || (key=='SightY')) return parseFloat(value);
  //if ((key='SightId')||(key='SightTypeId')||(key='ContactId')||(key='AdressId')||(key='Number')) return parseInt(value);
  return value;
})
;



function adjustPopover(iframe) {
  iframe.style.height='auto';   
  iframe.style.height = '55vh';

}

function makehtmlcontent(sightj)
{
    $.ajax({ 
         url: 'contentmaker.php',
         data: {test: sightj},
         //type: 'post',
         success: function(output) {
                      alert(output);
                  }        
    });
}

*/
/*
var element = document.getElementById('popup');
var popup = new ol.Overlay({
        element: element,
        positioning: 'bottom-center',
        stopEvent: false
});
map.addOverlay(popup);
*/
      // display popup on click
/*
      map.on('click', function(evt) {
        var feature = map.forEachFeatureAtPixel(evt.pixel,
            function(feature) {
              return feature;
            });
        
        if (feature) {
            
            map.setView(new ol.View({center: ol.proj.fromLonLat([feature.get('posX'),feature.get('posY') ]), zoom: parseInt(map.getView().getZoom()) }));
          

         makehtmlcontent(feature.get('sightjson'));

          $(element).popover({
            'placement': 'left',
            'html': true,
            'content': function() {
                  return '<iframe src="/content.php" style="border:none" width="100%" onload="adjustPopover(this)">'+'</iframe>'; 
                }
           });
            popup.setPosition(evt.coordinate);

           var str = feature.get('name');
          $(element).popover('show');
        } else {
          $(element).popover('destroy');
        }
      });

      // change mouse cursor when over marker
      map.on('pointermove', function(e) {
        if (e.dragging) {
          $(element).popover('destroy');
          return;
        }
        var pixel = map.getEventPixel(e.originalEvent);
        var hit = map.hasFeatureAtPixel(pixel);
        map.getTarget().style.cursor = hit ? 'pointer' : '';
      });


*/





    </script>

                
            
        </div>

    </div>
</div>

                
            
        </div>

    </div>
</div>

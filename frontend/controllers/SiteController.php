<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use app\models\Sight;
use app\models\Sighttype;
use app\models\Adress;
use app\models\Contact;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
            //return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

        public function actionPicEdit()
    {
        $id = $_POST['id'];
        $path = "data/sight".$id.".jpg";
        if (!@copy($_FILES['file']['tmp_name'], $path))
            echo 'Фото не прикреплено';
        else
echo 'Загрузка удачна';
    }

        public function actionPicAdd()
    {
        $maxidsight = Sight::find()->orderBy(['SightId' => SORT_DESC])->one();
            $id = $maxidsight->SightId;
            $id +=1;
        $path = "data/sight".$id.".jpg";
        if (!@copy($_FILES['file']['tmp_name'], $path))
            echo 'Фото не прикреплено';
        else
echo 'Загрузка удачна';
    }            

        public function actionGetType() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = $_POST["id"];
        $Sight = Sight::find()->where(['SightId'=>$id])->one();
        $typeid = $Sight->SightTypeId;
        $type = SightType::find()->where(['SightTypeId'=>$typeid])->one();

        return $type;
    }

    public function actionGetSights() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $sights = Sight::find()
            ->asArray()
            ->all();
        return $sights;
    }

    public function actionGetTypes() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $types = SightType::find()
            ->asArray()
            ->all();
        return $types;
    }

    public function actionAddSight() {        
        $r = false;
        if (isset($_POST['nsight'])) {
            $jsight = json_decode($_POST['nsight']);

            $maxidsight = Sight::find()->orderBy(['SightId' => SORT_DESC])->one();
            $id = $maxidsight->SightId;

            $id +=1;
            //$id = Sight::find()->select(['SightId'])->max();
            
            $name = $jsight->SightName;
            //$name = $jsight["Sightname"];
            
            $description = $jsight->SightDescription;
            $type = $jsight->SightType;            
            $street = $jsight->SightStreet;
            $number = $jsight->SightNumber;
            $litera = $jsight->SightLitera;
            $phone = $jsight->SightPhone;
            $site = $jsight->SightSite;
            $worktime = $jsight->SightWorkTime;
            $x = $jsight->x;
            $y = $jsight->y;
            
            
            //TypeTable
            $Typeid = null;            
            $sightType = SightType::find()->where(['TypeName'=>$type])->one();
            if ($sightType==null)
            {
            $maxidtype = SightType::find()->orderBy(['SightTypeId' => SORT_DESC])->one();
            $Typeid = $maxidtype->SightTypeId;
          
            //$Typeid = SightType::find()->select(['SightId'])->max();   
            $Typeid +=1;
            
            $sighttype=new SightType;
            $sighttype->SightTypeId = $Typeid;
            $sighttype->TypeName =$type;
            $sighttype->save();
            }
            else
            {
                $Typeid = $sightType->SightTypeId;
            }

            //AdressTable
            $Adressid = null;
            $adress = Adress::findOne(['Street'=>$street, 'Litera'=>$litera,'Number'=>$number]);
            if ($adress==null)
            {
            $maxidadress = Adress::find()->orderBy(['AdressId' => SORT_DESC])->one();
            $Adressid = $maxidadress->AdressId;
            //$Adressid = Adress::find()->select(['SightId'])->max();   
            $Adressid += 1;
            
            $adress= new Adress;
            $adress->AdressId = $Adressid;
            $adress->Street = $street;
            $adress->Litera = $litera;
            $adress->Number = $number;
            $adress->save();
            }
            else
            {
                $Adressid = $adress->AdressId;
            }
 
            //ContactTable
            $Contactid =null;

            if (!( ($phone == null) && ($site == null) && ($worktime == null) ))
            {                
                $contact = Contact::findOne(['phone'=>$phone, 'site'=>$site, 'WorkTime'=>$worktime]);
                if ($contact==null)
                {
                $maxidcontact = Contact::find()->orderBy(['ContactId' => SORT_DESC])->one();
                $Contactid = $maxidcontact->ContactId;
                //$Contactid = Contact::find()->select(['ContactId'])->max();   
                $Contactid += 1;
                $contact= new Contact;
                $contact->ContactId = $Contactid;
                $contact->phone = $phone;
                $contact->site = $site;
                $contact->WorkTime = $worktime;
                $contact->save();
                }
                else
                {
                    $Contactid = $contact->ContactId;
                }   
            }
        
            $sight = new Sight;
            $sight->SightId = $id;
            $sight->Sightname = $name;
            $sight->descriptions = $description;
            $sight->SightTypeId = $Typeid;
            
            if ($Contactid != null)
            {
                $sight->ContactId = $Contactid;
            }
            if ($Adressid != null)
            {
                $sight->AdressId = $Adressid;
            }
            $sight->SightX = $x;
            $sight->SightY = $y;
            $sight->save();

            if ($Adressid == null){
                $r = false;
            }      
            else {
                $r = true;
            }



            

            //$number = $_POST["SightNumber"];
            
        
        }        
        return $r;

    }


    public function actionEditSight() {        
        $r = false;
        if (isset($_POST['nsight'])) {
            $jsight = json_decode($_POST['nsight']);

            $id = $jsight->id;            
            //$id = Sight::find()->select(['SightId'])->max();
            
            $name = $jsight->SightName;
            //$name = $jsight["Sightname"];
            
            $description = $jsight->SightDescription;
            $type = $jsight->SightType;            
            $street = $jsight->SightStreet;
            $number = $jsight->SightNumber;
            $litera = $jsight->SightLitera;
            $phone = $jsight->SightPhone;
            $site = $jsight->SightSite;
            $worktime = $jsight->SightWorkTime;
            $x = $jsight->x;
            $y = $jsight->y;
            
            
            //TypeTable
            $Typeid = null;            
            $sightType = SightType::find()->where(['TypeName'=>$type])->one();
            if ($sightType==null)
            {
            $maxidtype = SightType::find()->orderBy(['SightTypeId' => SORT_DESC])->one();
            $Typeid = $maxidtype->SightTypeId;
          
            //$Typeid = SightType::find()->select(['SightId'])->max();   
            $Typeid +=1;
            
            $sighttype=new SightType;
            $sighttype->SightTypeId = $Typeid;
            $sighttype->TypeName =$type;
            $sighttype->save();
            }
            else
            {
                $Typeid = $sightType->SightTypeId;
            }

            //AdressTable
            $Adressid = null;
            $adress = Adress::findOne(['Street'=>$street, 'Litera'=>$litera,'Number'=>$number]);
            if ($adress==null)
            {
            $maxidadress = Adress::find()->orderBy(['AdressId' => SORT_DESC])->one();
            $Adressid = $maxidadress->AdressId;
            //$Adressid = Adress::find()->select(['SightId'])->max();   
            $Adressid += 1;
            
            $adress= new Adress;
            $adress->AdressId = $Adressid;
            $adress->Street = $street;
            $adress->Litera = $litera;
            $adress->Number = $number;
            $adress->save();
            }
            else
            {
                $Adressid = $adress->AdressId;
            }
 
            //ContactTable
            $Contactid =null;

            if (!( ($phone == null) && ($site == null) && ($worktime == null) ))
            {                
                $contact = Contact::findOne(['phone'=>$phone, 'site'=>$site, 'WorkTime'=>$worktime]);
                if ($contact==null)
                {
                $maxidcontact = Contact::find()->orderBy(['ContactId' => SORT_DESC])->one();
                $Contactid = $maxidcontact->ContactId;
                //$Contactid = Contact::find()->select(['ContactId'])->max();   
                $Contactid += 1;
                $contact= new Contact;
                $contact->ContactId = $Contactid;
                $contact->phone = $phone;
                $contact->site = $site;
                $contact->WorkTime = $worktime;
                $contact->save();
                }
                else
                {
                    $Contactid = $contact->ContactId;
                }   
            }
        
            $sight = Sight::findOne(['SightId'=>$id]);;            
            $sight->Sightname = $name;
            $sight->descriptions = $description;
            $sight->SightTypeId = $Typeid;
            
            if ($Contactid != null)
            {
                $sight->ContactId = $Contactid;
            }
            if ($Adressid != null)
            {
                $sight->AdressId = $Adressid;
            }

            $sight->save();

            if ($Adressid == null){
                $r = false;
            }      
            else {
                $r = true;
            }



            

            //$number = $_POST["SightNumber"];
            
        
        }        
        return $r;

    }


    
    public function actionDeleteSight() {
        if (isset($_POST['SightId'])) {
            $sightid = $_POST['SightId'];
            $sight = Sight::find()->where(['SightId'=>$sightid])->one();
            $adressid = $sight->AdressId;
            $contactid = $sight->ContactId;

            $sight->delete();
        }
    }

    public function actionGetAdress() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = $_POST["id"];
        $Sight = Sight::find()->where(['SightId'=>$id])->one();
        $adressid = $Sight->AdressId;
        $adress = Adress::find()->where(['AdressId'=>$adressid])->one();

        return $adress;
    }

    public function actionGetContact() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = $_POST["id"];
        $Sight = Sight::find()->where(['SightId'=>$id])->one();
        if (($Sight->ContactId)!=null)
        {
        $contactid = $Sight->ContactId;
        $contact = Contact::find()->where(['ContactId'=>$contactid])->one();
        }
        else $contact = '';


        return $contact;
    }

    public function actionIsAdmin()
    {
        $a123 = 1;
        $a124 = 0;
        if (!\Yii::$app->user->isGuest) {
            return $a123;
        }
        return  $a124;
    }

    public function actionGetContent() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset($_POST['sightj'])) {
            $jsight = $_POST['sightj'];

            $id = $jsight["SightId"];
            $name = $jsight["Sightname"];
            $description = $jsight["descriptions"];
            $typeid = $jsight["SightTypeId"];
            $adress = $_POST['adress'];
            $contact = $_POST['contact'];
        }

/*
   &lt;?php
                    use vendor\\yiisoft\\yii2-bootstrap\\BootstrapAsset;
                    BootstrapAsset::register($this); 
                ?&gt;
*/
        $result = "
                <html>

                <body>

                <img id =\"ima\" src=\"http:\/\/frontend.dev\/data\/sight".$id.".jpg\" width=\"90%\" height=\"auto\" style=\"align:center\" ><br /><br />
                    <p>
                    <strong>".$name."</strong><br />
                    ".$description."
                    </p>
                    <div width=\"45%\"  >
                        <a id=\"adress-btn\" href=\"#\" class=\"btn btn-info\" role=\"button\" onclick=\"openbox('adress', 'adress-btn'); return false\">Адреса</a>
                        <div id=\"adress\" style=\"display: none;\">
                            <p>Адрес: ".$adress["Street"]."  ".$adress["Number"]." ".$adress["Litera"]."</p>
                        </div>
                    </div><br />
                    ";

                    if ($contact != '')
                    {
                        
                        $result .= "
                    <div width=\"45%\" >
                        <a id=\"contact-btn\" href=\"#\" class=\"btn btn-info\" role=\"button\" onclick=\"openbox('contact', 'contact-btn'); return false\">Контакты</a>
                        <div id=\"contact\" style=\"display: none;\">
                            <p>Телефон: ".$contact["phone"]."</p>
                            <p>Сайт: ".$contact["site"]."</p>
                            <p>Рабочее время: ".$contact["WorkTime"]."</p>
                        </div>
                    </div>
                    ";
                    }
                    $result .= "
                
                <script type=\"text/javascript\">
                function openbox(id, btnid){
        document.getElementById(btnid).style.display = 'none';

            display = document.getElementById(id).style.display;
            if(display=='none'){
               document.getElementById(id).style.display='inline-block';
            }else{
               document.getElementById(id).style.display='none';
            }
        }

        </script>
        </body>
        </html>
        "; 


        return $result;

        
    }



}

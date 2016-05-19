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

    public function actionGetCheckboxes() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $typic = $_POST["types"];
        $types = json_decode($typic);
        $typeslength = count($types);
        $checkboxes = "";          
        for ($i=0; $i <= $typeslength-1 ; $i++) {    
            $name = $types[$i]->{'TypeName'};
            $id = $i+1;
          $checkboxes .= "<input type=\"checkbox\" id=\"$id\" > $name ";
        }      
        return $checkboxes;
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

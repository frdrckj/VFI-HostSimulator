<?php

namespace app\controllers;

use Yii;
use app\models\Host;
use app\models\HostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HostController implements the CRUD actions for Host model.
 */
class HostController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Host models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new HostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Host model.
     * @param integer $host_id
     * @param string $host_nii
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($host_id, $host_nii) {
        return $this->render('view', [
                    'model' => $this->findModel($host_id, $host_nii),
        ]);
    }

    /**
     * Creates a new Host model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Host();

        if (($model->load(Yii::$app->request->post())) && ($model->validate())) {
            $hostCheck = Host::find()->where(['host_nii' => $model->host_nii])->count();
            if ($hostCheck == 0) {
                if ($model->save()) {
                    return $this->redirect(['view', 'host_id' => $model->host_id, 'host_nii' => $model->host_nii]);
                } else {
                    Yii::$app->session->setFlash('info', 'Simpan gagal dilakukan!');
                }
            } else {
                Yii::$app->session->setFlash('info', 'Routing Sudah Ada!');
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Host model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $host_id
     * @param string $host_nii
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($host_id, $host_nii) { //NOSONAR
        $model = $this->findModel($host_id, $host_nii);

        if (($model->load(Yii::$app->request->post())) && ($model->validate())) {
            $updateAllowed = false;
            $host = Host::find()->where(['host_nii' => $model->host_nii])->one();
            if ($host instanceof Host) {
                if ($host->host_id == $model->host_id) {
                    $updateAllowed = true;
                }
            } else {
                $updateAllowed = true;
            }
            if ($updateAllowed) {
                if ($model->save()) {
                    return $this->redirect(['view', 'host_id' => $model->host_id, 'host_nii' => $model->host_nii]);
                } else {
                    Yii::$app->session->setFlash('info', 'Simpan gagal dilakukan!');
                }
            } else {
                Yii::$app->session->setFlash('info', 'Routing Sudah Ada!');
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Host model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $host_id
     * @param string $host_nii
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($host_id, $host_nii) {
        $this->findModel($host_id, $host_nii)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Host model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $host_id
     * @param string $host_nii
     * @return Host the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($host_id, $host_nii) {
        if (($model = Host::findOne(['host_id' => $host_id, 'host_nii' => $host_nii])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCacertdownload() {
        $file = Yii::$app->basePath . '/assets/cacert.pem';
        if (file_exists($file)) {
            Yii::$app->response->sendFile($file);
        }
    }

}

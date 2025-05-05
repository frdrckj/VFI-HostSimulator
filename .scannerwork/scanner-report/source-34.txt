<?php

namespace app\controllers;

use Yii;
use app\models\Log;
use app\models\LogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogController implements the CRUD actions for Log model.
 */
class LogController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * Lists all Log models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Log model.
     * @param integer $id_log
     * @param integer $log_bulan
     * @param integer $log_tahun
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_log, $log_bulan, $log_tahun)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_log, $log_bulan, $log_tahun),
        ]);
    }

    /**
     * Creates a new Log model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Log();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_log' => $model->id_log, 'log_bulan' => $model->log_bulan, 'log_tahun' => $model->log_tahun]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Log model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id_log
     * @param integer $log_bulan
     * @param integer $log_tahun
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_log, $log_bulan, $log_tahun)
    {
        $model = $this->findModel($id_log, $log_bulan, $log_tahun);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_log' => $model->id_log, 'log_bulan' => $model->log_bulan, 'log_tahun' => $model->log_tahun]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Log model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id_log
     * @param integer $log_bulan
     * @param integer $log_tahun
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_log, $log_bulan, $log_tahun)
    {
        $this->findModel($id_log, $log_bulan, $log_tahun)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Log model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id_log
     * @param integer $log_bulan
     * @param integer $log_tahun
     * @return Log the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_log, $log_bulan, $log_tahun)
    {
        if (($model = Log::findOne(['id_log' => $id_log, 'log_bulan' => $log_bulan, 'log_tahun' => $log_tahun])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

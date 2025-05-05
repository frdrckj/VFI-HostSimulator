<?php

namespace app\controllers;

use Yii;
use app\models\CardAccount;
use app\models\CardAccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CardaccountController implements the CRUD actions for CardAccount model.
 */
class CardaccountController extends Controller
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
     * Lists all CardAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CardAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CardAccount model.
     * @param integer $cr_acc_id
     * @param string $cr_acc_card_no
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cr_acc_id, $cr_acc_card_no)
    {
        return $this->render('view', [
            'model' => $this->findModel($cr_acc_id, $cr_acc_card_no),
        ]);
    }

    /**
     * Creates a new CardAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CardAccount();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CardAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $cr_acc_id
     * @param string $cr_acc_card_no
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cr_acc_id, $cr_acc_card_no)
    {
        $model = $this->findModel($cr_acc_id, $cr_acc_card_no);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $model->cr_acc_balance = intval($model->cr_acc_balance);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CardAccount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $cr_acc_id
     * @param string $cr_acc_card_no
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cr_acc_id, $cr_acc_card_no)
    {
        $this->findModel($cr_acc_id, $cr_acc_card_no)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CardAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $cr_acc_id
     * @param string $cr_acc_card_no
     * @return CardAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cr_acc_id, $cr_acc_card_no)
    {
        if (($model = CardAccount::findOne(['cr_acc_id' => $cr_acc_id, 'cr_acc_card_no' => $cr_acc_card_no])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

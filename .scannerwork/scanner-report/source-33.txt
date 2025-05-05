<?php

namespace app\controllers;

use app\components\DbTransaction;
use app\models\Host;
use app\models\Isomsg;
use app\models\Isotrx;
use app\models\IsotrxSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * IsotrxController implements the CRUD actions for Isotrx model.
 */
class IsotrxController extends Controller {

    const ISO_SAME = 'Sama seperti request';

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
     * Lists all Isotrx models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new IsotrxSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchModel->hostOptions = ArrayHelper::map(Host::find()->all(), 'host_id', 'host_name');

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Isotrx model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $isomsg = Isomsg::find()->where(['isomsg_isotrx_id' => $id])->orderBy(['LENGTH(isomsg_bit)' => SORT_ASC, 'isomsg_bit' => SORT_ASC])->all();
        $model->bitmapData = [];
        foreach ($isomsg as $bitmap) {
            if ($bitmap->isomsg_reply_exist == '1') {
                $tmp = 'Respon jika ada data, ';
            } else {
                $tmp = 'Selalu respon, ';
            }
            if ($bitmap->isomsg_same == '1') {
                $tmp .= self::ISO_SAME;
            } else if ($bitmap->isomsg_random == '1') {
                $tmp .= 'Sistem';
                if ($bitmap->isomsg_feature) {
                    $tmp .= (' Using Feature ' . Yii::$app->params['appFeatureLists'][$bitmap->isomsg_bit][$bitmap->isomsg_feature]);
                }
            } else {
                $tmp .= 'Costum, ';
                if ($bitmap->isomsg_hexa == '1') {
                    $tmp .= 'Hexa ';
                } else {
                    $tmp .= 'Text ';
                }
                $tmp .= $bitmap->isomsg_data;
            }
            $model->bitmapData[] = ['label' => 'Bit ' . $bitmap->isomsg_bit . ' - ' . $model->bitmapDefine[intval($bitmap->isomsg_bit)], 'value' => $tmp];
        }

        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new Isotrx model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() { //NOSONAR
        $model = new Isotrx();
        $model->hostOptions = ArrayHelper::map(Host::find()->all(), 'host_id', 'host_name');
        $model->typeOptions = ['S' => self::ISO_SAME, 'R' => 'Sistem', 'C' => 'Custom'];
        $model->featureOptions = Yii::$app->params['appFeatureLists'];

        if (($model->load(Yii::$app->request->post())) && ($model->validate())) {
            $isotrxCheck = Isotrx::find()->where(['isotrx_host_id' => $model->isotrx_host_id, 'isotrx_msg_type' => $model->isotrx_msg_type, 'isotrx_proc_code' => $model->isotrx_proc_code])->count();
            if ($isotrxCheck == 0) {
                $transaction = new DbTransaction();
                $transaction->add(Isotrx::getDb()->beginTransaction());
                $transaction->add(Isomsg::getDb()->beginTransaction());
                if ($model->save()) {
                    foreach ($model->status as $key => $value) {
                        if ($value == '1') {
                            $isomsg = new Isomsg();
                            $isomsg->isomsg_isotrx_id = $model->isotrx_id;
                            $isomsg->isomsg_bit = strval($key + 1);
                            if ((isset($model->replyExist[$key])) && ($model->replyExist[$key] == '1')) {
                                $isomsg->isomsg_reply_exist = '1';
                            }
                            if ((isset($model->hexa[$key])) && ($model->hexa[$key] == '1')) {
                                $isomsg->isomsg_hexa = '1';
                            }
                            if (isset($model->type[$key])) {
                                if ($model->type[$key] == 'S') {
                                    $isomsg->isomsg_same = '1';
                                } else if ($model->type[$key] == 'R') {
                                    $isomsg->isomsg_random = '1';
                                    if ((isset($model->feature[$key])) && ($model->feature[$key])) {
                                        $isomsg->isomsg_feature = $model->feature[$key];
                                    }
                                } else {
                                    $isomsg->isomsg_data = $model->data[$key];
                                }
                            }
                            if (!$isomsg->save()) {
                                goto FAILED_DATABASE; //NOSONAR
                            }
                            unset($isomsg);
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->isotrx_id]);
                } else {
// GOTO Label FAILED_DATABASE
                    FAILED_DATABASE:
                    $transaction->rollback();
                    Yii::$app->session->setFlash('info', 'Simpan gagal dilakukan!');
                }
            } else {
                Yii::$app->session->setFlash('info', 'MTI dan Processing Code Sudah Ada!');
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Isotrx model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) { //NOSONAR
        $model = $this->findModel($id);
        $model->hostOptions = ArrayHelper::map(Host::find()->all(), 'host_id', 'host_name');
        $model->typeOptions = ['S' => self::ISO_SAME, 'R' => 'Sistem', 'C' => 'Custom'];
        $model->featureOptions = Yii::$app->params['appFeatureLists'];

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $updateAllowed = false;
                $isotrx = Isotrx::find()->where(['isotrx_host_id' => $model->isotrx_host_id, 'isotrx_msg_type' => $model->isotrx_msg_type, 'isotrx_proc_code' => $model->isotrx_proc_code])->one();
                if ($isotrx instanceof Isotrx) {
                    if ($isotrx->isotrx_id == $model->isotrx_id) {
                        $updateAllowed = true;
                    }
                } else {
                    $updateAllowed = true;
                }
                if ($updateAllowed) {
                    $transaction = new DbTransaction();
                    $transaction->add(Isotrx::getDb()->beginTransaction());
                    $transaction->add(Isomsg::getDb()->beginTransaction());
                    if ($model->save()) {
                        $isomsg = Isomsg::find()->where(['isomsg_isotrx_id' => $id])->all();
                        foreach ($isomsg as $bitmap) {
                            if (($model->status[intval($bitmap->isomsg_bit)] == '0') && (!$bitmap->delete())) {
                                goto FAILED_DATABASE; //NOSONAR
                            }
                        }
                        foreach ($model->status as $key => $value) {
                            if ($value == '1') {
                                $isomsg = Isomsg::find()->where(['isomsg_isotrx_id' => $id, 'isomsg_bit' => strval($key + 1)])->one();
                                if (!($isomsg instanceof Isomsg)) {
                                    $isomsg = new Isomsg();
                                    $isomsg->isomsg_isotrx_id = $model->isotrx_id;
                                    $isomsg->isomsg_bit = strval($key + 1);
                                }
                                if ((isset($model->replyExist[$key])) && ($model->replyExist[$key] == '1')) {
                                    $isomsg->isomsg_reply_exist = '1';
                                } else {
                                    $isomsg->isomsg_reply_exist = '0';
                                }
                                if ((isset($model->hexa[$key])) && ($model->hexa[$key] == '1')) {
                                    $isomsg->isomsg_hexa = '1';
                                } else {
                                    $isomsg->isomsg_hexa = '0';
                                }
                                if (isset($model->type[$key])) {
                                    if ($model->type[$key] == 'S') {
                                        $isomsg->isomsg_same = '1';
                                        $isomsg->isomsg_random = '0';
                                        $isomsg->isomsg_data = null;
                                        $isomsg->isomsg_feature = null;
                                    } else if ($model->type[$key] == 'R') {
                                        $isomsg->isomsg_same = '0';
                                        $isomsg->isomsg_random = '1';
                                        $isomsg->isomsg_data = null;
                                        if ((isset($model->feature[$key])) && ($model->feature[$key])) {
                                            $isomsg->isomsg_feature = $model->feature[$key];
                                        } else {
                                            $isomsg->isomsg_feature = null;
                                        }
                                    } else {
                                        $isomsg->isomsg_same = '0';
                                        $isomsg->isomsg_random = '0';
                                        $isomsg->isomsg_data = $model->data[$key];
                                        $isomsg->isomsg_feature = null;
                                    }
                                }
                                if (!$isomsg->save()) {
                                    goto FAILED_DATABASE; //NOSONAR
                                }
                                unset($isomsg);
                            }
                        }
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->isotrx_id]);
                    } else {
// GOTO Label FAILED_DATABASE
                        FAILED_DATABASE:
                        $transaction->rollback();
                        Yii::$app->session->setFlash('info', 'Simpan gagal dilakukan!');
                    }
                } else {
                    Yii::$app->session->setFlash('info', 'MTI dan Processing Code Sudah Ada!');
                }
            }
        } else {
            $isomsg = Isomsg::find()->where(['isomsg_isotrx_id' => $id])->all();
            $model->status = [];
            $model->replyExist = [];
            $model->type = [];
            $model->hexa = [];
            $model->data = [];
            $model->feature = [];
            foreach ($isomsg as $bitmap) {
                $bit = intval($bitmap->isomsg_bit) - 1;
                $model->status[$bit] = '1';
                $model->replyExist[$bit] = $bitmap->isomsg_reply_exist;
                $model->hexa[$bit] = $bitmap->isomsg_hexa;
                $model->data[$bit] = $bitmap->isomsg_data;
                $model->feature[$bit] = $bitmap->isomsg_feature;
                if ($bitmap->isomsg_same == '1') {
                    $model->type[$bit] = 'S';
                } else if ($bitmap->isomsg_random == '1') {
                    $model->type[$bit] = 'R';
                } else {
                    $model->type[$bit] = 'C';
                }
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Isotrx model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Isotrx model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Isotrx the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Isotrx::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

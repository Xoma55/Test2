<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 28.10.2016
 * Time: 12:34
 */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Пользователь';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-user">

    <?php \yii\widgets\Pjax::begin(['id' => 'users']); ?>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'=>[
            'friend_id','username','email',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{addToFriend}',
                'buttons' => [
                    'addToFriend' => function($url,$model,$key) {
                            return Html::a('<span class="glyphicon glyphicon glyphicon-plus-sign"></span>',
                                Yii::$app->urlManager->createUrl(['site/user','addToFriend'=>$model->friend_id]),
                                ['title' => 'Добавить в друзья']);
                    }
//
                ],

            ],


        ]
    ]);
    ?>

    <?php \yii\widgets\Pjax::end(); ?>

</div>
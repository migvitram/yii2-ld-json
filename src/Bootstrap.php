<?php

namespace migvitram\ldJson;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Module;

class Bootstrap implements BootstrapInterface
{
    /** @var array Model's map */
    private $_modelMap = [];

    /**
     * To bootstrap out module
     *
     * @param Application $app
     */
    public function bootstrap($app)
    {
        if ( $app->hasModule('ldJson') && ($module = $app->getModule('ldJson')) instanceof Module ) {

            // declare the models
            $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);

            foreach ($this->_modelMap as $name => $definition) {

                $class = "migvitram\\ldJson\\classes\\models\\" . $name;
                Yii::$container->set($class, $definition);

                $modelName = is_array($definition) ? $definition['class'] : $definition;
                $module->modelMap[$name] = $modelName;
            }

            // adding route rules for module
            $configUrlRule = [
                'rules'  => $module->urlRules,
            ];

            $configUrlRule['routePrefix'] = 'ldJson';
            $configUrlRule['class'] = 'yii\web\GroupUrlRule';
            $rule = Yii::createObject($configUrlRule);

            $app->urlManager->addRules([$rule], false);
        }
    }
}
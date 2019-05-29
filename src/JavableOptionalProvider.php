<?php
namespace Junichimura\LaravelJavableOptional;

use Closure;
use Illuminate\Support\Optional;
use Illuminate\Support\ServiceProvider;

class JavableOptionalProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        // java8 like Optional methods mix in to Optional Class
        Optional::mixin(new class {

            /**
             * @return mixed
             */
            public function get()
            {
                return function () {
                    $this->value;
                };
            }

            /**
             * @return bool
             */
            public function isPresent()
            {
                return function () {
                    return isset($this->value);
                };
            }

            /**
             * optionalの値が存在している場合に実行する処理クロージャで渡す。
             *
             * @param Closure $existsClosure
             * @param Closure $notExistsClosure
             * @return mixed
             */
            public function ifPresent()
            {
                return function () {
                    list($existsClosure, $notExistsClosure) = func_get_args();

                    if (isset($this->value) && $existsClosure instanceof Closure) {
                        if (is_object($this->value)) {
                            return $existsClosure($this);
                        } else {
                            return $existsClosure($this->value);
                        }
                    } elseif (isset($this->value)) {
                        return $this->value;
                    } elseif ($notExistsClosure instanceof Closure) {
                        return $notExistsClosure();
                    } else {
                        return $this->value;
                    }
                };
            }

            /**
             * @return mixed
             */
            public function orElse()
            {
                return function () {
                    list($defaultValue) = func_get_args();
                    if (!isset($defaultValue)) {
                        throw new \InvalidArgumentException('orElseメソッドの引数はnullではいけない');
                    }

                    if (is_object($this->value)) {
                        return $this->value;
                    } else {
                        return $defaultValue;
                    }
                };
            }

            /**
             * @return mixed
             */
            public function orElseGet()
            {
                return function () {
                    list($defaultValueClosure) = func_get_args();
                    if (!($defaultValueClosure instanceof Closure)) {
                        throw new \InvalidArgumentException('orElseメソッドの引数はnullではいけない');
                    }

                    if (is_object($this->value)) {
                        return $this->value;
                    } else {
                        return $defaultValueClosure();
                    }
                };
            }
        });
    }
}
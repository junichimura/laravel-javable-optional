<?php


use Illuminate\Support\Optional;

/**
 * this class is example of API Reference.
 * @see \Junichimura\LaravelJavableOptional\JavableOptionalProvider
 *
 * Class MixedOptional
 */
class MixedOptional extends Optional
{
    /**
     * @return mixed
     *
     * @see AnonymousClass::get() in \Junichimura\LaravelJavableOptional\JavableOptionalProvider::register()
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * @return bool
     * @see AnonymousClass::isPresent() in \Junichimura\LaravelJavableOptional\JavableOptionalProvider::register()
     */
    public function isPresent()
    {
        return isset($this->value);
    }

    /**
     * optionalの値が存在している場合に実行する処理クロージャで渡す。
     *
     * @param Closure $existsClosure
     * @param Closure $notExistsClosure
     * @return mixed
     *
     * @see AnonymousClass::ifPresent() in \Junichimura\LaravelJavableOptional\JavableOptionalProvider::register()
     */
    public function ifPresent($existsClosure, $notExistsClosure)
    {
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
    }

    /**
     * @param mixed $defaultValue
     * @return mixed
     *
     * @see AnonymousClass::orElse() in \Junichimura\LaravelJavableOptional\JavableOptionalProvider::register()
     */
    public function orElse($defaultValue)
    {
        if (!isset($defaultValue)) {
            throw new \InvalidArgumentException('orElseメソッドの引数はnullではいけない');
        }

        if (is_object($this->value)) {
            return $this->value;
        } else {
            return $defaultValue;
        }
    }

    /**
     * @param Closure $defaultValueClosure
     * @return mixed
     *
     * @see AnonymousClass::orElseGet() in \Junichimura\LaravelJavableOptional\JavableOptionalProvider::register()
     */
    public function orElseGet($defaultValueClosure)
    {
        if (!($defaultValueClosure instanceof Closure)) {
            throw new \InvalidArgumentException('orElseメソッドの引数はnullではいけない');
        }

        if (is_object($this->value)) {
            return $this->value;
        } else {
            return $defaultValueClosure();
        }
    }
}
<?php

namespace NormanHuth\Muetze\Traits;

trait EncryptsAttributes
{
    /**
     * @return mixed
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();
        foreach ($this->getEncrypts() as $key) {
            if (array_key_exists($key, $attributes) && $attributes[$key]) {
                $attributes[$key] = decrypt($attributes[$key]);
            }
        }
        return $attributes;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getAttributeValue($key)
    {
        if (in_array($key, $this->getEncrypts())) {
            if ($this->attributes[$key]) {
                return decrypt($this->attributes[$key]);
            }
        }
        return parent::getAttributeValue($key);
    }

    /**
     * @param $key
     * @param $value
     * @return string
     */
    public function setAttribute($key, $value): string
    {
        if (in_array($key, $this->getEncrypts())) {
            return $this->attributes[$key] = encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * @return array
     */
    protected function getEncrypts(): array
    {
        return property_exists($this, 'encrypts') ? $this->encrypts : [];
    }
}

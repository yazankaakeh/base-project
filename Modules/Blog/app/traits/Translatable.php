<?php

namespace Modules\Blog\App\traits;

trait Translatable
{

  /**
   * Get the translation for the given locale.
   *
   * @param string $locale
   * @param string $attribute
   * @return mixed|null
   */
  public function getTranslation(string $locale, string $attribute): mixed
  {
    $translations = $this->{$this->translationRelation}->where('locale', $locale)->first();

    if ($translations) {
      return $translations->{$attribute};
    }

    return null;
  }

  /**
   * Store or update the translation for the given locale.
   *
   * @param string $locale
   * @param array $attributes
   * @return void
   */
  public function storeOrUpdateTranslation(string $locale, array $attributes): void
  {
    $translation = $this->{$this->translationRelation}->where('locale', $locale)->first();

    if ($translation) {
      $translation->update($attributes);
    } else {
      $data = array_merge(['locale' => $locale], $attributes);
      $data = array_merge([$this->foreignKey => $this->id], $data);
      $this->{$this->translationRelation}()->create($data);
    }
  }

  /**
   * delete by locale or delete all the translation.
   *
   * @param string|null $locale
   * @return void
   */
  public function deleteTranslation(?string $locale = null): void
  {
    if ($locale) {
      $this->{$this->translationRelation}->where('locale', $locale)->firstOrfial()->delete();
      return;
    }
    $data = $this->{$this->translationRelation};
    foreach ($data as $translation) {
      $translation->delete();
    }
  }
}

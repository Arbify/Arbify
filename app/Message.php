<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InvalidArgumentException;

class Message extends Model
{
    public const TYPE_MESSAGE = 'message';
    public const TYPE_PLURAL  = 'plural';
    public const TYPE_GENDER  = 'gender';

    private const TYPES = [
        self::TYPE_MESSAGE => 0,
        self::TYPE_PLURAL  => 1,
        self::TYPE_GENDER  => 2,
    ];

    protected $fillable = [
        'name', 'description', 'type'
    ];

    public function isMessage(): bool
    {
        return $this->type == self::TYPE_MESSAGE;
    }

    public function isPlural(): bool
    {
        return $this->type == self::TYPE_PLURAL;
    }

    public function isGender(): bool
    {
        return $this->type == self::TYPE_GENDER;
    }

    public function getTypeAttribute($type): string
    {
        return array_flip(self::TYPES)[$type];
    }

    public function setTypeAttribute($value): void
    {
        if (!array_key_exists($value, self::TYPES)) {
            throw new InvalidArgumentException("There's no $value message type.");
        }

        $this->attributes['type'] = self::TYPES[$value];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function messageValues(): HasMany
    {
        return $this->hasMany(MessageValue::class);
    }

    public function forLanguage(Language $language, string $form = ''): ?MessageValue
    {
        /** @var MessageValue|null $messageValue */
        $messageValue = $this->messageValues()
            ->where('language_id', '=', $language->id)
            ->where('form', '=', $form)
            ->first();

        return $messageValue;
    }

    public function valueForLanguage(Language $language, string $form = ''): string
    {
        $messageValue = $this->forLanguage($language, $form);

        return is_null($messageValue) ? '' : $messageValue->value;
    }
}

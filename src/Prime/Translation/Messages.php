<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

final class Messages
{
    /**
     * @var array<string, string>
     */
    public static array $ar = [
        'success' => 'نجاح',
        'error' => 'خطأ',
        'warning' => 'تحذير',
        'info' => 'معلومة',

        'The resource was created' => 'تم إنشاء :resource',
        'The resource was updated' => 'تم تعديل :resource',
        'The resource was saved' => 'تم حفظ :resource',
        'The resource was deleted' => 'تم حذف :resource',

        'resource' => 'الملف',
    ];

    /**
     * @var array<string, string>
     */
    public static array $en = [
        'success' => 'Success',
        'error' => 'Error',
        'warning' => 'Warning',
        'info' => 'Info',

        'The resource was created' => 'The :resource was created',
        'The resource was updated' => 'The :resource was updated',
        'The resource was saved' => 'The :resource was saved',
        'The resource was deleted' => 'The :resource was deleted',

        'resource' => 'resource',
    ];

    /**
     * @var array<string, string>
     */
    public static array $fr = [
        'success' => 'Succès',
        'error' => 'Erreur',
        'warning' => 'Avertissement',
        'info' => 'Information',

        'The resource was created' => 'La ressource :resource a été ajoutée',
        'The resource was updated' => 'La ressource :resource a été mise à jour',
        'The resource was saved' => 'La ressource :resource a été enregistrée',
        'The resource was deleted' => 'La ressource :resource a été supprimée',

        'resource' => '',
    ];
}

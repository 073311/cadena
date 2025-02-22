<ovds-edit-item-columns
    type="{{ $type }}"
    :edit-column="{{ json_encode([
        'status' => true,
        'text' => trans('documents.edit_columns'),
        'new_text' => trans('modules.new'),
        'buttons' => [
            'cancel' => [
                'text' => trans('general.cancel'),
                'class' => 'btn-outline-secondary',
            ],
            'confirm' => [
                'text' => trans('general.save'),
                'class' => 'disabled:bg-green-100',
            ]
        ]
    ]) }}"
></ovds-edit-item-columns>

<?php

return [
    'required' => ':attributeは必須です。',
    'string' => ':attributeは文字列で入力してください。',
    'max' => [
        'string' => ':attributeは:max文字以内で入力してください。',
    ],
    'unique' => ':attributeはすでに使用されています。',
    'date' => ':attributeは正しい日付を入力してください。',
    'url' => ':attributeは正しいURLを入力してください。',
    'array' => ':attributeは配列で入力してください。',
    'exists' => '選択された:attributeは存在しません。',

    'attributes' => [
        'title' => 'タイトル',
        'author' => '著者',
        'isbn' => 'ISBN',
        'published_date' => '出版日',
        'description' => '説明',
        'image_url' => '画像URL',
        'genres' => 'ジャンル',
        'genres.*' => 'ジャンル',
    ],
];
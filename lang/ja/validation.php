<?php

return [
    'required' => ':attributeは必須です。',
    'string' => ':attributeは文字列で入力してください。',
    'email' => ':attributeには有効なメールアドレスを入力してください。',
    'unique' => ':attributeはすでに使用されています。',
    'confirmed' => ':attributeの確認が一致しません。',
    'min' => [
        'string' => ':attributeは:min文字以上で入力してください。',
        'numeric' => ':attributeは:min以上で入力してください。',
    ],
    'max' => [
        'string' => ':attributeは:max文字以内で入力してください。',
        'numeric' => ':attributeは:max以下で入力してください。',
    ],
    'between' => [
        'numeric' => ':attributeは:minから:maxの間で入力してください。',
    ],
    'integer' => ':attributeは整数で入力してください。',
    'date' => ':attributeには有効な日付を入力してください。',
    'url' => ':attributeには有効なURLを入力してください。',

    'attributes' => [
        'name' => '名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード確認',
        'title' => 'タイトル',
        'author' => '著者',
        'isbn' => 'ISBN',
        'published_date' => '出版日',
        'description' => '説明',
        'image_url' => '画像URL',
        'genre_id' => 'ジャンル',
        'genre_ids' => 'ジャンル',
        'rating' => '評価',
        'comment' => 'コメント',
    ],
];

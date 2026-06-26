<?php
$file = './data/data.json';
$data = json_decode(file_get_contents($file), true) ?? [];

include('./func.php');

// 旅行名の候補（datalist用）：過去データから重複を除いて取り出す
$tripNames = array_unique(array_column($data, 'trip_name'));
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅費の登録</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Zen+Kaku+Gothic+New:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.typekit.net/rei6chh.css">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div class="container container--narrow">

        <!-- ヘッダー -->
        <header class="page-head">
            <p class="eyebrow">New Record</p>
            <h1>旅費の登録</h1>
        </header>

        <!-- 登録フォーム -->
        <form action="./read.php" method="post" class="card form-card">
            <fieldset class="field-group">

                <div class="field">
                    <label for="trip_name">旅行名</label>
                    <input list="trip-list" id="trip_name" type="text" name="trip_name"
                        autocomplete="off" placeholder="例：京都旅行" required>
                    <!-- 旅の名前を動的に生成してレコメンド -->
                    <datalist id="trip-list">
                        <?php foreach ($tripNames as $name): ?>
                            <option value="<?= h($name) ?>">
                            <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="field">
                    <label for="expense_date">支出日</label>
                    <input type="date" id="expense_date" name="expense_date" required>
                </div>

                <div class="field">
                    <fieldset class="category-group">
                        <legend>カテゴリ</legend>
                        <div class="radio-row">
                            <label class="radio"><input type="radio" name="category" value="交通" required> 交通</label>
                            <label class="radio"><input type="radio" name="category" value="宿"> 宿</label>
                            <label class="radio"><input type="radio" name="category" value="食事"> 食事</label>
                            <label class="radio"><input type="radio" name="category" value="観光"> 観光</label>
                            <label class="radio"><input type="radio" name="category" value="買物"> 買物</label>
                        </div>
                    </fieldset>
                </div>

                <div class="field">
                    <label for="amount">金額</label>
                    <div class="amount-input">
                        <input type="number" id="amount" name="amount" min="0" placeholder="0" required>
                        <span class="unit">円</span>
                    </div>
                </div>

                <div class="field">
                    <label for="memo">メモ <span class="optional">任意</span></label>
                    <input type="text" id="memo" name="memo" placeholder="例：新幹線（東京→京都）">
                </div>

            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn-primary">登録する</button>
                <!-- クリック → read.php へGETでアクセス -->
                <a href="./read.php" class="btn-link">一覧を見る →</a>
            </div>
        </form>

    </div>
</body>

</html>
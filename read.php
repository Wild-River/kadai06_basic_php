<?php
$file = './data/data.json';
$data = json_decode(file_get_contents($file), true) ?? [];

include('./func.php');

// POSTが来たら保存
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data[] = [
        'trip_name'    => $_POST['trip_name'],
        'expense_date' => $_POST['expense_date'],
        'category'     => $_POST['category'],
        'amount'       => (int)$_POST['amount'],
        'memo'         => $_POST['memo'],
        'created_at'   => date('Y-m-d H:i:s'),
    ];
    file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// ─────────────────────────────────────────────
// 集計（グラフ用）
// ─────────────────────────────────────────────
// カテゴリ別（ドーナツ用）
$byCategory = [];
foreach ($data as $row) {
    $byCategory[$row['category']] = ($byCategory[$row['category']] ?? 0) + $row['amount'];
}
// 旅行別（棒グラフ用）
$byTrip = [];
foreach ($data as $row) {
    $byTrip[$row['trip_name']] = ($byTrip[$row['trip_name']] ?? 0) + $row['amount'];
}
// 総合計
$total = array_sum(array_column($data, 'amount'));
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅費の記録＆合計</title>

    <!-- フォント：見出しはセリフ（Cormorant）、本文は游ゴシック系 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Zen+Kaku+Gothic+New:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.typekit.net/rei6chh.css">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div class="container">

        <!-- ヘッダー -->
        <header class="page-head">
            <p class="eyebrow">Travel Expenses</p>
            <h1>旅費の記録</h1>
            <p class="sub">旅ごとの支出を記録して、内訳を見渡す。</p>
            <a href="./index.php" class="btn-primary header-btn">＋ 旅費を登録</a>
        </header>

        <!-- 総額 -->
        <div class="total-hero">
            <span class="label">Total</span>
            <span class="value"><?= number_format($total) ?><span class="yen">円</span></span>
        </div>

        <!-- グラフ -->
        <div class="charts">
            <div class="card">
                <div class="section-head">
                    <p class="en">By Category</p>
                    <p class="ja">カテゴリ別の内訳</p>
                </div>
                <div id="categoryChart"></div>
            </div>

            <div class="card">
                <div class="section-head">
                    <p class="en">By Trip</p>
                    <p class="ja">旅行ごとの合計</p>
                </div>
                <div id="tripChart"></div>
            </div>
        </div>

        <!-- 一覧 -->
        <div class="section-head">
            <p class="en">Records</p>
            <p class="ja">支出の一覧</p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>旅行名</th>
                        <th>支出日</th>
                        <th>カテゴリ</th>
                        <th class="amount-cell">金額</th>
                        <th>メモ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= h($row['trip_name']) ?></td>
                            <td class="date-cell"><?= h($row['expense_date']) ?></td>
                            <td><span class="tag"><?= h($row['category']) ?></span></td>
                            <td class="amount-cell"><?= number_format($row['amount']) ?> 円</td>
                            <td class="memo-cell"><?= h($row['memo']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">合計</td>
                        <td class="amount-cell"><?= number_format($total) ?> 円</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
    <script>
        const byCategory = <?= json_encode($byCategory, JSON_UNESCAPED_UNICODE) ?>;
        const byTrip = <?= json_encode($byTrip, JSON_UNESCAPED_UNICODE) ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="./script.js"></script>
</body>

</html>
<!DOCTYPE html>
<html>
<head>
    <title>予約リマインダー</title>
</head>
<body>
    <p>お世話になっております。{{ $reserve->user->name }} 様。</p>

    <p>本日はご予約当日でございます。下記のご予約内容をお確かめください。</p>

    <p>予約日時: {{ $reserve->time }}</p>
    <p>店舗名: {{ $reserve->shop->name }}</p>
    <p>人数: {{ $reserve->people }} 人</p>

    <p>ご来店を心よりお待ちしております。</p>
</body>
</html>

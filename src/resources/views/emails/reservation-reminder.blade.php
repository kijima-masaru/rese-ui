<!DOCTYPE html>
<head>
    <title>予約リマインダー</title>
</head>
<body>
    <p>お世話になっております。{{ $reservation->user->name }} 様。</p>

    <p>本日はご予約当日でございます。下記のご予約内容をお確かめください。</p>

    <p>予約日時: {{ $reservation->time }}</p>
    <p>店舗名: {{ $reservation->shop->name }}</p>
    <p>人数: {{ $reservation->people }} 人</p>

    <p>ご来店を心よりお待ちしております。</p>
</body>
</html>

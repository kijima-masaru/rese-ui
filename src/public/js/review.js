// 選択された評価をクッキーに保存
const setRatingCookie = (rating) => {
    document.cookie = `rating=${rating}; path=/;`;
}

// クッキーから評価を取得して設定
    const getRatingCookie = () => {
        const cookies = document.cookie.split(';');
        for (const cookie of cookies) {
            const [name, value] = cookie.split('=');
            if (name.trim() === 'rating') {
                return parseInt(value);
            }
        }
        return 0; // デフォルトの評価（初回アクセス時など）
}

// ページ読み込み時に評価を復元
    window.addEventListener('load', () => {
        const ratingInput = document.getElementById('rating');
        const stars = document.querySelectorAll('.star');
        const savedRating = getRatingCookie();

        // 評価が保存されていれば設定
        if (savedRating >= 1 && savedRating <= 5) {
            ratingInput.value = savedRating;
            stars.forEach(star => {
                const starRating = parseInt(star.getAttribute('data-rating'));
                if (starRating <= savedRating) {
                    star.textContent = '★';
                } else {
                    star.textContent = '☆';
                }
            });
        }

        // 星をクリックしたときに評価を保存
        stars.forEach(star => {
            star.addEventListener('click', () => {
                const rating = parseInt(star.getAttribute('data-rating'));
                ratingInput.value = rating;

                // 星の評価を変更
                stars.forEach(s => {
                    if (parseInt(s.getAttribute('data-rating')) <= rating) {
                        s.textContent = '★';
                    } else {
                        s.textContent = '☆';
                    }
                });

                // 評価をクッキーに保存
                setRatingCookie(rating);
            });
        });
    });
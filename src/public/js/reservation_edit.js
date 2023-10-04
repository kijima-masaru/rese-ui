document.addEventListener("DOMContentLoaded", function () {
            // 日付と時間の入力要素を取得
            var dateInput = document.querySelector('input[name="day"]');
            var timeInput = document.querySelector('input[name="time"]');

            // 現在の日付と時間を取得
            var now = new Date();
            var currentYear = now.getFullYear();
            var currentMonth = (now.getMonth() + 1).toString().padStart(2, '0');
            var currentDay = now.getDate().toString().padStart(2, '0');
            var currentHour = now.getHours().toString().padStart(2, '0');
            var currentMinute = now.getMinutes().toString().padStart(2, '0');

            // 最小日付を今日の日付に設定
            dateInput.min = currentYear + '-' + currentMonth + '-' + currentDay;

            // 日付が今日の場合、時間の最小値を現在の時間に設定
            dateInput.addEventListener('change', function () {
                if (dateInput.value === (currentYear + '-' + currentMonth + '-' + currentDay)) {
                timeInput.min = currentHour + ':' + currentMinute;
                } else {
                    // 日付が変更された場合、時間の最小値をクリア
                    timeInput.min = '';
                }
            });
        });

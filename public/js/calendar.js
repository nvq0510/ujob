document.addEventListener('DOMContentLoaded', function() {
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    
    const monthNames = ["1月", "2月", "3月", "4月", "5月", "6月",
                       "7月", "8月", "9月", "10月", "11月", "12月"];
    
    function updateCalendar() {
        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());
        
        document.getElementById('monthYear').textContent = 
            `${currentYear}年 ${monthNames[currentMonth]}`;
        
        const calendarDays = document.getElementById('calendarDays');
        calendarDays.innerHTML = '';
        
        for (let i = 0; i < 42; i++) {
            const date = new Date(startDate);
            date.setDate(date.getDate() + i);
            
            const dateDiv = document.createElement('div');
            dateDiv.className = 'calendar-date';
            
            if (date.getMonth() !== currentMonth) {
                dateDiv.classList.add('other-month');
            }
            
            if (date.toDateString() === new Date().toDateString()) {
                dateDiv.classList.add('today');
            }
            
            const dateNumber = document.createElement('div');
            dateNumber.className = 'date-number';
            dateNumber.textContent = date.getDate();
            dateDiv.appendChild(dateNumber);
            
            // 仮のイベントドット (実際のイベントデータに基づいて表示)
            if (Math.random() < 0.3) { // 30%の確率でイベントを表示
                const eventDot = document.createElement('div');
                eventDot.className = 'event-dot';
                dateDiv.appendChild(eventDot);
            }
            
            dateDiv.addEventListener('click', () => {
                // クリックイベントの処理
                alert(`${currentYear}年${currentMonth + 1}月${date.getDate()}日が選択されました`);
            });
            
            calendarDays.appendChild(dateDiv);
        }
    }
    
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        updateCalendar();
    });
    
    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendar();
    });
    
    // イベントの表示/非表示を切り替える
    window.toggleEvents = function() {
        const eventDots = document.querySelectorAll('.event-dot');
        eventDots.forEach(dot => {
            dot.style.display = dot.style.display === 'none' ? 'block' : 'none';
        });
    };
    
    // 週末の表示/非表示を切り替える
    window.toggleWeekends = function() {
        const weekends = document.querySelectorAll('.calendar-date:nth-child(7n), .calendar-date:nth-child(7n+1)');
        weekends.forEach(weekend => {
            weekend.style.display = weekend.style.display === 'none' ? 'block' : 'none';
        });
    };
    
    // カレンダーをエクスポート
    window.exportCalendar = function() {
        alert('カレンダーのエクスポート機能は開発中です。');
    };
    
    // 初期表示
    updateCalendar();
});
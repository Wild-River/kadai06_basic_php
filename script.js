// #14a7cc を基準にした同系統パレット（統一感を出す）
const palette = ['#14a7cc', '#3fbdda', '#7ad3e6', '#0f8aa9', '#a8e2ee', '#5cc4dd'];

// ── ① カテゴリ別ドーナツ ──
// Object.keys / Object.values で連想配列をラベルと値の配列に分ける
new ApexCharts(document.querySelector('#categoryChart'), {
    chart: { type: 'donut', height: 300, fontFamily: '"din-2014", sans-serif' },
    series: Object.values(byCategory),
    labels: Object.keys(byCategory),
    colors: palette,
    legend: { position: 'bottom', fontSize: '13px' },
    dataLabels: {
        formatter: (val) => val.toFixed(0) + '%',  // パーセント表示（小数なし）
        dropShadow: { enabled: false }
    },
    plotOptions: {
        pie: {
            donut: { size: '64%' },
            expandOnClick: false
        }
    },
    tooltip: {
        y: { formatter: (val) => val.toLocaleString() + ' 円' }
    },
    stroke: { width: 2, colors: ['#ffffff'] },
    states: {
        hover: { filter: { type: 'none' } },
        active: { filter: { type: 'none' } }
    }
}).render();

// ── ② 旅行別の棒グラフ ──
new ApexCharts(document.querySelector('#tripChart'), {
    chart: { type: 'bar', height: 300, fontFamily: '"din-2014", sans-serif', toolbar: { show: false } },
    series: [{ name: '合計', data: Object.values(byTrip) }],
    xaxis: { categories: Object.keys(byTrip) },
    colors: ['#14a7cc'],
    plotOptions: {
        bar: { borderRadius: 6, columnWidth: '45%', distributed: false }
    },
    dataLabels: {
        enabled: true,
        formatter: (val) => val.toLocaleString(),
        style: { colors: ['#fff'] },
    },
    yaxis: {
        labels: { formatter: (val) => (val / 1000) + 'k' }  // 千円単位で軸を簡潔に
    },
    grid: { borderColor: '#e6edf0' },
    states: {
        hover: { filter: { type: 'none' } },
        active: { filter: { type: 'none' } }
    }
}).render();
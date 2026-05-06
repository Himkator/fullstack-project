import './bootstrap';

$(document).ready(function(){
    let ad = $("#adBox");
    $("#hideBtn").click(function(){ad.hide(400);});
    $("#showBtn").click(function(){ad.show(400);});
    $("#fadeInBtn").click(function(){ad.fadeIn(500);});
    $("#fadeOutBtn").click(function(){ad.fadeOut(500);});
    $("#fadeToBtn").click(function(){ad.fadeTo(500, 0.5);});
    $("#slideUpBtn").click(function(){ad.slideUp(500);});
    $("#slideDownBtn").click(function(){ad.slideDown(500);});
    $("#animateBtn").click(function(){
        ad
          .animate({ letterSpacing: "4px" }, 500)
          .animate({ letterSpacing: "1px" }, 500);
    });
    $("#stopBtn").click(function(){ad.stop(true,true);});
});

const darkOptions = {
    plugins: {
        legend: { labels: { color: "white" } }
    },
    scales: {
        x: { ticks: { color: "#aaa" }, grid: { color: "#1e1e1e" } },
        y: { beginAtZero: true, ticks: { color: "#aaa" }, grid: { color: "#1e1e1e" } }
    }
};

const bar = document.getElementById("BarChart");
if (bar) {
    new Chart(bar, {
        type: "bar",
        data: {
            labels: ["Red Bull", "Mercedes", "Ferrari", "McLaren", "Alpine", "Racing Bulls", "Aston Martin", "Haas", "Kick Sauber", "Williams"],
            datasets: [{
                label: "2025 Constructors' Points",
                data: [451, 469, 398, 833, 22, 92, 89, 79, 70, 137],
                backgroundColor: ["#3671C6","#27F4D2","#E8002D","#FF8000","#0093CC","#6692FF","#358C75","#B6BABD","#52E252","#64C4FF"],
                borderRadius: 3,
                borderWidth: 0
            }]
        },
        options: darkOptions
    });
}

if (document.getElementById("barChart")) {
    new Chart(document.getElementById("barChart"), {
        type: "bar",
        data: {
            labels: ["Beginner", "Intermediate", "Advanced"],
            datasets: [{ label: "Students", data: [40, 25, 15], backgroundColor: ["#e10600","#ff4d4d","#990000"], borderRadius: 3, borderWidth: 0 }]
        },
        options: darkOptions
    });
}

if (document.getElementById("pieChart")) {
    new Chart(document.getElementById("pieChart"), {
        type: "pie",
        data: {
            labels: ["Men", "Women"],
            datasets: [{ data: [60, 40], backgroundColor: ["#e10600","#444"], borderWidth: 0 }]
        },
        options: { plugins: { legend: { labels: { color: "white" } } } }
    });
}

if (document.getElementById("polarChart")) {
    new Chart(document.getElementById("polarChart"), {
        type: "polarArea",
        data: {
            labels: ["Aerodynamics", "Strategy", "Driving", "Telemetry"],
            datasets: [{ data: [20, 15, 25, 10], backgroundColor: ["#e10600","#ff4d4d","#990000","#660000"], borderWidth: 0 }]
        },
        options: {
            plugins: { legend: { labels: { color: "white" } } },
            scales: { r: { ticks: { color: "#aaa", backdropColor: "transparent" }, grid: { color: "#1e1e1e" } } }
        }
    });
}

if (document.getElementById("lineChart")) {
    new Chart(document.getElementById("lineChart"), {
        type: "line",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May"],
            datasets: [{ label: "New Students", data: [5, 10, 8, 15, 20], borderColor: "#e10600", backgroundColor: "rgba(225,6,0,0.15)", fill: true, tension: 0.4, pointBackgroundColor: "#e10600" }]
        },
        options: darkOptions
    });
}


function handleRegister() {
    const firstName = document.getElementById('firstName').value.trim();
    const lastName  = document.getElementById('lastName').value.trim();
    const email     = document.getElementById('email').value.trim();
    const username  = document.getElementById('username').value.trim();
    const password  = document.getElementById('password').value;
    const confirm   = document.getElementById('confirmPassword').value;
    const err       = document.getElementById('flashError');
    const ok        = document.getElementById('flashSuccess');

    err.classList.add('d-none');
    ok.classList.add('d-none');

    if (!firstName || !lastName || !email || !username || !password) {
        err.textContent = 'Please fill in all required fields.';
        err.classList.remove('d-none');
        return;
    }
    if (password !== confirm) {
        err.textContent = 'Passwords do not match.';
        err.classList.remove('d-none');
        return;
    }

    ok.textContent = 'Account created! Redirecting to login…';
    ok.classList.remove('d-none');
    setTimeout(() => { window.location.href = 'login.php'; }, 1800);
}
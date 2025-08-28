<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>IQ Test — Start</title>
  <style>
    /* Internal CSS - polished, modern look */
    :root{
      --bg:#0f1724;
      --card:#0b1220;
      --accent1:#6ee7b7;
      --accent2:#60a5fa;
      --glass: rgba(255,255,255,0.04);
      --muted: #98a2b3;
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: linear-gradient(180deg,#071021 0%, #0f1724 100%);
      color:#e6eef8;
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:24px;
    }
    .wrap{
      width:100%;
      max-width:980px;
      background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
      border-radius:16px;
      padding:28px;
      box-shadow: 0 10px 30px rgba(2,6,23,0.7);
      display:grid;
      grid-template-columns: 1fr 380px;
      gap:24px;
      align-items:center;
    }
    .intro{
      padding:18px;
    }
    h1{ margin:0 0 8px; font-size:28px; letter-spacing:-0.4px;}
    p.lead{ color:var(--muted); margin:8px 0 18px; line-height:1.5;}
    .features{
      display:flex;
      gap:12px;
      flex-wrap:wrap;
      margin-top:10px;
    }
    .chip{
      background:var(--glass);
      padding:8px 12px;
      border-radius:999px;
      font-size:13px;
      color:var(--muted);
      border: 1px solid rgba(255,255,255,0.03);
    }
 
    .card{
      background: linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.01));
      border-radius:12px;
      padding:18px;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.02), 0 6px 18px rgba(2,6,23,0.6);
      border: 1px solid rgba(255,255,255,0.03);
    }
 
    .cta{
      display:flex;
      gap:12px;
      align-items:center;
      margin-top:18px;
    }
    .start-btn{
      background: linear-gradient(90deg,var(--accent1),var(--accent2));
      color:#06202a;
      border:none;
      padding:14px 18px;
      border-radius:12px;
      font-weight:700;
      font-size:15px;
      cursor:pointer;
      box-shadow: 0 8px 20px rgba(96,165,250,0.12);
    }
    .note{
      color:var(--muted);
      font-size:13px;
    }
 
    .info-panel{
      padding:20px;
      text-align:left;
    }
    .stat{
      display:flex;
      justify-content:space-between;
      margin:10px 0;
      align-items:center;
    }
    .stat strong{ font-size:20px; }
    footer{
      margin-top:18px;
      color:var(--muted);
      font-size:13px;
    }
    @media (max-width:920px){
      .wrap{ grid-template-columns: 1fr; padding:18px;}
      .info-panel{ order:-1; }
    }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="intro card">
      <h1>Online IQ Test</h1>
      <p class="lead">Measure aspects of your intelligence — logical reasoning, pattern recognition, and numerical problem solving. This short test gives an approximate IQ score and personalized feedback.</p>
 
      <div class="features">
        <div class="chip">12 multiple-choice questions</div>
        <div class="chip">Responsive & fast</div>
        <div class="chip">Results with feedback</div>
      </div>
 
      <div class="cta">
        <button id="startBtn" class="start-btn">Start Test ▶</button>
        <div class="note">Takes ~5–10 minutes. Save results to your account.</div>
      </div>
 
      <footer>
        Roll No: <strong>175</strong> — Level 1, Batch 5 Student
      </footer>
    </div>
 
    <aside class="card info-panel">
      <h3 style="margin:0 0 8px">How the test works</h3>
      <p class="note">Answer all questions. Each correct answer gives 1 point. Score is converted to an IQ estimate (approx.) and saved to the database if you provide name/email at the end.</p>
 
      <div class="stat">
        <span class="note">Questions</span>
        <strong>12</strong>
      </div>
 
      <div class="stat">
        <span class="note">Score Range</span>
        <strong>70 — 130 IQ</strong>
      </div>
 
      <div style="margin-top:12px; font-size:13px; color:var(--muted)">
        Your database: <br><code>dbfgskx8wwgzck</code>
      </div>
    </aside>
  </div>
 
  <script>
    // Redirect using JavaScript to quiz.php
    document.getElementById('startBtn').addEventListener('click', function(){
      // use JS redirect to quiz page
      window.location.href = 'quiz.php';
    });
  </script>
</body>
</html>

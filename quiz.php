<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>IQ Test — Quiz</title>
  <style>
    /* Internal CSS: attractive test UI */
    :root{
      --bg:#071423;
      --card:#071827;
      --accent:#7dd3fc;
      --glass: rgba(255,255,255,0.03);
      --muted:#9fb4c9;
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      min-height:100vh;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
      background: linear-gradient(180deg,#041226 0%, #071423 100%);
      color:#eaf3ff;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:20px;
    }
 
    .container{
      width:100%;
      max-width:980px;
      background: linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.01));
      border-radius:14px;
      padding:22px;
      box-shadow: 0 12px 30px rgba(2,6,23,0.7);
      border: 1px solid rgba(255,255,255,0.03);
    }
 
    header{ display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;}
    header h2{ margin:0; font-size:20px;}
    .progress{
      background:rgba(255,255,255,0.03);
      height:10px;
      border-radius:999px;
      overflow:hidden;
      flex:1;
      margin-left:12px;
    }
    .progress > i{
      display:block;
      height:100%;
      width:0%;
      background:linear-gradient(90deg,var(--accent),#60a5fa);
      transition:width .4s ease;
    }
 
    .card{
      margin-top:18px;
      background:var(--card);
      padding:18px;
      border-radius:10px;
      border: 1px solid rgba(255,255,255,0.02);
    }
    .question{
      font-size:18px;
      margin-bottom:12px;
    }
    .options{ display:grid; gap:10px; }
    .opt{
      background:var(--glass);
      padding:12px;
      border-radius:10px;
      cursor:pointer;
      user-select:none;
      border:1px solid rgba(255,255,255,0.02);
    }
    .opt.selected{
      outline: 2px solid rgba(125,211,252,0.15);
      box-shadow: 0 8px 20px rgba(96,165,250,0.08);
      transform: translateY(-2px);
    }
 
    .nav{
      display:flex;
      justify-content:space-between;
      margin-top:16px;
      gap:12px;
    }
    button{
      background: linear-gradient(90deg,#60a5fa, #7dd3fc);
      color:#022029;
      border:none;
      padding:10px 14px;
      border-radius:10px;
      font-weight:600;
      cursor:pointer;
    }
    button.ghost{
      background:transparent;
      color:var(--muted);
      border: 1px solid rgba(255,255,255,0.03);
    }
    .center{ text-align:center; margin-top:14px; color:var(--muted); font-size:13px;}
    @media (max-width:640px){
      .question{ font-size:16px;}
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h2>IQ Test — Question <span id="qIndex">1</span>/<span id="qTotal">12</span></h2>
      <div style="display:flex;align-items:center; gap:8px; width:320px;">
        <div class="progress" aria-hidden="true"><i id="progBar"></i></div>
        <div style="min-width:48px; text-align:right; color:var(--muted)" id="timer">—</div>
      </div>
    </header>
 
    <div class="card">
      <div class="question" id="questionText">Loading...</div>
      <div class="options" id="optionsList"></div>
 
      <div class="nav">
        <button id="prevBtn" class="ghost">← Previous</button>
        <div style="flex:1"></div>
        <button id="nextBtn">Next →</button>
      </div>
 
      <div class="center">You can change answers anytime before finishing. After the last question, click <strong>Finish</strong>.</div>
    </div>
  </div>
 
  <script>
    // Questions array: each question has {q, options:[], correctIndex}
    const QUESTIONS = [
      { q: "Which number completes the sequence: 2, 4, 8, 16, ?", options:["18","24","32","30"], correct:2 },
      { q: "Find the odd one out: Dog, Cat, Elephant, Car", options:["Dog","Cat","Elephant","Car"], correct:3 },
      { q: "If all Bloops are Razzies and all Razzies are Lazzies, are all Bloops definitely Lazzies?", options:["Yes","No","Only sometimes","Cannot tell"], correct:0 },
      { q: "Which shape comes next in pattern? (Imagine: square, triangle, square, triangle, ...)", options:["Circle","Square","Triangle","Pentagon"], correct:2 },
      { q: "What is 15% of 200?", options:["20","25","30","35"], correct:2 },
      { q: "If 3 pencils cost $0.90, how much for 7 pencils?", options:["$2.10","$2.00","$2.30","$1.95"], correct:0 },
      { q: "Complete the analogy: Bird is to Fly as Fish is to ?", options:["Swim","Jump","Run","Glide"], correct:0 },
      { q: "Which number is largest: 0.2, 1/4, 0.19, 21%", options:["0.2","1/4","0.19","21%"], correct:1 },
      { q: "If TOMATO is coded as 5 letters then which is true about APPLE?", options:["5 letters","6 letters","4 letters","3 letters"], correct:0 },
      { q: "Spot the missing number: 7, 14, 11, 22, 19, ?", options:["38","20","28","23"], correct:2 },
      { q: "Which completes the series: AA, BB, CC, ?", options:["DD","CD","DA","BC"], correct:0 },
      { q: "If you rearrange letters 'CIFAIPC' you get a name of a:", options:["Country","City","Animal","Plant"], correct:2 }
    ];
 
    const total = QUESTIONS.length;
    let index = 0;
    const answers = new Array(total).fill(null);
    document.getElementById('qTotal').textContent = total;
 
    const qText = document.getElementById('questionText');
    const opts = document.getElementById('optionsList');
    const qIndexEl = document.getElementById('qIndex');
    const progBar = document.getElementById('progBar');
 
    function renderQuestion(i){
      const it = QUESTIONS[i];
      qIndexEl.textContent = i+1;
      qText.textContent = it.q;
      opts.innerHTML = '';
      it.options.forEach((o, idx) => {
        const d = document.createElement('div');
        d.className = 'opt';
        d.tabIndex = 0;
        d.dataset.idx = idx;
        d.textContent = String.fromCharCode(65+idx) + ". " + o;
        if(answers[i] === idx) d.classList.add('selected');
        d.addEventListener('click', ()=> selectOption(i, idx, d));
        d.addEventListener('keydown', (e)=>{ if(e.key==='Enter') selectOption(i,idx,d); });
        opts.appendChild(d);
      });
      updateProgress();
    }
 
    function selectOption(questionIndex, optIndex, element){
      answers[questionIndex] = optIndex;
      // update UI
      const children = opts.querySelectorAll('.opt');
      children.forEach(c=>c.classList.remove('selected'));
      element.classList.add('selected');
    }
 
    document.getElementById('prevBtn').addEventListener('click', ()=>{
      if(index>0){ index--; renderQuestion(index); }
    });
 
    const nextBtn = document.getElementById('nextBtn');
    nextBtn.addEventListener('click', ()=>{
      if(index < total-1){
        index++; renderQuestion(index);
      } else {
        // last question -> finish
        finishTest();
      }
    });
 
    function updateProgress(){
      const answered = answers.filter(a=>a !== null).length;
      const percent = Math.round((answered / total) * 100);
      progBar.style.width = percent + '%';
    }
 
    function finishTest(){
      // compute raw score
      let raw = 0;
      for(let i=0;i<total;i++){
        if(answers[i] === QUESTIONS[i].correct) raw++;
      }
      // IQ mapping: approximate to range 70-130
      const iq = 70 + Math.round((raw/total) * 60); // yields between 70 and 130
      // Prepare feedback
      let feedback = '';
      const pct = (raw/total);
      if(pct >= 0.85) feedback = 'Excellent problem-solving and pattern recognition.';
      else if(pct >= 0.65) feedback = 'Above average cognitive ability with solid reasoning.';
      else if(pct >= 0.4) feedback = 'Average. Practice logic & numeric puzzles to improve.';
      else feedback = 'Below average. Try brain-training activities and practice reasoning tasks.';
 
      // Ask user for name/email before saving
      const name = prompt("Enter your name to save the result (or leave blank to skip):", "");
      const email = name ? prompt("Enter email (optional):", "") : '';
 
      // Prepare payload
      const payload = {
        name: name ? name.trim() : '',
        email: email ? email.trim() : '',
        raw_score: raw,
        max_score: total,
        iq_score: iq,
        feedback: feedback
      };
 
      // Save result via AJAX (POST) to save_result.php; then redirect to results.php?id=...
      fetch('save_result.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      })
      .then(r => r.json())
      .then(data => {
        if(data && data.success && data.id){
          // Use JS redirect to results page
          window.location.href = 'results.php?id=' + encodeURIComponent(data.id);
        } else {
          // saving failed or skipped: redirect with score in query
          window.location.href = 'results.php?raw=' + raw + '&max=' + total + '&iq=' + iq + '&fb=' + encodeURIComponent(feedback);
        }
      })
      .catch(err=>{
        // On error, fallback to query-string redirect
        window.location.href = 'results.php?raw=' + raw + '&max=' + total + '&iq=' + iq + '&fb=' + encodeURIComponent(feedback);
      });
    }
 
    // Initial render
    renderQuestion(0);
  </script>
</body>
</html>
 

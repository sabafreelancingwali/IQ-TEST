<?php
// results.php
// If ?id= is provided - fetch from DB. Otherwise use query params raw, max, iq, fb
 
function esc($s){ return htmlspecialchars($s ?? '', ENT_QUOTES); }
 
$result = null;
 
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = (int)$_GET['id'];
    require_once 'db.php';
    $stmt = $pdo->prepare("SELECT * FROM iq_test_results WHERE id = :id LIMIT 1");
    $stmt->execute([':id'=>$id]);
    $row = $stmt->fetch();
    if($row){
        $result = $row;
    }
}
 
// fallback from query string
if(!$result){
    $raw = isset($_GET['raw']) ? (int)$_GET['raw'] : null;
    $max = isset($_GET['max']) ? (int)$_GET['max'] : null;
    $iq = isset($_GET['iq']) ? (int)$_GET['iq'] : null;
    $fb = isset($_GET['fb']) ? $_GET['fb'] : '';
    if($raw !== null && $max !== null && $iq !== null){
        $result = [
            'id' => null,
            'name' => '',
            'email' => '',
            'raw_score' => $raw,
            'max_score' => $max,
            'iq_score' => $iq,
            'feedback' => $fb,
            'created_at' => date('Y-m-d H:i:s')
        ];
    } else {
        // nothing to show
        $result = null;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>IQ Test — Results</title>
  <style>
    :root{
      --bg:#081222;
      --card:#071323;
      --accent1:#7ee7a6;
      --accent2:#60a5fa;
      --muted:#9bb6c9;
    }
    body{ margin:0; font-family:Inter,system-ui; background: linear-gradient(180deg,#031226,#071323); color:#eaf3ff; padding:28px; display:flex; justify-content:center;}
    .wrap{ width:100%; max-width:880px; background:linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.01)); border-radius:14px; padding:22px; border:1px solid rgba(255,255,255,0.03); box-shadow: 0 14px 40px rgba(2,6,23,0.7);}
    h1{ margin:0 0 6px; font-size:22px;}
    .meta{ color:var(--muted); margin-bottom:10px; }
    .score-card{ display:flex; gap:18px; align-items:center; flex-wrap:wrap; margin-top:12px;}
    .big{ background: linear-gradient(90deg,var(--accent1),var(--accent2)); color:#022029; padding:18px; border-radius:12px; font-weight:800; font-size:30px; min-width:160px; text-align:center;}
    .details{ flex:1; background:rgba(255,255,255,0.02); padding:16px; border-radius:10px; }
    .details p{ margin:8px 0; color:var(--muted); }
    .actions{ margin-top:14px; display:flex; gap:10px; }
    .btn{ padding:10px 14px; border-radius:10px; border:none; font-weight:700; cursor:pointer; }
    .btn.primary{ background:linear-gradient(90deg,var(--accent2),var(--accent1)); color:#022029; }
    .btn.ghost{ background:transparent; border:1px solid rgba(255,255,255,0.03); color:var(--muted); }
    footer{ margin-top:18px; color:var(--muted); font-size:13px;}
  </style>
</head>
<body>
  <div class="wrap">
    <?php if($result): ?>
      <h1>Test Results</h1>
      <div class="meta">
        <?php if(!empty($result['name'])): ?>
          <strong><?php echo esc($result['name']); ?></strong> • <?php echo esc($result['email']); ?><br>
        <?php endif; ?>
        Taken on <?php echo esc($result['created_at']); ?>
      </div>
 
      <div class="score-card">
        <div class="big">
          IQ <div style="font-size:40px; margin-top:6px;"><?php echo esc($result['iq_score']); ?></div>
        </div>
        <div class="details">
          <p><strong>Raw score:</strong> <?php echo esc($result['raw_score']); ?> / <?php echo esc($result['max_score']); ?></p>
          <p><strong>Feedback:</strong> <?php echo esc($result['feedback']); ?></p>
          <p>Note: This IQ estimate is approximate and based on a short online screening. For an official IQ measure consult a licensed psychologist.</p>
 
          <div class="actions">
            <button class="btn primary" onclick="window.location.href='quiz.php'">Retake Test</button>
            <button class="btn ghost" id="shareBtn">Share Result</button>
          </div>
        </div>
      </div>
 
      <footer>Saved in DB: <?php echo $result['id'] ? 'Yes (id=' . esc($result['id']) . ')' : 'No'; ?></footer>
 
      <script>
        document.getElementById('shareBtn').addEventListener('click', function(){
          const text = `My IQ estimate: <?php echo esc($result['iq_score']); ?> (<?php echo esc($result['raw_score']); ?>/<?php echo esc($result['max_score']); ?>) — try the IQ Test!`;
          if(navigator.share){
            navigator.share({ title:'My IQ result', text }).catch(()=>{ alert('Share canceled'); });
          } else {
            // fallback copy to clipboard
            navigator.clipboard.writeText(text).then(()=> alert('Result copied to clipboard!'));
          }
        })
      </script>
 
    <?php else: ?>
      <h1>No results available</h1>
      <p class="meta">No valid result ID or score provided. Start the test to get a result.</p>
      <button class="btn primary" onclick="window.location.href='index.php'">Go to Homepage</button>
    <?php endif; ?>
  </div>
</body>
</html>

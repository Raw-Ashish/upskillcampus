<?php
$slug = $_GET['slug'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Payment</title>
  <style>
    body {font-family:Arial;background:#0e0e15;color:#fff;margin:0;display:flex;}
    .methods {width:250px;background:#151521;padding:20px;}
    .methods h3 {margin-top:0;}
    .methods button {display:block;width:100%;margin:10px 0;padding:10px;border:none;background:#ff3e83;color:#fff;border-radius:6px;cursor:pointer;}
    .content {flex:1;padding:20px;position:relative;}
    .terms {width:250px;background:#1a1a25;padding:20px;}
    .overlay {position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8);display:none;align-items:center;justify-content:center;}
    .popup {background:#222;padding:20px;border-radius:12px;max-width:400px;text-align:center;}
    .popup img {max-width:200px;margin:10px auto;display:block;}
    .close-btn {background:#ff3e83;border:none;padding:8px 15px;margin-top:15px;color:#fff;border-radius:6px;cursor:pointer;}
  </style>
</head>
<body>

  <div class="methods">
    <h3>Payment Methods</h3>
    <button onclick="showPayment('upi')">UPI</button>
    <button onclick="showPayment('binance')">Binance</button>
    <button onclick="showPayment('crypto')">Crypto</button>
  </div>

  <div class="content">
    <h2>Complete your purchase</h2>
    <p>Selected content slug: <strong><?php echo htmlspecialchars($slug); ?></strong></p>
  </div>

  <div class="terms">
    <h3>Terms & Conditions</h3>
    <p>✅ Payments are non-refundable.<br>
       ✅ Access will be activated within 10 mins.<br>
       ✅ Contact support if issues occur.<br>
    </p>
  </div>

  <!-- Overlay popup -->
  <div class="overlay" id="overlay">
    <div class="popup" id="popup-content">
      <!-- Filled by JS -->
    </div>
  </div>

  <script>
    function showPayment(type){
      let content = '';
      if(type === 'upi'){
        content = `
          <h3>Pay via UPI</h3>
          <img src="/assets/qr/upi.png" alt="UPI QR">
          <p>UPI ID: <strong>yourupi@okbank</strong></p>
        `;
      } else if(type === 'binance'){
        content = `
          <h3>Pay via Binance</h3>
          <img src="/assets/qr/binance.png" alt="Binance QR">
          <p>Wallet: <strong>0x12345abcde</strong></p>
        `;
      } else if(type === 'crypto'){
        content = `
          <h3>Pay via Crypto</h3>
          <img src="/assets/qr/crypto.png" alt="Crypto QR">
          <p>BTC Address: <strong>1BitcoinAddr...</strong></p>
        `;
      }
      document.getElementById('popup-content').innerHTML = content + `<br><button class="close-btn" onclick="closePopup()">Close</button>`;
      document.getElementById('overlay').style.display = 'flex';
    }

    function closePopup(){
      document.getElementById('overlay').style.display = 'none';
    }
  </script>
</body>
</html>

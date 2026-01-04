<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<!DOCTYPE html>
<html>
    <head>
         <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">




<style>
body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #fff;
      color: #333;
    }

    .support-section {
      display: flex;
      justify-content: space-between;
      gap: 40px;
      padding: 40px 80px;
      border-top: 1px solid #eee;
      border-bottom: 1px solid #eee;
      font-size: 14px;
    }

    .support-box {
      flex: 1;
    }

    .support-box h4 {
      font-size: 13px;
      text-transform: uppercase;
      font-weight: bold;
      margin-bottom: 10px;
      letter-spacing: 1px;
    }

    .support-box p {
      margin: 8px 0;
      line-height: 1.5;
      color: #555;
    }

    .support-box a {
      color: #0066cc;
      text-decoration: underline;
    }

    /* Input styles */
    .input-row {
      display: flex;
      align-items: center;
      border-bottom: 1px solid #333;
      padding: 6px 0;
      margin-top: 12px;
      max-width: 250px;
    }

    .input-row input {
      flex: 1;
      border: none;
      outline: none;
      font-size: 14px;
      padding: 4px;
    }

    .input-row button {
      background: none;
      border: none;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      margin-left: 5px;
    }

    .icon {
      margin-left: 10px;
      cursor: pointer;
    }



   </style>

</head>
<Body>






<h1>EXCLUSIVES</h1>

<!-- Tabs with images -->
<div class="tabs">
    <div class="tab active" data-tab="fragrance">
        <img src="/Website/img/frag.png" alt="Fragrance"> Fragrance
    </div>
    <div class="tab" data-tab="makeup">
        <img src="/Website/img/makeup.png" alt="Makeup"> Makeup
    </div>
    <div class="tab" data-tab="skincare">
        <img src="/Website/img/skin.png" alt="Skincare"> Skincare
    </div>
</div>



<!-- Fragrance -->
<div class="products fragrance active">
    
    <div class="product">
        <img src="/Website/img/new1.webp" alt="BLEU DE CHANEL L’EXCLUSIF">
        <h3>BLEU DE CHANEL L’EXCLUSIF</h3>
        <p>Parfum Spray</p>
        <p><strong>$120</strong></p>

       <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="ALLURE HOMME ÉDITION BLANCHE">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/allure.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>


    <div class="product">
        <img src="/Website/img/new2.webp" alt="BLEU DE CHANEL L’EXCLUSIF">
        <h3>BLEU DE CHANEL L’EXCLUSIF</h3>
        <p>Parfum Spray</p>
        <p><strong>$95</strong></p>
       <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="CHANCE">
    <input type="hidden" name="price" value="95">
    <input type="hidden" name="image" value="/Website/img/chance.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>


    <div class="product">
        <img src="/Website/img/new3.webp" alt="COCO MADEMOISELLE">
        <h3>COCO MADEMOISELLE</h3>
        <p>Fragrance Primer</p>
        <p><strong>$95</strong></p>
       <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="BLEU DE CHANEL">
    <input type="hidden" name="price" value="95">
    <input type="hidden" name="image" value="/Website/img/deodrant.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

      <div class="product">
        <img src="/Website/img/new4.webp" alt="GABRIELLE CHANEL">
        <h3>GABRIELLE CHANEL</h3>
        <p>Fragrance Primer</p>
        <p><strong>$95</strong></p>
       <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="GARDÉNIA">
    <input type="hidden" name="price" value="95">
    <input type="hidden" name="image" value="/Website/img/gardenia.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

       <div class="product">
        <img src="/Website/img/new5.webp" alt="GABRIELLE CHANEL">
        <h3>GABRIELLE CHANEL</h3>
        <p>Body Oil</p>
        <p><strong>$95</strong></p>
       <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="ALLURE HOMME SPORT">
    <input type="hidden" name="price" value="95">
    <input type="hidden" name="image" value="/Website/img/homme.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

       <div class="product">
        <img src="/Website/img/new6.webp" alt="CHANCE EAU FRAÎCHE">
        <h3>CHANCE EAU FRAÎCHE</h3>
        <p>Body Oil</p>
        <p><strong>$95</strong></p>
      <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="POUR MONSIEUR">
    <input type="hidden" name="price" value="87">
    <input type="hidden" name="image" value="/Website/img/pour.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>
</div>






<!-- Makeup -->
<div class="products makeup">
    <div class="product">
        <img src="/Website/img/neww1.webp" alt="LES 4 OMBRES BOUTONS">
        <h3>LLES 4 OMBRES BOUTONS</h3>
        <p>Multi-Effect Quadra Eyeshadow</p>
         <p>209 - BOUTONS MADEMOISELLE</p>
        <p><strong>$38</strong></p>
       <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="LE VERNIS - 403 - GOLDEN MERMAID">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/le1.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

    <div class="product">
        <img src="/Website/img/neww2.webp" alt="LES 4 OMBRES BOUTONS">
        <h3>LES 4 OMBRES BOUTONS</h3>
        <p>Multi-Effect Quadra Eyeshadow</p>
         <p>229 - BOUTONS STELLAIRE</p>
        <p><strong>$34</strong></p>
       <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="LE VERNIS - 401 - BEACH ICON">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/le2.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

    <div class="product">
        <img src="/Website/img/neww3.webp" alt="LES 4 OMBRES BOUTONS">
        <h3>LES 4 OMBRES BOUTONS</h3>
        <p>Multi-Effect Quadra Eyeshadow</p>
         <p>239 - BOUTONS BAROQUE</p>
        <p><strong>$38</strong></p>
       <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="LE VERNIS - 407 - SUNSET SURFER">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/le3.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

    <div class="product">
        <img src="/Website/img/neww4.webp" alt="LES 4 OMBRES BOUTONS">
        <h3>LES 4 OMBRES BOUTONS</h3>
        <p>Multi-Effect Quadra Eyeshadow</p>
         <p>219 - BOUTONS COUTURE</p>
        <p><strong>$38</strong></p>
        <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="LE VERNIS - 405 - DAZZLING ARTIST">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/le4.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

    <div class="product">
        <img src="/Website/img/neww5.webp" alt="LE VERNIS">
        <h3>LE VERNIS</h3>
        <p>Longwear Nail Colour</p>
         <p>411 - MAGNETIC MUSE</p>
        <p><strong>$38</strong></p>
       <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="LE VERNIS - 411 - MAGNETIC MUSE">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/le5.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

    <div class="product">
        <img src="/Website/img/neww6.webp" alt="SUBLIMAGE L’ESSENCE DE TEINT">
        <h3>SUBLIMAGE L’ESSENCE DE TEINT</h3>
        <p>Ultimate Radiance-Generating Serum</p>
         <p>BD31</p>
        <p><strong>$38</strong></p>
        <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="LE VERNIS - 409 - MIDNIGHT DANCER">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/le6.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

    <div class="product">
        <img src="/Website/img/neww7.webp" alt="SUBLIMAGE L’ESSENCE DE TEINT">
        <h3>SUBLIMAGE L’ESSENCE DE TEINT</h3>
        <p>Ultimate Radiance-Generating Serum</p>
        <p><strong>$38</strong></p>
       <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="MIROIR DOUBLE FACETTE">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/le7.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

</div>










<!-- Skincare -->
<div class="products skincare">
    <div class="product">
        <img src="/Website/img/sub.webp" alt="Sublimage Le Masque">
        <h3>Sublimage Le Masque</h3>
        <p>Ultimate Mask – Regenerates</p>
        <p><strong>$316</strong></p>
        <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="Sublimage Le Masque">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/sub.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>
    <div class="product">
        <img src="/Website/img/vani.webp" alt="L’Huile Vanille">
        <h3>L’Huile Vanille</h3>
        <p>Body Massage Oil</p>
        <p><strong>$230</strong></p>
      <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="L’Huile Vanille">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/vani.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

    <div class="product">
        <img src="/Website/img/jas.webp" alt="HUILE DE JASMIN">
        <h3>HUILE DE JASMIN</h3>
        <p>Revitalizing Facial Oil With Jasmine</p>
        <p><strong>$230</strong></p>
        <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="HUILE DE JASMIN">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/jas.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

    <div class="product">
        <img src="/Website/img/lift.webp" alt="LE LIFT LOTION">
        <h3>LE LIFT LOTION</h3>
        <p>Smooths – Firms – Plumps</p>
        <p><strong>$230</strong></p>
        <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="LE LIFT LOTION">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/lift.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

    <div class="product">
        <img src="/Website/img/rose.webp" alt="L’HUILE ROSE">
        <h3>L’HUILE ROSE</h3>
        <p>Body Massage Oil</p>
        <p><strong>$230</strong></p>
       <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="L’HUILE ROSE">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/rose.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>

    <div class="product">
        <img src="/Website/img/jasm.webp" alt="L’HUILE JASMIN">
        <h3>L’HUILE JASMIN</h3>
        <p>Body Massage Oil</p>
        <p><strong>$230</strong></p>
        <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="L’HUILE JASMIN">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/jasm.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>



    <div class="product">
        <img src="/Website/img/ori.webp" alt="L’HUILE ORIENT">
        <h3>L’HUILE ORIENT</h3>
        <p>Body Massage Oil</p>
        <p><strong>$230</strong></p>
        <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="L’HUILE ORIENT">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/ori.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
    </div>




    <div class="product">
        <img src="/Website/img/bla.webp" alt="LE BLANC">
        <h3>LE BLANC</h3>
        <p>Rosy Light Drops</p>
        <p><strong>$230</strong></p>
        <form method="POST" action="cart.php">
    <input type="hidden" name="product_name" value="LE BLANC">
    <input type="hidden" name="price" value="120">
    <input type="hidden" name="image" value="/Website/img/bla.webp">
    <button type="submit" class="add-btn">Add to Bag</button>
</form>
        
    </div>

    
</div>

<script>
    const tabs = document.querySelectorAll(".tab");
    const sections = document.querySelectorAll(".products");

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            tabs.forEach(t => t.classList.remove("active"));
            sections.forEach(s => s.classList.remove("active"));

            tab.classList.add("active");
            document.querySelector("." + tab.dataset.tab).classList.add("active");
        });
    });
</script>






<div class="support-section">
    <!-- Contact an Advisor -->
    <div class="support-box">
      <h4>Contact an Advisor</h4>
      <p>
        CHANEL Client Care is available Monday to Sunday, 7 AM to 12 AM ET. to answer all your questions.
      </p>
      <p>
        Please <a href="#">email us</a>, call <a href="#">1.800.550.0005</a> or live chat with a CHANEL Advisor.
      </p>
    </div>

    <!-- Find a Store -->
<div class="support-box">
  <h4>Find a Store</h4>
  <p>Enter a location to find the closest CHANEL stores</p>
  <form method="POST" action="save_data.php">
    <div class="input-row">
      <input type="text" name="postal_code" placeholder="City or zip code" required>
      <button type="submit" name="save_postal">GO →</button>
    </div>
  </form>
</div>

    <!-- Newsletter -->
<div class="support-box">
  <h4>Newsletter</h4>
  <p>Subscribe to receive news from CHANEL</p>
  <form method="POST" action="/Website/app/View/pages/save_data.php">
    <div class="input-row">
      <input type="email" name="email" placeholder="Enter your email address" required>
      <button type="submit" name="save_email">OK →</button>
    </div>
  </form>
</div>






















</body>
</html>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>